<?php

namespace App\Http\Controllers;

use App\Models\AktaKelahiran;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AktaKelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $aktekelahiran = AktaKelahiran::orderBy('created_at','DESC')->get();
        // $response = [
        //     'message' => 'List akte order by time',
        //     'data' => $aktekelahiran
        // ];

        // return response()->json($response,Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'uid_ayah' => ['required'],
            'uid_ibu' => ['required'],
            'uid_saksi1' => ['required'],
            'uid_saksi2' => ['required'],
            'nama_anak' => ['required'],
            'anak_ke' => ['required'],
            'tempatlahir' => ['required'],
            'hari' => ['required'],
            'agama' => ['required'],
            'alamat' => ['required'],
            'ttdsaksi1' => ['required'],
            'ttdsaksi2' => ['required'],
            'jam' => ['required'],
            'tanggallahir' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            // $aktekelahiran = AktaKelahiran::create($request->all());
            // $response = [
            //     'message' => 'Akte kelahiran berhasil',
            //     'data' => $aktekelahiran
            // ];

            // return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }

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
        //
    }
}
