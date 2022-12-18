<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealPlanResource;
use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mealPlans = MealPlan::latest()->get();
        return response()->json([
            'data' => MealPlanResource::collection($mealPlans),
            'message' => 'Fetch all meal plans',
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
            'plan_id' => 'required|integer',
            'meal_id' => 'required|integer',
            'delivery_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $mealPlan = MealPlan::create([
            'plan_id' => $request->get('plan_id'),
            'meal_id' => $request->get('meal_id'),
            'delivery_date' => $request->get('delivery_date')
        ]);

        return response()->json([
            'data' => new MealPlanResource($mealPlan),
            'message' => 'Meal plan created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function show(MealPlan $mealPlan)
    {
        return response()->json([
            'data' => new MealPlanResource($mealPlan),
            'message' => 'Fetch meal plan successfully.',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MealPlan $mealPlan)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|integer',
            'meal_id' => 'required|integer',
            'delivery_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $mealPlan->update([
            'plan_id' => $request->get('plan_id'),
            'meal_id' => $request->get('meal_id'),
            'delivery_date' => $request->get('delivery_date')
        ]);

        return response()->json([
            'data' => new MealPlanResource($mealPlan),
            'message' => 'Meal plan updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();
        return response()->json([
            'data' => [],
            'message' => 'Meal plan deleted successfully.',
            'success' => true
        ]);
    }
}
