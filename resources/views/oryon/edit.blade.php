@extends('oryon.layouts.main')

@section('title', 'Editar Produto {{ $produto->descricao }}')

@section('content')

<H1>Novo Produto</H1>
<x-alert/>
<form action="{{ route('oryon.update', $produto->id) }} " method='POST'>
    @csrf
    @method('PUT')
    <label for='codigo'>Código:</label>
    <input type='text' name='codigo' id='codigo' placeholder="Código do Produto" value="{{ $produto->codigo }}">
    <br>
    <label for='descricao'>Descrição:</label> 
    <input type='text' name='descricao' id='descricao' placeholder="Descrição do Produto" value="{{ $produto->descricao }}">
    <br>
    <label for='preco'>Preço:</label>
    <input type='text' name='preco' id='preco' placeholder="Preço do Produto" value="{{ $produto->preco }}">
    <br>
    <label for='categoria'>Categoria:</label>
    <input type='text' name='categoria' id='categoria' placeholder="Categoria do Produto" value="{{ $produto->categoria }}">
    <br>
    <label for='fornecedor'>Fornecedor:</label>
    <input type='text' name='fornecedor' id='fornecedor' placeholder="Fornecedor do Produto" value="{{ $produto->fornecedor }}">
    <br>
    <label for='peso'>Peso:</label>
    <input type='text' name='peso' id='peso' placeholder="Peso do Produto" value="{{ $produto->peso }}">
    <br>
    <label for='preco_compra'>Preço de Compra:</label>
    <input type='text' name='preco_compra' id='preco_compra' placeholder="Preço de Compra do Produto" value="{{ $produto->preco_compra }}">
    <br>
    <label for='estoque'>Estoque:</label>
    <input type='text' name='estoque' id='estoque' placeholder="Estoque do Produto" value="{{ $produto->estoque }}">
    <br>
    <button type='submit'>Salvar</button>   
</form>
@endsection