<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::latest()->get();
        return response()->json([
            'data' => MealResource::collection($meals),
            'message' => 'Fetch all meals',
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
            'name' => 'required|string',
            'with' => 'required|string',
            'foto' => 'required|file',
            'description' => 'required|string',
            'tags' => 'required|string',
            'allergens' => 'required|string',
            'allergens_description' => 'required|string',
            'total_time' => 'required|string',
            'prep_time' => 'required|string',
            'difficulty' => 'required|string',
            'nutrition_value_id' => 'required|integer',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $meal = Meal::create([
            'name' => $request->get('name'),
            'with' => $request->get('with'),
            'foto' => $request->get('foto'),
            'description' => $request->get('description'),
            'tags' => $request->get('tags'),
            'allergens' => $request->get('allergens'),
            'allergens_description' => $request->get('allergens_description'),
            'total_time' => $request->get('total_time'),
            'prep_time' => $request->get('prep_time'),
            'difficulty' => $request->get('difficulty'),
            'nutrition_value_id' => $request->get('nutrition_value_id'),
            'price' => $request->get('price'),
        ]);

        return response()->json([
            'data' => new MealResource($meal),
            'message' => 'Meal created successfully.',
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
        return response()->json([
            'data' => new MealResource($meal),
            'message' => 'Data meal found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'with' => 'required|string',
            'foto' => 'required|file',
            'description' => 'required|string',
            'tags' => 'required|string',
            'allergens' => 'required|string',
            'allergens_description' => 'required|string',
            'total_time' => 'required|string',
            'prep_time' => 'required|string',
            'difficulty' => 'required|string',
            'nutrition_value_id' => 'required|integer',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $meal->update([
            'name' => $request->get('name'),
            'with' => $request->get('with'),
            'foto' => $request->get('foto'),
            'description' => $request->get('description'),
            'tags' => $request->get('tags'),
            'allergens' => $request->get('allergens'),
            'allergens_description' => $request->get('allergens_description'),
            'total_time' => $request->get('total_time'),
            'prep_time' => $request->get('prep_time'),
            'difficulty' => $request->get('difficulty'),
            'nutrition_value_id' => $request->get('nutrition_value_id'),
            'price' => $request->get('price'),
        ]);

        return response()->json([
            'data' => new MealResource($meal),
            'message' => 'Meal updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();

        return response()->json([
            'data' => [],
            'message' => 'Meal deleted successfully',
            'success' => true
        ]);
    }
}
