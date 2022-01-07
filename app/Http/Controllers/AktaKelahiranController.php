<?php

namespace App\Http\Controllers;

use App\Models\Aktakelahiran;
use App\Models\Transaksi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AktaKelahiranController extends Controller
{
   
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ktp_ayah' => ['required'],
            'ktp_ibu' => ['required'],
            'ktp_saksi1' => ['required'],
            'ktp_saksi2' => ['required'],
            'nama_anak' => ['required'],
            'anak_ke' => ['required'],
            'tempatlahir' => ['required'],
            'hari' => ['required'],
            'agama' => ['required'],
            'alamat' => ['required'],
            'ttdsaksi1' => ['required'],
            'ttdsaksi2' => ['required'],
            'jam' => ['required'],
            'tanggallahir' => ['required'],
            'uid_user' => ['required']
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => 0,
            ];
            return response()->json($response,Response::HTTP_UNPROCESSABLE_ENTITY);

        }
        
        try {
            $aktekelahiran = new AktaKelahiran();
            $aktekelahiran->ktp_ayah = $request->ktp_ayah;
            $aktekelahiran->ktp_ibu = $request->ktp_ibu;
            $aktekelahiran->ktp_saksi1 = $request->ktp_saksi1;
            $aktekelahiran->ktp_saksi2 = $request->ktp_saksi2;
            $aktekelahiran->nama_anak = $request->nama_anak;
            $aktekelahiran->anak_ke = $request->anak_ke;
            $aktekelahiran->tempatlahir = $request->tempatlahir;
            $aktekelahiran->agama = $request->agama;
            $aktekelahiran->alamat = $request->alamat;
            $aktekelahiran->ttdsaksi1 = $request->ttdsaksi1;
            $aktekelahiran->ttdsaksi2 = $request->ttdsaksi2;
            $aktekelahiran->jam = $request->jam;
            $aktekelahiran->tanggallahir = $request->tanggallahir;
            $aktekelahiran->hari = $request->hari;
            $aktekelahiran->uid_user = $request->uid_user;
            $aktekelahiran->save();
            
            try {
                $transaksi = new Transaksi();
                $transaksi->type = 'Surat Keterangan Kelahiran';
                $transaksi->status = 'Belum diverifikasi';
                $transaksi->id_target = $aktekelahiran->id;
                $transaksi->uid_users = $aktekelahiran->uid_user;
                $transaksi->save();
                $response = [
                'message' => 'Akte kelahiran berhasil di input',
                'data' => 1
            ];
                return response()->json($response, Response::HTTP_CREATED);


            } catch (QueryException $e2) {
             $response = [
                'message' => $e2,
                'data' => 0,
            ];
            return response()->json($response,Response::HTTP_UNPROCESSABLE_ENTITY);

            }


        } catch (QueryException $e) {
             $response = [
                'message' => $e,
                'data' => 0,
            ];
            return response()->json($response,Response::HTTP_UNPROCESSABLE_ENTITY);

        }

    }

    public function readall()
    {
        $aktekelahiran = AktaKelahiran::orderBy('created_at','DESC')->get();
        $response = [
           'message' => 'List akte order by time',
            'data' => $aktekelahiran
        ];

        return response()->json($response,Response::HTTP_OK);

    }

    public function readallbyid($uid_user)
    {
        $readallbyid = DB::table('aktakelahirans')->where('uid_user',$uid_user)->get();
        $response = [
            'message' => 'detail akun',
            'data' => $readallbyid
        ];

        if($readallbyid==null){
            $response = [
                'message' => 'detail akun',
                'data' => 0
            ];
            return response()->json($response,Response::HTTP_OK);   
        }
        return response()->json($response,Response::HTTP_OK);

    }

    public function readdetail($id_akta)
    {
        $detailakta = AktaKelahiran::findorFail($id_akta);
        $response = [
            'message' => 'Detail akta',
            'data' =>$detailakta
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function updateakta(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ktp_ayah' => ['required'],
            'ktp_ibu' => ['required'],
            'ktp_saksi1' => ['required'],
            'ktp_saksi2' => ['required'],
            'nama_anak' => ['required'],
            'anak_ke' => ['required'],
            'tempatlahir' => ['required'],
            'tanggallahir' => ['required'],
            'hari' => ['required'],
            'jam' => ['required'],
            'agama' => ['required'],
            'alamat' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $ttdsaksi1 = $request->file('ttdsaksi1');
        $ttdsaksi2 = $request->file('ttdsaksi2');
        //delete foto
        if ($ttdsaksi1 != null && $ttdsaksi2 == null) {
            $tujuanupload = 'img';
            $foto = AktaKelahiran::where('id',$request->id)->first();
            //delete foto
             if ($foto['ttdsaksi1'] != null) {
                File::delete($foto->ttdsaksi1);
            }

            try {
                $ttdsaksi1->move($tujuanupload,$ttdsaksi1->getClientOriginalName());
                $path = $tujuanupload.'/'.$ttdsaksi1->getClientOriginalName();
                $updateaktakelahiran = DB::table('aktakelahirans')->where('id',$request->id)->update([
                    'ktp_ayah'=> $request->ktp_ayah,
                    'ktp_ibu' => $request->ktp_ibu,
                    'ktp_saksi1' => $request->ktp_saksi1,
                    'ktp_saksi2' => $request->ktp_saksi2,
                    'nama_anak' => $request->nama_anak,
                    'anak_ke' => $request->anak_ke,
                    'tempatlahir' => $request->tempatlahir,
                    'tanggallahir' => $request->tanggallahir,
                    'hari' => $request->hari,
                    'jam' => $request->jam,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,                
                    'ttdsaksi1' => $path                 ]);
                    $response = [
                        'message' => 'berhasil update',
                        'data' => 1
                    ];
                    return response()->json($response,Response::HTTP_OK);

            } catch (QueryException $e) {
                return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            
        }else if ($ttdsaksi2 != null &&$ttdsaksi1 == null) {
            $tujuanupload = 'img';
            $foto = AktaKelahiran::where('id',$request->id)->first();
            //delete foto
             if ($foto['ttdsaksi2'] != null) {
                File::delete($foto->ttdsaksi2);
            }

            try {
                $ttdsaksi2->move($tujuanupload,$ttdsaksi2->getClientOriginalName());
                $path = $tujuanupload.'/'.$ttdsaksi2->getClientOriginalName();
                $updateaktakelahiran = DB::table('aktakelahirans')->where('id',$request->id)->update([
                    'ktp_ayah'=> $request->ktp_ayah,
                    'ktp_ibu' => $request->ktp_ibu,
                    'ktp_saksi1' => $request->ktp_saksi1,
                    'ktp_saksi2' => $request->ktp_saksi2,
                    'nama_anak' => $request->nama_anak,
                    'anak_ke' => $request->anak_ke,
                    'tempatlahir' => $request->tempatlahir,
                    'tanggallahir' => $request->tanggallahir,
                    'hari' => $request->hari,
                    'jam' => $request->jam,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,                
                    'ttdsaksi2' => $path                 ]);
                    $response = [
                        'message' => 'berhasil update',
                        'data' => 1
                    ];
                    return response()->json($response,Response::HTTP_OK);

            } catch (QueryException $e) {
                return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }else if($ttdsaksi1!=null && $ttdsaksi2!=null){
            $tujuanupload = 'img';
            $foto = AktaKelahiran::where('id',$request->id)->first();
            //delete foto
            File::delete($foto->ttdsaksi1);
            File::delete($foto->ttdsaksi2);


            try {
                $ttdsaksi1->move($tujuanupload,$ttdsaksi1->getClientOriginalName());
                $path = $tujuanupload.'/'.$ttdsaksi1->getClientOriginalName();
                $ttdsaksi2->move($tujuanupload,$ttdsaksi2->getClientOriginalName());
                $path2 = $tujuanupload.'/'.$ttdsaksi2->getClientOriginalName();
                $updateaktakelahiran = DB::table('aktakelahirans')->where('id',$request->id)->update([
                    'ktp_ayah'=> $request->ktp_ayah,
                    'ktp_ibu' => $request->ktp_ibu,
                    'ktp_saksi1' => $request->ktp_saksi1,
                    'ktp_saksi2' => $request->ktp_saksi2,
                    'nama_anak' => $request->nama_anak,
                    'anak_ke' => $request->anak_ke,
                    'tempatlahir' => $request->tempatlahir,
                    'tanggallahir' => $request->tanggallahir,
                    'hari' => $request->hari,
                    'jam' => $request->jam,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,                
                    'ttdsaksi1' => $path,                 
                    'ttdsaksi2' => $path2                 ]);
                    $response = [
                        'message' => 'berhasil update',
                        'data' => 1
                    ];
                    return response()->json($response,Response::HTTP_OK);

            } catch (QueryException $e) {
                return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }else {
                 $updateaktakelahiran = DB::table('aktakelahirans')->where('id',$request->id)->update([
                'ktp_ayah'=> $request->ktp_ayah,
                'ktp_ibu' => $request->ktp_ibu,
                'ktp_saksi1' => $request->ktp_saksi1,
                'ktp_saksi2' => $request->ktp_saksi2,
                'nama_anak' => $request->nama_anak,
                'anak_ke' => $request->anak_ke,
                'tempatlahir' => $request->tempatlahir,
                'tanggallahir' => $request->tanggallahir,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'agama' => $request->agama,
                'alamat' => $request->alamat                 ]);

                $response = [
                    'message' => 'berhasil update',
                    'data' => 1
                ];
                return response()->json($response,Response::HTTP_OK);
        }

       

    }

   

}
