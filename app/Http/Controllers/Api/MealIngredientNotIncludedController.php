<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealIngredientNotIncludedResource;
use App\Models\MealIngredientNotIncluded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Meal;

class MealIngredientNotIncludedController extends Controller
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
            'ingredient' => 'required|string',
            'amount' => 'required|integer',
            'unit' => 'required|string',
            'contains' => 'required|string',
            'foto' => 'required|file'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

         $mealIngredientNotIncluded = MealIngredientNotIncluded::create([
            'meal_id' => $request->get('meal_id'),
            'ingredient' => $request->get('ingredient'),
            'amount' => $request->get('amount'),
            'unit' => $request->get('unit'),
            'contains' => $request->get('contains'),
            'foto' => $request->get('foto'),
        ]);

        return response()->json([
            'data' => new MealIngredientNotIncludedResource($mealIngredientNotIncluded),
            'message' => 'Meal ingredient not included created successfully.',
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
        $mealIngredientNotIncluded = MealIngredientNotIncluded::where('meal_id', $meal)->get();
        return response()->json([
            'data' => MealIngredientNotIncludedResource::collection($mealIngredientNotIncluded),
            'message' => 'Meal ingredient not included retrieved successfully.',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MealIngredientNotIncluded  $mealIngredientNotIncluded
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MealIngredientNotIncluded $mealIngredientNotIncluded)
    {
        $validator = Validator::make($request->all(), [
            'meal_id' => 'required|integer',
            'ingredient' => 'required|string',
            'amount' => 'required|integer',
            'unit' => 'required|string',
            'contains' => 'required|string',
            'foto' => 'required|file'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

         $mealIngredientNotIncluded->update([
            'meal_id' => $request->get('meal_id'),
            'ingredient' => $request->get('ingredient'),
            'amount' => $request->get('amount'),
            'unit' => $request->get('unit'),
            'contains' => $request->get('contains'),
            'foto' => $request->get('foto'),
        ]);

        return response()->json([
            'data' => new MealIngredientNotIncludedResource($mealIngredientNotIncluded),
            'message' => 'Meal ingredient not included created successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MealIngredientNotIncluded  $mealIngredientNotIncluded
     * @return \Illuminate\Http\Response
     */
    public function destroy(MealIngredientNotIncluded $mealIngredientNotIncluded)
    {
        $mealIngredientNotIncluded->delete();

        return response()->json([
            'data' => [],
            'message' => 'Meal ingredient not included deleted successfully.',
            'success' => true
        ]);
    }
}
