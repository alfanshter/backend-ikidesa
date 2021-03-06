<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use App\Models\UpdateAuth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Ramsey\Uuid\Uuid;
class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'uid' => ['required'],
            'email' => ['required'],
            'nama' => ['required'],
            'nik' => ['required'],
            'provinsi' => ['required'],
            'kota' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'alamat_lengkap' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $register = new AuthModel();
            $register->uid = $request->uid;
            $register->email = $request->email;
            $register->nama = $request->nama;
            $register->nik = $request->nik;
            $register->provinsi = $request->provinsi;
            $register->kota = $request->kota;
            $register->kecamatan = $request->kecamatan;
            $register->kelurahan = $request->kelurahan;
            $register->alamat_lengkap = $request->alamat_lengkap;
            $register->save();
            $response = [
                'message' => 'berhasil insert',
                'data' => 1
            ];

            return response()->json($response,Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => 0 , 'error' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }
    public function checkauth(Request $request)
    {
        $status = false;
        $checkauth = DB::table('users')->where('email',$request->email)->first();
        if($checkauth!=null){
         $status = true;   
        }
        $response = [
            'message' => 'true or not',
            'data' => $status
        ];
        return response()->json($response,Response::HTTP_CREATED);
    }

    public function detailakun(Request $request)
    {

        $detailakun = DB::table('users')->where('uid',$request->input('uid'))->first();
        $response = [
            'message' => 'detail akun',
            'data' => $detailakun
        ];

        if($detailakun==null){
            $response = [
                'message' => 'detail akun',
                'data' => 'akun tidak terdaftar'
            ];
            return response()->json($response,Response::HTTP_OK);   
        }
        return response()->json($response,Response::HTTP_OK);   
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fotoktp' => 'required',
            'keterangan' => ' required'

        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //menyimpan data
        $file = $request->file('fotoktp');

        //namafile
        $namafile = $file->getClientOriginalName();
        //ekstensifile
        $ekstensi = $file->getClientOriginalExtension();
        //realpath
        $realpath = $file->getRealPath();
        //ukuran file
        $ukuranfile = $file->getSize();
        // tipe mime
        $file->getMimeType();
        //tujuan upload
        $tujuanupload = 'img';
        //upload file
        try {
            $file->move($tujuanupload,$file->getClientOriginalName());
            $path = $tujuanupload.'/'.$file->getClientOriginalName();

            $register = new UpdateAuth();
            $register->fotoktp = $path;
            $register->keterangan = $request->keterangan;
            $register->uid_user = $request->uid_user;
            $register->status = 'belum_dikonfirmasi';
            $register->save();
            $response = [
                'message' => 'upload sukses',
                'data' => $register
            ];
            return response()->json($response,Response::HTTP_OK);   
        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
        }



    }

}
