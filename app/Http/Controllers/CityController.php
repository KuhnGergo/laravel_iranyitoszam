<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * @api {get} /cities Get all cities
     * @apiName GetCities
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Retrieve a list of all cities
     * 
     * @apiSuccess {Number} status HTTP status code
     * @apiSuccess {Object[]} data Array of city objects
     * @apiSuccess {Number} data.id City ID
     * @apiSuccess {Number} data.postal_code City postal code
     * @apiSuccess {String} data.name City name
     * @apiSuccess {Number} data.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": 200,
     *       "data": [
     *         {
     *           "id": 1,
     *           "postal_code": 1011,
     *           "name": "Budapest",
     *           "county_id": 1
     *         }
     *       ]
     *     }
     * 
     * @apiError {Number} status HTTP status code
     * @apiError {String} message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *       "status": 500,
     *       "message": "Error message"
     *     }
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
     * @api {post} /cities Create a city
     * @apiName CreateCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Create a new city (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiBody {Number} postal_code City postal code
     * @apiBody {String} name City name
     * @apiBody {Number} county_id County ID
     * 
     * @apiSuccess {Object} city Created city object
     * @apiSuccess {Number} city.id City ID
     * @apiSuccess {Number} city.postal_code City postal code
     * @apiSuccess {String} city.name City name
     * @apiSuccess {Number} city.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 1,
     *         "postal_code": 1011,
     *         "name": "Budapest",
     *         "county_id": 1
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "Az irányítószám megadása kötelező."
     *     }
     */
    public function store(CityRequest $request)
    {
        $city = City::create($request->all());
        return response()->json(['city' => $city]);
    }

    /**
     * @api {get} /cities/:id Get a city
     * @apiName GetCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Retrieve a specific city by ID
     * 
     * @apiParam {Number} id City unique ID
     * 
     * @apiSuccess {Object} city City object
     * @apiSuccess {Number} city.id City ID
     * @apiSuccess {Number} city.postal_code City postal code
     * @apiSuccess {String} city.name City name
     * @apiSuccess {Number} city.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 1,
     *         "postal_code": 1011,
     *         "name": "Budapest",
     *         "county_id": 1
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "City not found"
     *     }
     */
    public function show(string $id)
    {
        $city = City::findOrFail($id);

        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {patch} /cities/:id Update a city
     * @apiName UpdateCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Update an existing city (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiParam {Number} id City unique ID
     * @apiBody {Number} [postal_code] City postal code (optional)
     * @apiBody {String} [name] City name (optional)
     * @apiBody {Number} [county_id] County ID (optional)
     * 
     * @apiSuccess {Object} city Updated city object
     * @apiSuccess {Number} city.id City ID
     * @apiSuccess {Number} city.postal_code City postal code
     * @apiSuccess {String} city.name City name
     * @apiSuccess {Number} city.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 1,
     *         "postal_code": 1012,
     *         "name": "Budapest Updated",
     *         "county_id": 1
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "City not found"
     *     }
     */
    public function update(CityRequest $request, string $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json(['city' => $city]);
    }

    /**
     * @api {delete} /cities/:id Delete a city
     * @apiName DeleteCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Delete a city (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiParam {Number} id City unique ID
     * 
     * @apiSuccess {String} message Success message
     * @apiSuccess {Number} id Deleted city ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Város eliminálva. 👍",
     *       "id": "1"
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "City not found"
     *     }
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

    /**
     * @api {get} /counties/:id/cities Get cities by county
     * @apiName GetCountyCities
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Retrieve all cities belonging to a specific county
     * 
     * @apiParam {Number} id County unique ID
     * 
     * @apiSuccess {Object[]} cities Array of city objects
     * @apiSuccess {Number} cities.id City ID
     * @apiSuccess {Number} cities.postal_code City postal code
     * @apiSuccess {String} cities.name City name
     * @apiSuccess {Number} cities.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         {
     *           "id": 1,
     *           "postal_code": 1011,
     *           "name": "Budapest",
     *           "county_id": 1
     *         }
     *       ]
     *     }
     */
    public function countycities(string $county_id) {
        $cities = City::where('county_id',$county_id)->get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    /**
     * @api {get} /cities/names/:name Search cities by name
     * @apiName SearchCitiesByName
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Search for cities whose name starts with the specified substring
     * 
     * @apiParam {String} name Name prefix to search for
     * 
     * @apiSuccess {Object[]} cities Array of city objects matching the search criteria
     * @apiSuccess {Number} cities.id City ID
     * @apiSuccess {Number} cities.postal_code City postal code
     * @apiSuccess {String} cities.name City name
     * @apiSuccess {Number} cities.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         {
     *           "id": 1,
     *           "postal_code": 1011,
     *           "name": "Budapest",
     *           "county_id": 1
     *         }
     *       ]
     *     }
     */
    public function names(string $subname){
        $cities = City::where('name', 'LIKE', $subname . '%') -> get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    /**
     * @api {get} /counties/:id/cities/names/:name Search cities by county and name
     * @apiName SearchCountyCitiesByName
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Search for cities in a specific county whose name starts with the specified substring
     * 
     * @apiParam {Number} id County unique ID
     * @apiParam {String} name Name prefix to search for
     * 
     * @apiSuccess {Object[]} cities Array of city objects matching the search criteria
     * @apiSuccess {Number} cities.id City ID
     * @apiSuccess {Number} cities.postal_code City postal code
     * @apiSuccess {String} cities.name City name
     * @apiSuccess {Number} cities.county_id County ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         {
     *           "id": 1,
     *           "postal_code": 1011,
     *           "name": "Budapest",
     *           "county_id": 1
     *         }
     *       ]
     *     }
     */
    public function countycitiesnames(string $county_id, string $subname) {
        $cities = City::where('county_id',$county_id)->where('name', 'LIKE', $subname . '%')->get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    /**
     * @api {get} /counties/:id/abc Get first letters of cities in county
     * @apiName GetCountyCityInitials
     * @apiGroup City
     * @apiVersion 1.0.0
     * 
     * @apiDescription Get all distinct first letters of city names in a specific county
     * 
     * @apiParam {Number} id County unique ID
     * 
     * @apiSuccess {String[]} data Array of distinct first letters
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "data": ["A", "B", "C", "D"]
     *     }
     */
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
