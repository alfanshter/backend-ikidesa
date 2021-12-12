<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktakelahiran extends Model
{
    use HasFactory;
    protected $fillable = ['ktp_ayah','ktp_ibu','ktp_saksi1','ktp_saksi2','nama_anak','anak_ke',
'tempatlahir','tanggallahir','hari','agama','alamat','ttdsaksi1','ttdsaksi2','status_verifikasi','uid_user'];
}
