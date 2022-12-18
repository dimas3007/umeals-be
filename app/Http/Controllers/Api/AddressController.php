<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $address = Address::where("user_id", $request->user()->id)->get();
        return response()->json([
            'data' => AddressResource::collection($address),
            'message' => 'Fetch all address',
            'success' => true,
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
            'street_address' => 'required|string|max:155',
            'apt_suite_floor' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'state' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $address = Address::create([
            'street_address' => $request->get('street_address'),
            'apt_suite_floor' => $request->get('apt_suite_floor'),
            'city' => $request->get('city'),
            'zip_code' => $request->get('zip_code'),
            'state' => $request->get('state'),
            'phone' => $request->get('phone'),
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'data' => new AddressResource($address),
            'message' => 'Address created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return response()->json([
            'data' => new AddressResource($address),
            'message' => 'Data address found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $validator = Validator::make($request->all(), [
            'street_address' => 'required|string|max:155',
            'apt_suite_floor' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'state' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $address->update([
            'street_address' => $request->get('street_address'),
            'apt_suite_floor' => $request->get('apt_suite_floor'),
            'city' => $request->get('city'),
            'zip_code' => $request->get('zip_code'),
            'state' => $request->get('state'),
            'phone' => $request->get('phone'),
            'user_id' => $request->user()->id,
        ]);

         return response()->json([
            'data' => new AddressResource($address),
            'message' => 'Address updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();

         return response()->json([
            'data' => [],
            'message' => 'Address deleted successfully',
            'success' => true
        ]);
    }
}
