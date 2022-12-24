<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            // 'username' => 'required|unique:users|min:3|max:20' // cuando son mas de 3 reglas laravel recomienda un array
            // 'username' => ['required','unique:users','min:3','max:20', 'not_in:twitter,editar-perfil', 'in:CLIENTE,PROVEEDOR,VENDEDOR']
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:twitter,editar-perfil'] 
        ]);

        if($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid().".".$imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);

            $imagenPath = public_path('perfiles').'/'.$nombreImagen;// public_path apunta hacia la carpeta public, creara algo asi uploads/1312321213.jpg
            $imagenServidor->save($imagenPath);
        }

        // Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? NULL;
        $usuario->save();

        //redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
