<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [// campos para el insert into de este modelo
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    #region Relaciones de tablas
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);// es la inversa de  One to Many del modelo User y su relacion posts
    }

    public function comentarios()// Un post va a tener multiples comentarios
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes() // Porque un post va a tener muchos likes
    {
        return $this->hasMany(Like::class);
    }
    #endregion
    
    public function checkLike(User $user)
    {
        // nos posicionamos en la tabla likes y usamos su columna user_id
        return $this->likes->contains('user_id', $user->id);// contiene, no usamos likes() porque si la usamos como funcion es la relacon como tal.
        //usamos likes para tan solo obtener la inforamcion
    }
}
