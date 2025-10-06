<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountyRequest;
use App\Models\City;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = County::all();
            return response()->json(['status' => 200, 'data' => $data]);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountyRequest $request)
    {
        $county = County::create($request->all());

        return response()->json(['county' => $county]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $county = County::findOrFail($id);

        return response()->json([
            'county' => $county
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountyRequest $request, string $id)
    {
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json(['county' => $county]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'Megye eliminálva. 👍',
            'id' => $id
        ]);
    }

    
}
