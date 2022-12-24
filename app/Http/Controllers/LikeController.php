<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id' => $request->user()->id// no mandamos el post->id porque comenzamos del modelo post y ya lo mapea en el insert del modelo likes, tmb porque tiene una relacion
        ]);

        return back();// nos regresa donde enviamos la peticion, que es la misma pagina de post individual
    }

    public function destroy(Request $request, Post $post)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();// user_id se tiene por automatico la referencia por la relacion de likes() del modelo User 
        return back(); // para que nos regrese a la pagina previa   
    }
}
