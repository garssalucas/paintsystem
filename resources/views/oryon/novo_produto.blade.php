@extends('layouts.main')

@section('title', 'Cadastrar Produto Oryon')

@section('content')

<H1>Novo Produto</H1>
<form action="{{ route('oryon.store') }} " method='POST'>
    @csrf
    <label for='codigo'>Código:</label>
    <input type='text' name='codigo' id='codigo'>
    <br>
    <label for='descricao'>Descrição:</label>
    <input type='text' name='descricao' id='descricao'>
    <br>
    <label for='preco'>Preço:</label>
    <input type='text' name='preco' id='preco'>
    <br>
    <label for='categoria'>Categoria:</label>
    <input type='text' name='categoria' id='categoria'>
    <br>
    <label for='fornecedor'>Fornecedor:</label>
    <input type='text' name='fornecedor' id='fornecedor'>
    <br>
    <label for='peso'>Peso:</label>
    <input type='text' name='peso' id='peso'>
    <br>
    <label for='preco_compra'>Preço de Compra:</label>
    <input type='text' name='preco_compra' id='preco_compra'>
    <br>
    <label for='estoque'>Estoque:</label>
    <input type='text' name='estoque' id='estoque'>
    <br>
    <button type='submit'>Salvar</button>   
</form>
@endsection