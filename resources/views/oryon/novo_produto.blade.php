@extends('oryon.layouts.main')

@section('title', 'Cadastrar Produto Oryon')

@section('content')

<H1>Novo Produto</H1>
<x-alert/>
<form action="{{ route('oryon.store') }} " method='POST'>
    @csrf
    <label for='codigo'>Código:</label>
    <input type='text' name='codigo' id='codigo' placeholder="Código do Produto" value="{{ old('codigo') }}">   
    <br>
    <label for='descricao'>Descrição:</label>
    <input type='text' name='descricao' id='descricao' placeholder="Descrição do Produto" value="{{ old('descricao') }}">
    <br>
    <label for='preco'>Preço:</label>
    <input type='text' name='preco' id='preco' placeholder="Preço do Produto" value="{{ old('preco') }}">
    <br>
    <label for='categoria'>Categoria:</label>
    <input type='text' name='categoria' id='categoria' placeholder="Categoria do Produto" value="{{ old('categoria') }}">
    <br>
    <label for='fornecedor'>Fornecedor:</label>
    <input type='text' name='fornecedor' id='fornecedor' placeholder="Fornecedor do Produto" value="{{ old('fornecedor') }}">
    <br>
    <label for='peso'>Peso:</label>
    <input type='text' name='peso' id='peso' placeholder="Peso do Produto" value="{{ old('peso') }}">
    <br>
    <label for='preco_compra'>Preço de Compra:</label>
    <input type='text' name='preco_compra' id='preco_compra' placeholder="Preço de Compra do Produto" value="{{ old('preco_compra') }}">
    <br>
    <label for='estoque'>Estoque:</label>
    <input type='text' name='estoque' id='estoque' placeholder="Estoque do Produto" value="{{ old('estoque') }}">
    <br>
    <button type='submit'>Salvar</button>   
</form>
@endsection