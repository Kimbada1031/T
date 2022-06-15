<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Dashboard extends Model
{
    use HasFactory;

    public function getCoinStatus($markets) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.upbit.com/v1/ticker?markets=" . $markets,
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

        if ($err) {
            return $err;
        } else {
            $coin_status = [];
            $coin_status['trade_price'] = number_format($results[0]['trade_price']);
            $coin_status['trade_time'] = substr($results[0]['trade_time_kst'], 0, 2);
            $coin_status['trade_minute'] = substr($results[0]['trade_time_kst'], 2, 2);
            $coin_status['trade_second'] = substr($results[0]['trade_time_kst'], 4, 2);
            return $coin_status;
        }
    }
}
