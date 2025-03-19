@extends('oryon.layouts.main')

@section('title', 'Editar Produto {{ $produto->descricao }}')

@section('content')
    <H1>Editar Produto {{ $produto->descricao }}</H1>
    <form action="{{ route('oryon.update', $produto->id) }} " method='POST'>
        @method('PUT')
        @include('oryon.partials.form')
    </form>
@endsection