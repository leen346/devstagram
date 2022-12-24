<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(Request $request, User $user)// el user es a quien vamos a seguir en este caso, no el autenticado
    {
        $user->followers()->attach(auth()->user()->id);// relacion muchos a muchos, realiza el insert a ese modelo con su respectiva relacion
        return back();
    }
    
    public function destroy(Request $request, User $user)
    {
        $user->followers()->detach(auth()->user()->id);// relacion muchos a muchos, realiza el insert a ese modelo con su respectiva relacion
        return back();
    }
}
