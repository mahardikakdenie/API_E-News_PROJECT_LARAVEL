<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tag::with("user", "posts")->get();

        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "status" => true
                ],
                "data" => $data
            ],
        );
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
    public function store(Request $request)
    {
        $data = new Tag;
        $data->name = $request->name;
        $data->status = $request->status;
        $data->user_id = $request->user()->id;

        $data->save();

        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "success" => true
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
        $data = Tag::finc($id);
        $data->name = $request->input('name', $data->name);
        $data->status = $request->input('status', $data->status);
        $data->user_id = $request->user()->id;

        $data->save();

        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "success" => true
                ],
                "data" => $data
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}