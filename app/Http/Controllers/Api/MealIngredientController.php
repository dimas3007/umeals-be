<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealIngredientResource;
use App\Models\MealIngredient;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealIngredientController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meal_id' => 'required|integer',
            'ingredient_id' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

         $mealIngredient = MealIngredient::create([
            'meal_id' => $request->get('meal_id'),
            'ingredient_id' => $request->get('ingredient_id'),
            'quantity' => $request->get('quantity'),
        ]);

        return response()->json([
            'data' => new MealIngredientResource($mealIngredient),
            'message' => 'Meal ingredient created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        $mealIngredient = MealIngredient::where('meal_id', $meal)->get();
        return response()->json([
            'data' => MealIngredientResource::collection($mealIngredient),
            'message' => 'Data meal ingredient found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MealIngredient  $mealIngredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MealIngredient $mealIngredient)
    {
        $validator = Validator::make($request->all(), [
            'meal_id' => 'required|integer',
            'ingredient_id' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

         $mealIngredient->update([
            'meal_id' => $request->get('meal_id'),
            'ingredient_id' => $request->get('ingredient_id'),
            'quantity' => $request->get('quantity'),
        ]);

        return response()->json([
            'data' => new MealIngredientResource($mealIngredient),
            'message' => 'Meal ingredient updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MealIngredient  $mealIngredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(MealIngredient $mealIngredient)
    {
        $mealIngredient->delete();

        return response()->json([
            'data' => [],
            'message' => 'Meal ingredient deleted successfully.',
            'success' => true
        ]);
    }
}
