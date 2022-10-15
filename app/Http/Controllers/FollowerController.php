<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //Los metodos para seguir a un usuario
    //Store es porque se usa un registro
    //El user es el perfil que estamos visitando y request es si tiene la persona que esta siguiendo ese usuario
    public function store(User $user)
    {
        //attach va funcionar cuando relaciones los usuarios o columnas de una misma tabla
        //Lee el usuario que estamos visitando su muro, le va agregar que esta persona lo esta siguiendo y 
        //esta autenticado
        $user->followers()->attach( auth()->user()->id );

        return back();
    }
    //Para dejar de seguir a un usuario
    public function destroy(User $user)
    {
        $user->followers()->detach( auth()->user()->id );
        return back();
    }
}
