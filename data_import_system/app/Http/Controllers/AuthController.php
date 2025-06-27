<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{

/**
 * @OA\Post(
 *      path="/api/register",
 *      summary="register new user",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\jsonContent(
 *              required={"name","email","password"},
 *              @OA\Property(property="name", type="string"),
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="password", type="string"),
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="token", type="string")
 *          )
 *      )
 * )
 */


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }


    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password')))
        {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Auth::user()->createToken('token')->plainTextToken;

        return response()->json(['token' => $token], 201);

    }
}
