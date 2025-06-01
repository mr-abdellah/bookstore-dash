<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Orders\PurchaseOrderService;

class PurchaseOrderController extends Controller
{
    protected PurchaseOrderService $purchaseOrderService;

    public function __construct(PurchaseOrderService $purchaseOrderService)
    {
        $this->purchaseOrderService = $purchaseOrderService;
    }

    /**
     * Preview purchase order in browser
     */
    public function preview(Order $order)
    {
        $html = $this->purchaseOrderService->generateHtml($order);
        return response($html);
    }

    /**
     * Download purchase order as PDF
     */
    public function download(Order $order)
    {
        return $this->purchaseOrderService->downloadPdf($order);
    }

    /**
     * Stream purchase order PDF (view in browser)
     */
    public function stream(Order $order)
    {
        return $this->purchaseOrderService->streamPdf($order);
    }
}
