@extends('layouts.app') 


@section('titulo') 
    Pagina Principal
@endsection


@section('contenido') 
    {{-- Cuando veas una x- es que se esta usando un componente --}}
    {{-- Le estoy pasando la variable de post hacia el componente--}}
    <x-listar-post :posts="$posts" />

@endsection 
