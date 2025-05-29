<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderService
{
    /**
     * Generate purchase order HTML
     */
    public function generateHtml(Order $order): string
    {
        return View::make('purchase-order.template', [
            'order' => $order,
            'orderNumber' => $this->generateOrderNumber($order),
            'orderDate' => $order->created_at->format('d/m/Y'),
            'supplier' => $this->getSupplierInfo(),
            'client' => $this->getClientInfo($order),
            'items' => $this->getOrderItems($order),
            'totals' => $this->calculateTotals($order),
            'conditions' => $this->getOrderConditions(),
        ])->render();
    }

    /**
     * Generate purchase order PDF
     */
    public function generatePdf(Order $order): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('purchase-order.template', [
            'order' => $order,
            'orderNumber' => $this->generateOrderNumber($order),
            'orderDate' => $order->created_at->format('d/m/Y'),
            'supplier' => $this->getSupplierInfo(),
            'client' => $this->getClientInfo($order),
            'items' => $this->getOrderItems($order),
            'totals' => $this->calculateTotals($order),
            'conditions' => $this->getOrderConditions(),
        ])->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'chroot' => public_path(),
                'encoding' => 'UTF-8',
            ]);
    }

    /**
     * Download purchase order PDF
     */
    public function downloadPdf(Order $order): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generatePdf($order);
        $filename = "bon-commande-{$order->id}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Stream purchase order PDF (view in browser)
     */
    public function streamPdf(Order $order): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generatePdf($order);
        $filename = "bon-commande-{$order->id}.pdf";

        return $pdf->stream($filename);
    }

    /**
     * Generate order number
     */
    private function generateOrderNumber(Order $order): string
    {
        return 'BC-' . date('Y') . '-' . str_pad($order->getKey(), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get supplier information
     */
    private function getSupplierInfo(): array
    {
        return [
            'name' => config('app.supplier.name', 'Media Tech SARL'),
            'address' => config('app.supplier.address', '123 Rue des Livres'),
            'city' => config('app.supplier.city', 'Alger, 16000'),
            'phone' => config('app.supplier.phone', '021 12 34 56'),
            'email' => config('app.supplier.email', 'contact@mediatech.dz'),
            'logo' => config('app.supplier.logo', asset('images/logo.png')),
        ];
    }

    /**
     * Get client information from order
     */
    private function getClientInfo(Order $order): array
    {
        // Clean and encode text fields
        $firstName = mb_convert_encoding($order->first_name ?? '', 'UTF-8', 'UTF-8');
        $lastName = mb_convert_encoding($order->last_name ?? '', 'UTF-8', 'UTF-8');
        $address = mb_convert_encoding($order->address ?? '', 'UTF-8', 'UTF-8');
        $commune = mb_convert_encoding($order->commune ?? '', 'UTF-8', 'UTF-8');
        $wilaya = mb_convert_encoding($order->wilaya ?? '', 'UTF-8', 'UTF-8');

        return [
            'name' => trim($firstName . ' ' . $lastName),
            'address' => $address,
            'city' => trim($commune . ', ' . $wilaya),
            'phone' => $order->phone ?? 'N/A',
            'email' => $order->user->email ?? 'N/A',
        ];
    }

    /**
     * Get formatted order items
     */
    private function getOrderItems(Order $order): array
    {
        return $order->items->map(function ($item, $index) {
            // Clean and encode the title properly
            $title = $item->book->title ?? 'Produit sans titre';
            $title = mb_convert_encoding($title, 'UTF-8', 'UTF-8');

            return [
                'ref' => 'LIV-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'description' => $title,
                'quantity' => $item->quantity,
                'unit_price' => number_format($item->unit_price, 2, ',', ' '),
                'total' => number_format($item->unit_price * $item->quantity, 2, ',', ' '),
            ];
        })->toArray();
    }

    /**
     * Calculate order totals
     */
    private function calculateTotals(Order $order): array
    {
        $subtotal = $order->subtotal;
        $tva = $subtotal * 0.19; // 19% VAT
        $total = $subtotal + $tva;

        return [
            'subtotal' => number_format($subtotal, 2, ',', ' ') . ' DA',
            'tva' => number_format($tva, 2, ',', ' ') . ' DA',
            'total' => number_format($total, 2, ',', ' ') . ' DA',
        ];
    }

    /**
     * Get order conditions
     */
    private function getOrderConditions(): array
    {
        return [
            'Délai de livraison: 7 jours ouvrables',
            'Mode de paiement: Virement bancaire',
            'Validité de l\'offre: 30 jours',
            'Frais de livraison inclus',
        ];
    }
}