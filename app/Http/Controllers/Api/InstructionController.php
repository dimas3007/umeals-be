<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructionResource;
use App\Models\Instruction;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstructionController extends Controller
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
            'instruction' => 'required|string',
            'foto' => 'required|file'
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

            $request->file('foto')->storeAs('public/instruction', $filenamePath);
        }

        $instruction = Instruction::create([
            'meal_id' => $request->get('meal_id'),
            'instruction' => $request->get('instruction'),
            'foto' => $filenamePath,
        ]);

        return response()->json([
            'data' => new InstructionResource($instruction),
            'message' => 'Post created successfully.',
            'success' => true
        ]);
    }

    public function getMealInstructions($meal)
    {
        $instructions = Instruction::where('meal_id', $meal)->get();
        return response()->json([
            'data' => InstructionResource::collection($instructions),
            'message' => 'Fetch all instructions successfully.',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instruction  $instruction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instruction $instruction)
    {
        $validator = Validator::make($request->all(), [
            'meal_id' => 'required|integer',
            'instruction' => 'required|string',
            'foto' => 'required|file'
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

            $request->file('foto')->storeAs('public/instruction', $filenamePath);
        }

        $instruction->update([
            'meal_id' => $request->get('meal_id'),
            'instruction' => $request->get('instruction'),
            'foto' => $request->get('foto'),
        ]);

        if($request->hasFile('foto')) {
            $instruction->update([
                'foto' => $filenamePath,
            ]);
        }

        return response()->json([
            'data' => new InstructionResource($instruction),
            'message' => 'Instruction updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instruction  $instruction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instruction $instruction)
    {
        $instruction->delete();
        return response()->json([
            'data' => [],
            'message' => 'Instruction deleted successfully',
            'success' => true
        ]);
    }
}
