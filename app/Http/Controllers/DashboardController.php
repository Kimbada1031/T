<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bit = "KRW-BTC";
        $bit_status = Dashboard::getCoinStatus($bit);

        $eth = "KRW-ETH";
        $eth_status = Dashboard::getCoinStatus($eth);

        $xrp = "KRW-XRP";
        $xrp_status = Dashboard::getCoinStatus($xrp);

        $coin_posts = DB::table('posts')->where('category', 1)->get();
        $free_posts = DB::table('posts')->where('category', 2)->get();

        return view('dashboard', ['bit_status' => $bit_status, 'eth_status' => $eth_status, 'xrp_status' => $xrp_status, 
                                    'coin_posts' => $coin_posts, 'free_posts' => $free_posts]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }

    public function sortCoinStatus(Request $request) {

    }
}
