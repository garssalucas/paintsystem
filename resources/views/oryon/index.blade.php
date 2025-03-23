<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Produtos Oryon') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert />
            <div class="flex justify-between items-center mb-4">
                <div>
                    <x-primary-button>
                        <a href="{{ route('oryon.new') }}">Novo Produto</a>
                    </x-primary-button>
                    <x-secondary-button>
                        <a href="{{ route('oryon.importar') }}">Importar Produtos</a>
                    </x-secondary-button>
                </div>
                <x-dropdown align="right">
                    <x-slot name="trigger">
                        <x-danger-button>
                            Menu
                        </x-danger-button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="#">
                            Option 1
                        </x-dropdown-link>
                        <x-dropdown-link href="#">
                            Option 2
                        </x-dropdown-link>
                        <x-dropdown-link href="#">
                            Option 3
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
            <x-text-input class="mt-1 block w-full" type="text" name="search" placeholder="Pesquisar" />
            <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table border="1" class="table-auto">
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
                                <th>Ações</th>
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
                                    <td>
                                        <a href="{{ route('oryon.edit', $produto->id) }}">Editar</a>
                                        <a href="{{ route('oryon.show', $produto->id) }}">Detalhes</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$produtos->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>