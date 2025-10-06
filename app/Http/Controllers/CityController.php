<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = City::all();
            return response()->json(['status' => 200, 'data' => $data]);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'postal_code' => 'required|int',
            'name' => 'required|string',
            'county_id' => 'required|exists:counties,id',
        ], [
            'postal_code.required' => 'Az irányítószám megadása kötelező.',
            'postal_code.integer' => 'Az irányítószám csak szám lehet.',
            'name.required' => 'A név megadása kötelező.',
            'county_id.exists' => 'A megadott megye nem létezik.',
        ]);
        $city = City::create($request->all());
        return response()->json(['city' => $city]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
