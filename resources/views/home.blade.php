@extends('layouts.app'){{-- laravel en vez de usar / usamos . para navegar entre carpetas en blade --}}

@section('titulo')
    Pagina Principal {{-- inyectara la data en el h1 que tiene el yield --}}
@endsection

@section('contenido')
   {{-- Componente de Laravel --}}
  {{-- <x-listar-post />  De esta forma no soporta slots -- }}
  {{-- @forelse ($posts as $post)
    <h1>{{$post-titulo}}</h1>
  @empty
    <p>No hay Posts</p>
  @endforelse --}}
    {{-- <x-listar-post>
      <x-slot:titulo>
        <header>Esto es  un header</header>
      </x-slot:titulo>
      <h1>Mostrando Post desde slot</h1>
    </x-listar-post> --}}
    {{-- Mandandole la variable de posts al componente de laravel --}}
    <x-listar-post :posts="$posts" />
@endsection