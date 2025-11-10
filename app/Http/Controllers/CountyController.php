<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountyRequest;
use App\Models\City;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    /**
     * @api {get} /counties Get all counties
     * @apiName GetCounties
     * @apiGroup County
     * @apiVersion 1.0.0
     * 
     * @apiDescription Retrieve a list of all counties
     * 
     * @apiSuccess {Number} status HTTP status code
     * @apiSuccess {Object[]} data Array of county objects
     * @apiSuccess {Number} data.id County ID
     * @apiSuccess {String} data.name County name
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": 200,
     *       "data": [
     *         {
     *           "id": 1,
     *           "name": "Budapest"
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
            $data = County::all();
            return response()->json(['status' => 200, 'data' => $data]);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @api {post} /counties Create a county
     * @apiName CreateCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * 
     * @apiDescription Create a new county (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiBody {String} name County name
     * 
     * @apiSuccess {Object} county Created county object
     * @apiSuccess {Number} county.id County ID
     * @apiSuccess {String} county.name County name
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "id": 1,
     *         "name": "Budapest"
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "The name field is required."
     *     }
     */
    public function store(CountyRequest $request)
    {
        $county = County::create($request->all());

        return response()->json(['county' => $county], 201);
    }

    /**
     * @api {get} /counties/:id Get a county
     * @apiName GetCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * 
     * @apiDescription Retrieve a specific county by ID
     * 
     * @apiParam {Number} id County unique ID
     * 
     * @apiSuccess {Object} county County object
     * @apiSuccess {Number} county.id County ID
     * @apiSuccess {String} county.name County name
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "id": 1,
     *         "name": "Budapest"
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "County not found"
     *     }
     */
    public function show(string $id)
    {
        $county = County::findOrFail($id);

        return response()->json([
            'county' => $county
        ]);
    }

    /**
     * @api {patch} /counties/:id Update a county
     * @apiName UpdateCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * 
     * @apiDescription Update an existing county (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiParam {Number} id County unique ID
     * @apiBody {String} name County name
     * 
     * @apiSuccess {Object} county Updated county object
     * @apiSuccess {Number} county.id County ID
     * @apiSuccess {String} county.name County name
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "id": 1,
     *         "name": "Budapest Updated"
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "County not found"
     *     }
     */
    public function update(CountyRequest $request, string $id)
    {
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json(['county' => $county]);
    }

    /**
     * @api {delete} /counties/:id Delete a county
     * @apiName DeleteCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * 
     * @apiDescription Delete a county (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiParam {Number} id County unique ID
     * 
     * @apiSuccess {String} message Success message
     * @apiSuccess {Number} id Deleted county ID
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Megye eliminálva. 👍",
     *       "id": "1"
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "County not found"
     *     }
     */
    public function destroy(string $id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'Megye eliminálva. 👍',
            'id' => $id
        ], 204);
    }

    
}
