<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\PlatformSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderService
{
    /**
     * Generate purchase order HTML
     */
    public function generateHtml(Order $order): string
    {
        return View::make('purchase-order.template', $this->getViewData($order))->render();
    }

    /**
     * Generate purchase order PDF
     */
    public function generatePdf(Order $order): \Barryvdh\DomPDF\PDF
    {
        $html = $this->generateHtml($order);

        return Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => false, // Disable remote resources for security and performance
                'isHtml5ParserEnabled' => true,
                'chroot' => public_path(),
                'encoding' => 'UTF-8',
                'defaultFont' => 'Arial',
                'fontSubsetting' => true,
                'isFontSubsettingEnabled' => true,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
                'debugLayoutLines' => false,
                'debugLayoutBlocks' => false,
                'debugLayoutInline' => false,
                'debugLayoutPaddingBox' => false,
                'tempDir' => storage_path('app/temp'),
                'fontDir' => storage_path('fonts/'),
                'fontCache' => storage_path('fonts/'),
                'logOutputFile' => storage_path('logs/dompdf.log'),
                'isPhpEnabled' => false, // Disable PHP execution for security
            ]);
    }

    /**
     * Download purchase order PDF
     */
    public function downloadPdf(Order $order): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $pdf = $this->generatePdf($order);
        $filename = "bon-commande-{$order->id}.pdf";

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Stream purchase order PDF (view in browser)
     */
    public function streamPdf(Order $order): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generatePdf($order);
        $filename = "bon-commande-{$order->id}.pdf";

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get all view data for the PDF template
     */
    private function getViewData(Order $order): array
    {
        return [
            'order' => $order,
            'orderNumber' => $this->generateOrderNumber($order),
            'orderDate' => $order->created_at->format('d/m/Y'),
            'supplier' => $this->getSupplierInfo(),
            'client' => $this->getClientInfo($order),
            'items' => $this->getOrderItems($order),
            'totals' => $this->calculateTotals($order),
            'conditions' => $this->getOrderConditions(),
        ];
    }

    /**
     * Generate order number
     */
    private function generateOrderNumber(Order $order): string
    {
        return 'BC-' . date('Y') . '-' . str_pad($order->getKey(), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get supplier information with caching
     */
    private function getSupplierInfo(): array
    {
        return Cache::remember('supplier_info', 3600, function () {
            $settings = PlatformSettings::first();

            return [
                'name' => $settings?->platform_name ?? 'Media Tech SARL',
                'address' => $settings?->address ?? '123 Rue des Livres',
                'city' => $settings?->city ?? 'Alger, 16000',
                'phone' => $settings?->contact_phone ?? '021 12 34 56',
                'email' => $settings?->contact_email ?? 'contact@mediatech.dz',
                'logo' => $settings?->logo ? asset('storage/' . $settings->logo) : asset('images/logo.png'),
            ];
        });
    }

    /**
     * Get client information from order
     */
    private function getClientInfo(Order $order): array
    {
        return [
            'name' => trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? '')),
            'address' => $order->address ?? '',
            'city' => trim(($order->commune->name ?? '') . ', ' . ($order->wilaya->name ?? '')),
            'phone' => $order->phone ?? 'N/A',
            'email' => $order->user?->email ?? 'N/A',
        ];
    }

    /**
     * Get formatted order items
     */
    private function getOrderItems(Order $order): array
    {
        return $order->items->map(function ($item, $index) {
            return [
                'ref' => 'LIV-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'description' => $item->book?->title ?? 'Produit sans titre',
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
