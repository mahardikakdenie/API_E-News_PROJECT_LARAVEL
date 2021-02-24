<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginations = Post::paginate(10);
        $per_page = $paginations->perPage();
        $data = Post::with("user", "category", "tags", "comments")
            ->search($request->q)
            // ->owner($request->user()->id)
            ->get();

        // Contoh lawas

        // $data = Post::where('title', 'like', '%' . $request->q . '%')->where('user_id', $request->user()->id);
        // $data = Post::query();
        // if ($request->q !== null) {
        //     $data->where("title", "like", '%' . $request->q . '%');
        // }

        // if ($request->owner == true) {
        //     $data->where('user_id', $request->user()->id);
        // }
        // $data = $data->get();
        return response()->json(
            [
                "meta" => [
                    "message" => "Success",
                    "status" => true,
                    "pagintion" => [
                        "current_page" => $paginations,
                        "Per_page" => $per_page,
                    ],
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
            'title' => 'required|string|max:50',
            'post' => 'required',
            'status' => 'required|string|max:25',
        ]);
        $post = new Post;
        $post->title = $request->title;
        $post->post = $request->post;
        $post->status = $request->status;
        $post->category_id = $request->category_id;
        $post->slug = Str::of($request->title)->slug('-');
        $post->user_id = $request->user()->id;

        $post->save();

        return response()->json(
            [
                "meta" => [
                    "message" => "Succes",
                    "status" => true
                ],
                "data" => $post
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBySlug($slug)
    {
        $data = Post::with("user")->where('slug', $slug)->first();
        return response()->json(
            [
                'meta' => [
                    "message" => "Success",
                    "status" => true,
                ],
                "data" => $data,

            ]
        );
    }
    public function approve(Request $request, $id)
    {
        if ($request->user()->role->name != "administrator") {
            return response()->json([
                "meta" => [
                    "message" => "you are not admin",
                    "status" => false
                ],
                "data" => null
            ]);
        }
        $data = Post::findOrFail($id);
        $data->admin_id = $request->user()->id;
        $data->status = "publish";

        $data->save();
        return response()->json([
            "meta" => [
                "message" => "Success",
                "status" => true
            ],
            "data" => $data
        ]);
    }
    public function showById($id)
    {
        $data = Post::with("user")->where('id', $id)->first();
        return response()->json(
            [
                'meta' => [
                    "message" => "Success",
                    "status" => true,
                ],
                "data" => $data,

            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post)
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
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'post' => 'required|string',
            'status' => 'required|string|max:25',
        ]);

        $post = Post::find($slug);
        $post->title = $request->input('title', $post->title);
        $post->post = $request->input('post', $post->post);
        $post->status = $request->input('status', $post->status);
        $post->category_id = $request->input("category_id", $post->category_id);
        $post->slug = Str::of($request->title)->slug('-');
        $post->user_id = $request->user()->id;

        $post->save();

        return response()->json(
            [
                "meta" => [
                    "message" => "Succes",
                    "status" => true
                ],
                "data" => $post
            ]
        );
        // $data = $post::where('id', $post->id)->update([
        //     'title' => $post->title,
        //     'post' => $post->post,
        //     'status' => $post->status
        // ]);

        // return response()->json([
        //     "meta" => [
        //         "message" => "Success",
        //         "status" => true
        //     ],
        //     "data" => $data
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Post::find($id);
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