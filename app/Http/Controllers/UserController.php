<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @api {post} /users/login Login
     * @apiName Login
     * @apiGroup User
     * @apiVersion 1.0.0
     * 
     * @apiDescription Authenticate a user and generate an access token
     * 
     * @apiBody {String} email User's email address
     * @apiBody {String} password User's password
     * 
     * @apiSuccess {Object} user User object with token
     * @apiSuccess {Number} user.id User ID
     * @apiSuccess {String} user.name User name
     * @apiSuccess {String} user.email User email
     * @apiSuccess {String} user.token Access token for authentication
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "token": "1|abcdefghijklmnopqrstuvwxyz"
     *       }
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "message": "Invalid email or password"
     *     }
     */
    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('email',$email)->first();

        if (!$user || !Hash::check($password,$password ? $user->password : '')) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user->tokens()->delete();
        $user->token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * @api {get} /users Get all users
     * @apiName GetUsers
     * @apiGroup User
     * @apiVersion 1.0.0
     * 
     * @apiDescription Retrieve a list of all users (requires authentication)
     * 
     * @apiHeader {String} Authorization Bearer token for authentication
     * 
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer 1|abcdefghijklmnopqrstuvwxyz"
     *     }
     * 
     * @apiSuccess {Object[]} users Array of user objects
     * @apiSuccess {Number} users.id User ID
     * @apiSuccess {String} users.name User name
     * @apiSuccess {String} users.email User email
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "users": [
     *         {
     *           "id": 1,
     *           "name": "John Doe",
     *           "email": "john@example.com"
     *         }
     *       ]
     *     }
     * 
     * @apiError {Object} error Error object
     * @apiError {String} error.message Error message
     * 
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "message": "Unauthenticated"
     *     }
     */
    public function index() {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
}
