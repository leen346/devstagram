<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'post_id' ya no necesitamos el post_id porque lo va a detectar en el controlador de like porque ya tenemos la variable del post y ya tenemos el id
    ];
}
