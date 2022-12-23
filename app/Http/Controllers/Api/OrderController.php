<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function checkout(Request $request) {
         $orderData = $request->all();

        //  echo "<pre>"; print_r(json_decode($dataJson)); echo "</pre>"; die;

        Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount_decimal' => $orderData['order'][0]['total_price'] * 100,
                        'product_data' => [
                            'name' => 'Total Price',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                // 'success_url' => route('checkout.success', [], true) . 
                //                 "?session_id={CHECKOUT_SESSION_ID}&user_id=" . request()->get('user_id') . 
                //                 "&meal_id=" . request()->get('meal_id') . 
                //                 "&amount=" . request()->get('amount') .
                //                 "&payment_method=" . request()->get('payment_method') .
                //                 "&total_price=" . request()->get('total_price') .
                //                 "&special_instruction=" . request()->get('special_instruction') .
                //                 "&delivery_date=" . request()->get('delivery_date') .
                //                 "&discount=" . request()->get('discount') .
                //                 "&tax=" . request()->get('tax') .
                //                 "&shipping=" . request()->get('shipping') .
                //                 "&address_id=" . request()->get('address_id') ,
                'success_url' => route('checkout.success', [], true) . 
                                "?session_id={CHECKOUT_SESSION_ID}&order=" . json_encode($orderData['order']) ,
                'cancel_url' => 'http://localhost:3000/cart',
            ]);

            return response()->json([
                'url' => $session->url
            ]);
        }

        public function success(Request $request) {
            $dataJsonOrder = $request->get('order');
            $dataOrderArray = json_decode($dataJsonOrder);
            $dataOrder = collect($dataOrderArray);
            
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $sessionId = $request->get('session_id');

            try {
                $session = $stripe->checkout->sessions->retrieve($sessionId);

                 if (!$session) {
                    throw new NotFoundHttpException();
                }
                
                    $dataOrder->map(function ($order) {
                        Order::create([
                            'user_id' => $order->user_id,
                            'meal_id' => $order->meal_id,
                            'amount' => $order->amount,
                            'status' => "success",
                            'payment_method' => $order->payment_method,
                            'payment_status' => "paid",
                            'total_price' => $order->total_price,
                            'total_price_product' => $order->total_price_product,
                            'special_instructions' => $order->special_instruction,
                            'delivery_date' => $order->delivery_date,
                            'discount' => $order->discount,
                            'tax' => $order->tax,
                            'shipping' => $order->shipping,
                            'address_id' => $order->address_id,
                            'uuid' => $order->uuid,
                        ]);
                    })->toArray();

                // return response()->json([
                //     'message' => 'Order created successfully',
                //     'success' => true
                // ]);

                return redirect()->away('http://localhost:3000/cart/success');
            } catch (\Exception $e) {
                return response()->json([
                    'data' => [],
                    'message' => $e->getMessage(),
                    'success' => false
                ]);
            }
 
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
            'delivery_date' => 'required|date',
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
            'delivery_date' => $request->get('delivery_date'),
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
            'delivery_date' => 'required|date',
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
            'delivery_date' => $request->get('delivery_date'),
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
