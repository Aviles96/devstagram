<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Para poder ver la paginal principal tienen que estar autenticados
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Si vas a crear un ruta con un solo metodo puedo usar invoke
    public function __invoke()
    {
        //Obtener a quienes seguimos el pluck solo nos trae la informacion que queremos
        $ids = auth()->user()->followings->pluck('id')->toArray();
        //Para ver en el home los posts de los usuarios que sigo con el whereIn puedo filtrar sus posts el paginate
        //es para traer los resultados
        //latest ordena la muestra de los post
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        return view('home', [
            'posts' => $posts
        ]);
    }
}
