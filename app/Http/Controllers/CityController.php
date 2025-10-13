<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(CityRequest $request)
    {
        $city = City::create($request->all());
        return response()->json(['city' => $city]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = City::findOrFail($id);

        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, string $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json(['city' => $city]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => 'Város eliminálva. 👍',
            'id' => $id
        ]);
    }

    public function countycities(string $county_id) {
        $cities = City::where('county_id',$county_id)->get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function names(string $subname){
        $cities = City::where('name', 'LIKE', $subname . '%') -> get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function countycitiesnames(string $county_id, string $subname) {
        $cities = City::where('county_id',$county_id)->where('name', 'LIKE', $subname . '%')->get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function abc(string $county_id) {
        $firsts = City::where('county_id',$county_id)->select(DB::raw('SUBSTR(name, 1, 1) AS betuk'))->distinct()->pluck('betuk')->toArray();

        return response()->json([
            'data' => $firsts
        ]);
    }

    // unnecessary "countycitiesnames" works fine
    public function countyInitialCities(string $county_id, string $initial) {
        $this->countycitiesnames($county_id,$initial);
    }
}
