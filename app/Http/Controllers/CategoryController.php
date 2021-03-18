<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Category::with("user", "posts")
            ->search($request->q)
            ->get();
        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "status" => true
                ],
                "data" => $data,
            ]
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
        $request->validate([
            'name' => 'required|string|max:30',
            'status' => 'required|string|max:25',
        ]);
        $data = new Category;
        $data->name = $request->name;
        $data->status = $request->status;
        $data->user_id = $request->user()->id;

        $data->save();

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
        $request->validate([
            'name' => 'required|string|max:30',
            'status' => 'required|string|max:25',
        ]);

        $data = Category::find($id);
        $data->name = $request->name;
        $data->status = $request->status;

        $data->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Category::find($id);
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
}