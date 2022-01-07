<?php

namespace App\Http\Controllers;

use App\Models\VersiModels;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VersiController extends Controller
{
    public function index()
    {
        $getversi = VersiModels::orderBy('created_at','DESC')->get();
        $response = [
           'message' => 'List versi order by time',
            'data' => $getversi
        ];

        return response()->json($response,Response::HTTP_OK);
    }

    public function detail(Request $request)
    {
        $detailversi = DB::table('versi_models')->where('nama_aplikasi',$request->input('nama_aplikasi'))->first();
        $response = [
            'message' => 'detail versi',
            'data' => $detailversi
        ];

        if($detailversi==null){
            $response = [
                'message' => 'detail versi',
                'data' => null
            ];
            return response()->json($response,Response::HTTP_OK);   
        }
        return response()->json($response,Response::HTTP_OK);
        
    }

    public function insert(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'nama_aplikasi' => ['required'],
            'versi_aplikasi' => ['required'],
            'link_download' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $insertversi = VersiModels::create($request->all());
            $response = [
                'message' => 'berhasil insert',
                'data' => 1
            ];

            return response()->json($response,Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);

        }

    }

    public function update(Request $request, $id)
    {
        $updateversi = VersiModels::findorFail($id);

       $validator = Validator::make($request->all(),[
            'nama_aplikasi' => ['required'],
            'versi_aplikasi' => ['required'],
            'link_download' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $updateversi->update($request->all());
            $response = [
                'message' => 'berhasil update',
                'data' => 1
            ];

            return response()->json($response,Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);

        }

    }

    public function delete($id)
    {
        $updateversi = VersiModels::findorFail($id);
 
         try {
             $updateversi->delete();
             $response = [
                 'message' => 'berhasil hapus',
                 'data' => $updateversi
             ];
 
             return response()->json($response,Response::HTTP_OK);
 
         } catch (QueryException $e) {
             return response()->json([
                 'message' => "Failed" . $e->errorInfo
             ]);
         }
 
    }

}
