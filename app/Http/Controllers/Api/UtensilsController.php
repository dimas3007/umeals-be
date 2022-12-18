<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UtensilResource;
use App\Models\Utensils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Meal;

class UtensilsController extends Controller
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
            'utensil' => 'required|string',
            'meal_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $utensils = Utensils::create([
            'utensil' => $request->get('utensil'),
            'meal_id' => $request->get('meal_id'),
        ]);

        return response()->json([
            'data' => $utensils,
            'message' => 'Post created successfully.',
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
        $utensils = Utensils::where('meal_id', $meal)->get();
        return response()->json([
            'data' => UtensilResource::collection($utensils),
            'message' => 'Fetch all utensils successfully.',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Utensils  $utensils
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Utensils $utensils)
    {
        $validator = Validator::make($request->all(), [
            'utensil' => 'required|string',
            'meal_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $utensils->update([
            'utensil' => $request->get('utensil'),
            'meal_id' => $request->get('meal_id'),
        ]);

        return response()->json([
            'data' => $utensils,
            'message' => 'Post created successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Utensils  $utensils
     * @return \Illuminate\Http\Response
     */
    public function destroy(Utensils $utensils)
    {
        $utensils->delete();

        return response()->json([
            'data' => [],
            'message' => 'Post deleted successfully.',
            'success' => true
        ]);
    }
}
