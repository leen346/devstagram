<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);// que ejecute el middleware de autenticacion y colocar excepciones y se coloca los metodos en el array
    }
    public function index(User $user) 
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);//tambien existe el ->simplePaginate
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create() 
    {
        return view('posts.create');// posts => carpeta, create => .blade.php, con el . accedemos a create.blade.php
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // Otra forma de crear registros
        // $post = new Post();
        // $post->titulo =$request->titulo;
        // $post->descripcion =$request->descripcion;
        // $post->imagen =$request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // Tercera forma de crear registros con la relacion de user con posts
        $request->user()->posts()->create([// el usuario que esta creando el post que es el autenticado
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user());
    }

    public function show(User $user, Post $post) 
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {   
        $this->authorize('delete', $post);// ejecuta el policy PostPolcy
        $post->delete();
        //Eliminar la imagen
        $imagen_path = public_path('uploads/'.$post->imagen);
        if(File::exists($imagen_path)) {
            unlink($imagen_path);
        }
        return redirect()->route('posts.index', auth()->user()->username);
        // if($post->user_id === auth()->user()->id) {

        // } else {

        // }
    }
}
