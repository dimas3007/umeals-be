<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return response()->json([
            'data' => OrderResource::collection($orders),
            'message' => 'Fetch all orders',
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'meal_id' => 'required|integer',
            'amount' => 'required|integer',
            'status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'total_price' => 'required|integer',
            'special_instruction' => 'required|string',
            'first_delivery_date' => 'required|date',
            'discount' => 'required|integer',
            'tax' => 'required|integer',
            'shipping' => 'required|integer',
            'address_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $order = Order::create([
            'user_id' => $request->get('user_id'),
            'meal_id' => $request->get('meal_id'),
            'amount' => $request->get('amount'),
            'status' => $request->get('status'),
            'payment_method' => $request->get('payment_method'),
            'payment_status' => $request->get('payment_status'),
            'total_price' => $request->get('total_price'),
            'special_instruction' => $request->get('special_instruction'),
            'first_delivery_date' => $request->get('first_delivery_date'),
            'discount' => $request->get('discount'),
            'tax' => $request->get('tax'),
            'shipping' => $request->get('shipping'),
            'address_id' => $request->get('address_id'),
        ]);

        return response()->json([
            'data' => new OrderResource($order),
            'message' => 'Order created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return response()->json([
            'data' => new OrderResource($order),
            'message' => 'Fetch order',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'meal_id' => 'required|integer',
            'amount' => 'required|integer',
            'status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'total_price' => 'required|integer',
            'special_instruction' => 'required|string',
            'first_delivery_date' => 'required|date',
            'discount' => 'required|integer',
            'tax' => 'required|integer',
            'shipping' => 'required|integer',
            'address_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $order->update([
            'user_id' => $request->get('user_id'),
            'meal_id' => $request->get('meal_id'),
            'amount' => $request->get('amount'),
            'status' => $request->get('status'),
            'payment_method' => $request->get('payment_method'),
            'payment_status' => $request->get('payment_status'),
            'total_price' => $request->get('total_price'),
            'special_instruction' => $request->get('special_instruction'),
            'first_delivery_date' => $request->get('first_delivery_date'),
            'discount' => $request->get('discount'),
            'tax' => $request->get('tax'),
            'shipping' => $request->get('shipping'),
            'address_id' => $request->get('address_id'),
        ]);

        return response()->json([
            'data' => new OrderResource($order),
            'message' => 'Order created successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'data' => [],
            'message' => 'Order deleted successfully.',
            'success' => true
        ]);
    }
}
