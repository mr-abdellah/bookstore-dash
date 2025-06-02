<?php

namespace App\Http\Controllers\Api;

use App\Actions\Orders\CalculateOrderTotalAction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;
use App\Models\Order;
use App\Services\Orders\OrderService;
use App\Services\Orders\PurchaseOrderService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;


class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected CalculateOrderTotalAction $calculateOrderTotalAction,
        protected PurchaseOrderService $purchaseOrderService

    ) {}

    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderService->getUserOrders(
            $request->user(),
            $request->get('per_page', 15)
        );

        return response()->json($orders);
    }

    /**
     * Display the specified order.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $order = Order::with([
                'items.book',
                'items.publishingHouse',
                'user',
                'wilaya:id,name,arabic_name',
                'commune:id,name,arabic_name'
            ])->findOrFail($id);

            $orderTotals = $this->calculateOrderTotalAction->execute($order);

            $order->total = $orderTotals;

            return response()->json([
                'success' => true,
                'data' => $order,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
    }


    /**
     * Download purchase order PDF
     */
    public function downloadPdf(string $id): StreamedResponse|JsonResponse
    {
        try {
            $order = Order::with([
                'items.book',
                'items.publishingHouse',
                'user',
                'wilaya:id,name,arabic_name',
                'commune:id,name,arabic_name'
            ])->findOrFail($id);

            return $this->purchaseOrderService->downloadPdf($order);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or PDF generation failed'
            ], 404);
        }
    }

    /**
     * Stream purchase order PDF (view in browser)
     */
    public function streamPdf(string $id): \Symfony\Component\HttpFoundation\Response|JsonResponse
    {
        try {
            $order = Order::with([
                'items.book',
                'items.publishingHouse',
                'user',
                'wilaya:id,name,arabic_name',
                'commune:id,name,arabic_name'
            ])->findOrFail($id);

            return $this->purchaseOrderService->streamPdf($order);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or PDF generation failed'
            ], 404);
        }
    }


    /**
     * Store a newly created order.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder(
            $request->user(),
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order): JsonResponse
    {

        $this->orderService->deleteOrder($order);

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully',
        ]);
    }
}
