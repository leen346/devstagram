<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [// campos para el insert into de este modelo
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #region Relaciones entre tablas
    public function posts()// One to Many es hasMany, un usuario tiene multiple posts
    {
        return $this->hasMany(Post::class);// return $this->hasMany(Post::class, 'user_id'); el segundo arg es opcional y es para establecer el Foreign key
    } 

    public function likes()// Un usuario puede tener obviamente multiples likes
    {
        return $this->hasMany(Like::class);
    }
    // Almacena los seguidores de un usuario
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');// hacemos referencia a la tabla followers, hacemos referncia a user_id que tenga relacion con follower_id
    }

    
    // Almacenar los que seguimos
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // Comprobar si un usuario ya sigue a otro
    public function siguiendo(User $user) 
    {
        return $this->followers->contains($user->id);
    }
    #endregion


}
