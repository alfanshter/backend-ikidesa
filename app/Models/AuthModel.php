<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthModel extends Model
{
    // use HasFactory;
    protected $table = 'users';
    public $incrementing = false;
    protected $fillable = ['uid','email','nama','nik','provinsi','kota','kecamatan','kelurahan','alamat_lengkap'];


}
