<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.upbit.com/v1/ticker?markets=KRW-BTC",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $results = json_decode($response, true);

        /* $posts = DB::table('posts')
                    ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                    ->select('posts.*')
                    ->addSelect(DB::raw('count(comments.id) as cnt'))
                    ->where('posts.category', 1)
                    ->groupBy('posts.id')
                    ->get(); */
        $posts = DB::table('posts')
                    ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                    ->select('posts.*')
                    ->addSelect(DB::raw('count(comments.id) as cnt'));
        $posts = $posts->where('posts.category', 1)
                        ->groupBy('posts.id')
                        ->get();
        //$posts = DB::table('posts')->get();
        
        if ($err) {
            return $err;
        } else {
            $coin_status = [];
            $coin_status['trade_price'] = $results[0]['trade_price'];
            $coin_status['trade_time'] = substr($results[0]['trade_time_kst'], 0, 2);
            $coin_status['trade_minute'] = substr($results[0]['trade_time_kst'], 2, 2);
            $coin_status['trade_second'] = substr($results[0]['trade_time_kst'], 4, 2);
            return view('message_board.message_board', ['posts' => $posts, 'category' => 'coin']);
        }
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
        //

        return view('message_board.message_write');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
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
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
