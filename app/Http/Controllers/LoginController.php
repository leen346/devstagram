<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) {// tratara de autenticar el usuario, si es true es correcto, si es false incorrecto
            return back()->with('mensaje', 'Credenciales Incorrectas');//con back volvemos a la pagina anterior, hace la peticion post a este metodo, pero sino da vuelve al login
            // que es la pagina back
        }

        return redirect()->route('posts.index', ['user' => auth()->user()->username]);
    }
}
