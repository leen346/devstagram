<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request); funcion que nos permite debugear y para la ejecucion
        // dd($request->get('username')); podemos obtener los valores de los input del front con los name

        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);// los espacios los sustituye por - quita los acentos

        // validacion
        $this->validate($request, [
            'name' => 'required|max:30',// otra sintaxis es ['required', 'min:5']
            'username' => 'required|unique:users|min:3|max:20',// unique:tabla
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'// confirmed hara que el input de confirmacion de password coincida
        ]);

        // dd('Creando Usuario');
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Autenticar un usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // Otra forma de autenticar
        auth()->attempt($request->only('email','password'));

        //Redireccionar
        return redirect()->route('posts.index', ['user' => auth()->user()]);
    }
}
