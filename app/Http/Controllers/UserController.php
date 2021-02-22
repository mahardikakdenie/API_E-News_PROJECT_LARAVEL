<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\PseudoTypes\True_;

class UserController extends Controller
{

    public function logout(Request $request)
    {
        $data = $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                "meta" => [
                    "message" => "token sudah di Hapus",
                    "status" => true
                ],
                "token" => $data
            ],
        );
    }

    public function me(Request $request)
    {
        $data =  $request->user();

        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "status" => true
                ],
                "data" => $data
            ]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registrasi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'username' => 'required|string|max:20',
            'password' => 'required|string',
            'email' => 'required|email|max:30',
            'status' => 'required|max:20',
        ]);
        $data = new User;
        $data->name = $request->name;
        $data->username = $request->username;
        $data->password = Hash::make($request->password);
        $data->email = $request->email;
        $data->status = $request->status;

        $data->save();

        return response()->json(
            [
                "meta" => [
                    "message" => "Suksess",
                    "status" => true
                ],
                "data" => $data
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return response()->json(
            [
                "meta" => [
                    "message" => "Succes",
                    "status" => true
                ],
                "data" => $data
            ]
        );
    }
    public function createToken()
    {
        $user = User::find(1);
        $token = $user->createToken('token-name');

        return $token->plainTextToken;
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $data =  $user->createToken($request->device_name)->plainTextToken;
        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "status" => "Message",
                ],
                "access_token" => $data
            ]
        );
    }
    public function updatePassword(Request $request, $id)
    {
        $password = $request->password;
        $user = User::find($id);
        $user->password = bcrypt($password);
        $user->save();

        return response()->json($user);
    }
}