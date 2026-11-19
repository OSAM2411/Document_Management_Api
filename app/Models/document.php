<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    protected $fillable = [
        'file_path',
        'description',
        'title',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
