<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Comment::with("user", "post")
            ->postId($request->post_id)
            ->get();

        return response()->json(
            [
                "meta" => [
                    "message" => "Succes",
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
        $data = new Comment;
        $data->comment = $request->comment;
        $data->status = $request->status;
        $data->user_id = $request->user()->id;
        $data->post_id = $request->post_id;

        $data->save();

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Comment::find($id);

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
        $data = Comment::find($id);
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