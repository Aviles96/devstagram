<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //Proteger las rutas para no entrar si no es el perfil del usuario
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Funcion que da la Ruta para ensenar la vista del formulario
    public function index()
    {
        return view('perfil.index');
    }
    //Funcion para guardar los cambios del perfil
    public function store(Request $request) //Siempre se le pasa un request o solicitud a un store
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username, ' .auth()->user()->id, 
            'min:3', 'max:20', 'not_in:twiter,editar-perfil']
        ]);

        //Verifica si hay imagen para guardar la nueva en la base de datos
        if($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension(); // genera un id unico para la imagen al subir
    
            $imagenServidor = Image::make($imagen); // tamano maximo de la imagen
            $imagenServidor->fit(1000, 1000);
    
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
