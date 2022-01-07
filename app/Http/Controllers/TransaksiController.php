<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransaksiController extends Controller
{
    public function readtransaksi(Request $request)
    {

        $readallbyid = DB::table('transaksis')->where('uid_users',$request->input('uid'))->get();
        $response = [
            'message' => 'data transaksi setiap user',
            'data' => $readallbyid
        ];

        if($readallbyid==null){
            $response = [
                'message' => 'gagal ambil transaksi',
                'data' => 0
            ];
            return response()->json($response,Response::HTTP_OK);   
        }
        return response()->json($response,Response::HTTP_OK);

    }

    public function detailtransaksi(Request $request)
    {
        $detailtransaksi = DB::table('transaksis')->where('id',$request->input('id'))->first();
        $response = [
            'message' => 'data transaksi setiap user',
            'data' => $detailtransaksi
        ];

        if($detailtransaksi==null){
            $response = [
                'message' => 'gagal ambil transaksi',
                'data' => 0
            ];
            return response()->json($response,Response::HTTP_OK);   
        }
        return response()->json($response,Response::HTTP_OK);

    }
}
