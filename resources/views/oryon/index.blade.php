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
                <div class="flex space-x-4">
                    <x-primary-button>
                        <a href="{{ route('oryon.new') }}">Novo Produto</a>
                    </x-primary-button>
                    <x-secondary-button>
                        <a href="{{ route('oryon.importar') }}">Importar Produtos</a>
                    </x-secondary-button>
                </div>
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-danger-button>
                            Menu
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" style="margin-right: -10px"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
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
            <x-text-input class="mt-1 block w-full" type="text" name="search" id="search" placeholder="Pesquisar" />
            <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-none md:table-fixed">
                            <thead class="bg-gray-300 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Código</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Descrição</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Preço</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Categoria</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Estoque</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-600 divide-y divide-gray-200 dark:divide-gray-500">
                                @foreach($produtos as $produto)
                                    <tr
                                        class="{{ $loop->odd ? 'bg-white dark:bg-gray-800' : 'bg-gray-200 dark:bg-gray-700' }}">
                                        <td class="px-6 py-4 whitespace-normal">{{ $produto->codigo }}</td>
                                        <td class="px-6 py-4 whitespace-normal">{{ $produto->descricao }}</td>
                                        <td class="px-6 py-4 whitespace-normal">
                                            {{ 'R$ ' . number_format($produto->preco, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal">{{ $produto->categoria }}</td>
                                        <td class="px-6 py-4 whitespace-normal">
                                            {{ number_format($produto->estoque, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal">
                                            <a href="{{ route('oryon.edit', $produto->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <a href="{{ route('oryon.show', $produto->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 ml-2">Detalhes</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="pagination">
                        {{$produtos->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#search').on('input', function () {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('oryon.search') }}",
                    type: "GET",
                    data: { 'search': query },
                    success: function (data) {
                        $('tbody').html(data.tableData);
                        $('.pagination').html(data.pagination);
                    }
                });
            });
        });
    </script>
</x-app-layout>