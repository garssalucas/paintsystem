@extends('layouts.main')

@section('title', 'Lista de Produtos Oryon')

@section('content')

    <a href="{{ route('oryon.new') }}">Novo Produto</></a>
        <h1>Lista de Produtos Oryon</h1>

        <!-- Mensagens de sucesso ou erro -->
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <!-- Tabela para exibir os produtos -->
        <table border="1">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Fornecedor</th>
                    <th>Peso</th>
                    <th>Preço de Compra</th>
                    <th>Estoque</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->codigo }}</td>
                        <td>{{ $produto->descricao }}</td>
                        <td>{{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td>{{ $produto->categoria }}</td>
                        <td>{{ $produto->fornecedor }}</td>
                        <td>{{ number_format($produto->peso, 3, ',', '.') }}</td>
                        <td>{{ number_format($produto->preco_compra, 2, ',', '.') }}</td>
                        <td>{{ number_format($produto->estoque, 3, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$produtos->links()}}
        <a href="{{ route('oryon.importar') }}">Importar Produtos</a>
@endsection