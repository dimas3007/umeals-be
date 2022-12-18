<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::latest()->get();
        return response()->json([
            'data' => PlanResource::collection($plans),
            'message' => 'Fetch all plans',
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
            'preference' => 'required|string',
            'number_of_people' => 'required|integer',
            'receipe_per_week' => 'required|integer',
            'price_per_servings' => 'required|integer',
            'total_price' => 'required|integer',
            'discount' => 'required|integer',
            'tax' => 'required|integer',
            'shipping' => 'required|integer',
            'first_delivery_date' => 'required|date',
            'status' => 'required|string',
            'special_instruction' => 'required|string',
            'address_id' => 'required|integer',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'user_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $plan = Plan::create([
            'preference' => $request->get('preference'),
            'number_of_people' => $request->get('number_of_people'),
            'receipe_per_week' => $request->get('receipe_per_week'),
            'price_per_servings' => $request->get('price_per_servings'),
            'total_price' => $request->get('total_price'),
            'discount' => $request->get('discount'),
            'tax' => $request->get('tax'),
            'shipping' => $request->get('shipping'),
            'first_delivery_date' => $request->get('first_delivery_date'),
            'status' => $request->get('status'),
            'special_instruction' => $request->get('special_instruction'),
            'address_id' => $request->get('address_id'),
            'payment_method' => $request->get('payment_method'),
            'payment_status' => $request->get('payment_status'),
            'user_id' => $request->get('user_id'),
            'status' => $request->get('status'),
        ]);

        return response()->json([
            'data' => new PlanResource($plan),
            'message' => 'Plan created successfully',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return response()->json([
            'data' => new PlanResource($plan),
            'message' => 'Plan fetched successfully',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'preference' => 'required|string',
            'number_of_people' => 'required|integer',
            'receipe_per_week' => 'required|integer',
            'price_per_servings' => 'required|integer',
            'total_price' => 'required|integer',
            'discount' => 'required|integer',
            'tax' => 'required|integer',
            'shipping' => 'required|integer',
            'first_delivery_date' => 'required|date',
            'status' => 'required|string',
            'special_instruction' => 'required|string',
            'address_id' => 'required|integer',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'user_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $plan->update([
            'preference' => $request->get('preference'),
            'number_of_people' => $request->get('number_of_people'),
            'receipe_per_week' => $request->get('receipe_per_week'),
            'price_per_servings' => $request->get('price_per_servings'),
            'total_price' => $request->get('total_price'),
            'discount' => $request->get('discount'),
            'tax' => $request->get('tax'),
            'shipping' => $request->get('shipping'),
            'first_delivery_date' => $request->get('first_delivery_date'),
            'status' => $request->get('status'),
            'special_instruction' => $request->get('special_instruction'),
            'address_id' => $request->get('address_id'),
            'payment_method' => $request->get('payment_method'),
            'payment_status' => $request->get('payment_status'),
            'user_id' => $request->get('user_id'),
            'status' => $request->get('status'),
        ]);

        return response()->json([
            'data' => new PlanResource($plan),
            'message' => 'Plan created successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json([
            'data' => [],
            'message' => 'Plan deleted successfully',
            'success' => true
        ]);
    }
}
