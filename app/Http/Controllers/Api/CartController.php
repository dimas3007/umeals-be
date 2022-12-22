<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carts = Cart::where('user_id', $request->user()->id)->get();
        return response()->json([
            'data' => CartResource::collection($carts),
            'message' => 'Fetch all carts',
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
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $cart = Cart::create([
            'user_id' => $request->user()->id,
            'meal_id' => $request->get('meal_id'),
            'amount' => $request->get('amount'),
        ]);

        return response()->json([
            'data' => new CartResource($cart),
            'message' => 'Cart created successfully.',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $cart->update([
            'amount' => $request->get('amount'),
        ]);

        return response()->json([
            'data' => new CartResource($cart),
            'message' => 'Cart updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

         return response()->json([
            'data' => [],
            'message' => 'Cart deleted successfully',
            'success' => true
        ]);
    }
}
