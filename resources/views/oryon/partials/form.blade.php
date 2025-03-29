@csrf
<x-alert type="success" :message="session('success')" />
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informações do Produto ') }} -> {{ $produto->descricao }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Atualize abaixo as informações do produto') }}
        </p>
    </header>
    <br>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="codigo" :value="__('Código:')" />
            <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" placeholder="Código do Produto" value="{{ $produto->codigo ?? old('codigo') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
        </div>

        <div>
            <x-input-label for="descricao" :value="__('Descrição:')" />
            <x-text-input id="descricao" name="descricao" type="text" class="mt-1 block w-full" placeholder="Descrição do Produto" value="{{ $produto->descricao ?? old('descricao') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
        </div>

        <div>
            <x-input-label for="preco" :value="__('Preço:')" />
            <x-text-input id="preco" name="preco" type="text" class="mt-1 block w-full" placeholder="Preço do Produto" value="{{ $produto->preco ?? old('preco') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('preco')" />
        </div>

        <div>
            <x-input-label for="categoria" :value="__('Categoria:')" />
            <x-text-input id="categoria" name="categoria" type="text" class="mt-1 block w-full" placeholder="Categoria do Produto" value="{{ $produto->categoria ?? old('categoria') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('categoria')" />
        </div>

        <div>
            <x-input-label for="fornecedor" :value="__('Fornecedor:')" />
            <x-text-input id="fornecedor" name="fornecedor" type="text" class="mt-1 block w-full" placeholder="Fornecedor do Produto" value="{{ $produto->fornecedor ?? old('fornecedor') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('fornecedor')" />
        </div>

        <div>
            <x-input-label for="peso" :value="__('Peso:')" />
            <x-text-input id="peso" name="peso" type="text" class="mt-1 block w-full" placeholder="Peso do Produto" value="{{ $produto->peso ?? old('peso') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('peso')" />
        </div>

        <div>
            <x-input-label for="preco_compra" :value="__('Preço de Compra:')" />
            <x-text-input id="preco_compra" name="preco_compra" type="text" class="mt-1 block w-full" placeholder="Preço de Compra do Produto" value="{{ $produto->preco_compra ?? old('preco_compra') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('preco_compra')" />
        </div>

        <div>
            <x-input-label for="estoque" :value="__('Estoque:')" />
            <x-text-input id="estoque" name="estoque" type="text" class="mt-1 block w-full" placeholder="Estoque do Produto" value="{{ $produto->estoque ?? old('estoque') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('estoque')" />
        </div>
    </div>

    <div class="mt-4 flex justify-between w-full">
        <a href="{{ route('oryon.index') }}">
            <x-secondary-button class="btn btn-secondary">Voltar</x-secondary-button>
        </a>
        <x-secondary-button type="submit" class="btn btn-secondary">Salvar</x-secondary-button>
    </div>
    
</section>