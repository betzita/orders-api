<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;



/**
* @OA\PathItem(path="/api/v1")
*
* @OA\Info(
*      version="0.0.0",
*      title="kashtnegar API"
*  )
*/
class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    public function index()
    {
        //$this->authorize('viewAny', Order::class);

        $orders = Order::with('client', 'items.product')->get();
        return response()->json($orders);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Crear una nueva orden",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"client_id", "shipping_address", "billing_address", "items"},
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="shipping_address", type="string", example="Calle Falsa 123"),
     *             @OA\Property(property="billing_address", type="string", example="Av Siempre Viva 742"),
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"product_id","quantity"},
     *                     @OA\Property(property="product_id", type="integer", example=5),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Orden creada correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="order", type="object", description="Orden creada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la creación de la orden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Mensaje de error")
     *         )
     *     )
     * )
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->all());
            return response()->json([
                'status'  => 'success',$order], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        //$this->authorize('view', $order);

        $order = Cache::remember("order_{$id}", 300, function () use ($id) {
            return Order::with(['client', 'items.product'])->findOrFail($id);
        });

        return response()->json($order);
    }
}
