@extends('oryon.layouts.main')

@section('title', 'Cadastrar Novo Produto Oryon')

@section('content')
    <H1>Novo Produto</H1>
    <form action="{{ route('oryon.store') }} " method='POST'>
        @include('oryon.partials.form')
    </form>
@endsection