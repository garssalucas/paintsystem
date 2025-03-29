<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Produtos Oryon') }}
        </h2>
    </x-slot>
    <div class="pb-12 pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
            <x-text-input class="mt-1 block w-full" type="text" name="search" id="search"
                placeholder="Pesquisar produtos por descrição ou código" />
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
                                        <td class="px-6 py-4 whitespace-normal inline-flex items-center">
                                            <a href="{{ route('oryon.edit', $produto->id) }}"><x-lucide-pencil
                                                    class="w-4 h-4 mr-2" /></a>
                                            <form action="{{ route('oryon.destroy', $produto->id) }}" method="POST"
                                                class="inline" onsubmit="return confirmDelete('{{ $produto->descricao }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="focus:outline-none">
                                                    <x-lucide-trash-2 class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="flex justify-between items-center">
                        <div class="pagination">
                            {{$produtos->links()}}
                        </div>
                        @can('is-admin')
                            <div>
                                <x-primary-button class="px-1">
                                    <a href="{{ route('oryon.new') }}" class="inline-flex items-center">
                                        <x-lucide-circle-plus class="w-4 h-4 mr-2" />Novo Produto
                                    </a>
                                </x-primary-button>
                                <x-secondary-button>
                                    <a href="{{ route('oryon.importar') }}" class="inline-flex items-center">
                                        <x-lucide-download class="w-4 h-4 mr-2" />Importar Produtos
                                    </a>
                                </x-secondary-button>
                            </div>
                        @endcan
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
        function confirmDelete(nomeProduto) {
            return confirm("Tem certeza que deseja excluir o produto: " + nomeProduto + "?");
        }
    </script>
</x-app-layout>