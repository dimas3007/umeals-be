<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NutritionValueResource;
use App\Models\NutritionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NutritionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nutritionValue = NutritionValue::latest()->get();
        return response()->json([
            'data' => NutritionValueResource::collection($nutritionValue),
            'message' => 'Fetch all posts',
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
            'calories' => 'required|string',
            'saturated_fat' => 'required|string',
            'sugar' => 'required|string',
            'sodium' => 'required|string',
            'protein' => 'required|string',
            'carbohidrates' => 'required|string',
            'fat' => 'required|string',
            'dietary_fiber' => 'required|string',
            'colesterol' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $nutritionValue = NutritionValue::create([
            'calories' => $request->get('calories'),
            'saturated_fat' => $request->get('saturated_fat'),
            'sugar' => $request->get('sugar'),
            'sodium' => $request->get('sodium'),
            'protein' => $request->get('protein'),
            'carbohidrates' => $request->get('carbohidrates'),
            'fat' => $request->get('fat'),
            'dietary_fiber' => $request->get('dietary_fiber'),
            'colesterol' => $request->get('colesterol'),
        ]);

        return response()->json([
            'data' => new NutritionValueResource($nutritionValue),
            'message' => 'Post created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NutritionValue  $nutritionValue
     * @return \Illuminate\Http\Response
     */
    public function show(NutritionValue $nutritionValue)
    {
         return response()->json([
            'data' => new NutritionValueResource($nutritionValue),
            'message' => 'Data nutrition value found',
            'success' => true,
            'id' => $nutritionValue->id,
        ]);
    }

    public function getMealNutrition($nutrition) {
        $nutritionValue = NutritionValue::where('id', $nutrition)->first();
        return response()->json([
            'data' => new NutritionValueResource($nutritionValue),
            'message' => 'Data nutrition value found',
            'success' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NutritionValue  $nutritionValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NutritionValue $nutritionValue)
    {
         $validator = Validator::make($request->all(), [
            'calories' => 'required|string',
            'saturated_fat' => 'required|string',
            'sugar' => 'required|string',
            'sodium' => 'required|string',
            'protein' => 'required|string',
            'carbohidrates' => 'required|string',
            'fat' => 'required|string',
            'dietary_fiber' => 'required|string',
            'colesterol' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $nutritionValue->update([
            'calories' => $request->get('calories'),
            'saturated_fat' => $request->get('saturated_fat'),
            'sugar' => $request->get('sugar'),
            'sodium' => $request->get('sodium'),
            'protein' => $request->get('protein'),
            'carbohidrates' => $request->get('carbohidrates'),
            'fat' => $request->get('fat'),
            'dietary_fiber' => $request->get('dietary_fiber'),
            'colesterol' => $request->get('colesterol'),
        ]);

        return response()->json([
            'data' => new NutritionValueResource($nutritionValue),
            'message' => 'Post created successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NutritionValue  $nutritionValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(NutritionValue $nutritionValue)
    {
            $nutritionValue->delete();
    
            return response()->json([
                'data' => [],
                'message' => 'nutrition Value deleted successfully.',
                'success' => true
            ]);
    }
}
