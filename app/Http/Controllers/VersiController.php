<?php

namespace App\Http\Controllers;

use App\Models\VersiModels;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
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

    public function detail($id)
    {
        $detailversi = VersiModels::findorFail($id);
        $response = [
            'message' => 'Detail versi',
            'data' =>$detailversi
        ];

        return response()->json($response, Response::HTTP_OK);
        
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
                'data' => $insertversi
            ];

            return response()->json($response,Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
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
                'data' => $updateversi
            ];

            return response()->json($response,Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
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
