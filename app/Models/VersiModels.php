<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersiModels extends Model
{
    use HasFactory;

    protected $fillable = ['nama_aplikasi','versi_aplikasi','link_download'];
}
