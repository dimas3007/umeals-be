<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredients = Ingredient::latest()->get();
        return response()->json([
            'data' => IngredientResource::collection($ingredients),
            'message' => 'Fetch all Ingredients',
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
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'ingredient' => 'required|string',
            'price' => 'required|integer',
            'foto' => 'file'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $filenamePath = "";
        if($request->hasFile('foto')) {
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();
            $filenamePath = $filename.'_'.time().'.'.$extension;

            $request->file('foto')->storeAs('public/ingredient', $filenamePath);
        }

        // $uploadFolder = 'ingredient';
        // $image = $request->file('foto');
        // $image_uploaded_path = $image->store($uploadFolder, 'public');
        // $img_url = Storage::disk('public')->url($image_uploaded_path);
        // $uploadedImageResponse = array(
        //     "image_name" => basename($image_uploaded_path),
        //     "image_url" => Storage::disk('public')->url($image_uploaded_path),
        //     "mime" => $image->getClientMimeType()
        // );

        $ingredient = Ingredient::create([
            'quantity' => $request->get('quantity'),
            'unit' => $request->get('unit'),
            'ingredient' => $request->get('ingredient'),
            'price' => $request->get('price'),
            'foto' => $filenamePath,
        ]);

        return response()->json([
            'data' => new IngredientResource($ingredient),
            'message' => 'Ingredients created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        return response()->json([
            'data' => new IngredientResource($ingredient),
            'message' => 'Data ingredients found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'ingredient' => 'required|string',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $filenamePath = "";
        if($request->hasFile('foto')) {
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();
            $filenamePath = $filename.'_'.time().'.'.$extension;

            $request->file('foto')->storeAs('public/ingredient', $filenamePath);
        }

        $ingredient->update([
            'quantity' => $request->get('quantity'),
            'unit' => $request->get('unit'),
            'ingredient' => $request->get('ingredient'),
            'price' => $request->get('price'),
        ]);

        if($request->hasFile('foto')) {
            $ingredient->update([
                'foto' => $filenamePath,
            ]);
        }

        return response()->json([
            'data' => new IngredientResource($ingredient),
            'message' => 'Ingredients updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return response()->json([
            'data' => [],
            'message' => 'Ingredient deleted successfully',
            'success' => true
        ]);
    }
}
