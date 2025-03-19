@extends('oryon.layouts.main')

@section('title', 'Datalhes do Produto Oryon')

@section('content')
    <H1>Detalhes do Produto</H1>
    <ul>
        <li>Código: {{$produto->codigo}}</li>
        <li>Descrição: {{$produto->descricao}}</li>
        <li>Preço: {{$produto->preco}}</li>
        <li>Categoria: {{$produto->categoria}}</li>
        <li>Fornecedor: {{$produto->fornecedor}}</li>
        <li>Peso: {{$produto->peso}}</li>
        <li>Preço de Compra: {{$produto->preco_compra}}</li>
        <li>Estoque: {{$produto->estoque}}</li> 
    </ul>
    <form action="{{ route('oryon.destroy', $produto->id) }} " method='POST'>
        @csrf
        @method('DELETE')
        <button type='submit'>Deletar</button>
    </form>
@endsection