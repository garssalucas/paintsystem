<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edição de Produto Oryon') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informações do Produto ') }} -> {{ $produto->descricao }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Atualize abaixo as informações do produto') }}
                        </p>
                    </header>
                    <br>
                    <form action="{{ route('oryon.update', $produto->id) }} " method='POST'>
                        @csrf
                        @method('PUT')
                        @include('oryon.partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>