<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category)
    {
        if($category == "coin") {
            $posts = DB::table('posts')
                        ->where('category', 1)
                        ->get();
        } else if($category == "free") {
            $posts = DB::table('posts')
                        ->where('category', 2)
                        ->get();
        }
        return view('message_board.message_board', ['posts' => $posts, 'category' => $category]);
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
        $post = Post::create([
            'category' => $request->category,
            'user_id' => Auth::user()->email,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::where('id', $id)->first();
        $category = $posts->category;
        return view('message_board.message_show', ['posts' => $posts, 'category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::where('id', $id)->first();
        $category = $posts->category;
        return view('message_board.message_edit', ['posts' => $posts, 'category' => $category]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* $validation = $request->validation([
            'title' => 'required',
            'description' => 'required',
        ])->validate(); */

        $post = Post::where('id', $id)->first();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect()->route('show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        if($post->category == 1) {
            $category = "coin";
        } else if($post->category == 2) {
            $category = "free";
        }
        $post->delete();

        return redirect()->route('post', $category);
    }
}
