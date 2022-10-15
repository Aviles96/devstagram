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
        $this->middleware('auth')->except(['show', 'index']); // se ejecuta antes del index y lo autentifica
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request) 
    // Crear una publicacion y los diferentes objetos que van a estar en la misma
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);
        // Forma 1 de crear un post
        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        // // Otra forma
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // $request->user()->posts()->create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // Redirije al muro principal de usuario de la publicacion
        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show',[
            'post' => $post,
            'user' => $user
        ]);
    }
    // Eliminar una publicacion
    public function destroy(Post $post) // La variable de post para que sepa cual hay que eliminar
    {
        $this->authorize('delete', $post); //Nos va retornar si es cierto la validacion si es el mismo usuario
        // que va eliminar el post
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen); //La ruta de imagenes

        if(File::exists($imagen_path)) { //Si existe la ruta 
            unlink($imagen_path); // Eliminarla funcion de php
        }

        return redirect()->route('posts.index', auth()->user()->username);
        //Redirige al usuario autenticado a la ruta de post.index es decir su perfil
    }
}