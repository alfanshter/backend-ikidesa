<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateAuth extends Model
{
    use HasFactory;
    protected $fillable = [
        'fotoktp',
        'uid_user'
    ];

    public function getuidUsers()
    {
        return $this->hasOne(User::class, 'uid', 'uid_user');
    }
}
