<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Carbon;
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
        $posts = DB::table('posts')
                    ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                    ->select('posts.*')
                    ->addSelect(DB::raw('count(comments.id) as cnt'));
                    
        if($category == "coin") {
            $posts = $posts->where('posts.category', 1);
        } else if($category == "free") {
            $posts = $posts->where('posts.category', 2);
        }
        
        $posts = $posts->groupBy('posts.id')
                        ->get();
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

    public function commentStore(Request $request)
    {
        DB::table('comments')->insert([
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->email,
            'description' => $request->description,
            'created_at'  => Carbon::now(),
        ]);

        $posts = Post::where('id', $request->post_id)->first();
        $category = $posts->category;
        $comments = DB::table('comments')->where('post_id', $request->post_id)->get();
        return view('message_board.message_show', ['posts' => $posts, 'category' => $category, 'comments' => $comments]);
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
        $comments = DB::table('comments')->where('post_id', $id)->get();
        $comment_cnt = DB::table('comments')->where('post_id', $id)->count();
        return view('message_board.message_show', ['posts' => $posts, 'category' => $category, 'comments' => $comments, 'comment_cnt' => $comment_cnt]);
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

    public function commentUpdate(Request $request, $id)
    {
        $comment = DB::table('comments')->where('id', $id)->first();
        $post = Post::where('id', $comment->post_id)->first();

        /* $comment->description = $request->description;
        $comment->save(); */

        $query = DB::table('comments')
                        ->where('id', $id)
                        ->update([
                            'description' => $request->description,
                            'updated_at'  => Carbon::now(),
                        ]);  

        return redirect()->route('show', $post->id);
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

    public function commentDestroy($id)
    {
        $comment = DB::table('comments')
                    ->where('id', $id)->first();
        $post = Post::where('id', $comment->post_id)->first();
        $comment = DB::table('comments')
                    ->where('id', $id)
                    ->delete();

        return redirect()->route('show', $post->id);
    }
}
