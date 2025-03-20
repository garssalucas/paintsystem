<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Seu endereço de e-mail não está verificado.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" class="mt-1 block w-full">
                <option value="1" {{ old('status', $user->status ?? '') ? 'selected' : '' }}>{{ __('Ativo') }}</option>
                <option value="0" {{ !old('status', $user->status ?? '') ? 'selected' : '' }}>{{ __('Inativo') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div>
            <x-input-label for="atende_rua" :value="__('Atende na Rua')" />
            <select id="atende_rua" name="atende_rua" class="mt-1 block w-full">
                <option value="1" {{ old('atende_rua', $user->atende_rua ?? '') ? 'selected' : '' }}>{{ __('Sim') }}</option>
                <option value="0" {{ !old('atende_rua', $user->atende_rua ?? '') ? 'selected' : '' }}>{{ __('Não') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('atende_rua')" />
        </div>

        <div>
            <x-input-label for="area" :value="__('Área')" />
            <select id="area" name="area" class="mt-1 block w-full" required>
                <option value="administracao" {{ old('area', $user->area) == 'administracao' ? 'selected' : '' }}>{{ __('Administração') }}</option>
                <option value="gerencia" {{ old('area', $user->area) == 'gerencia' ? 'selected' : '' }}>{{ __('Gerência') }}</option>
                <option value="laboratorio" {{ old('area', $user->area) == 'laboratorio' ? 'selected' : '' }}>{{ __('Laboratório') }}</option>
                <option value="vendas" {{ old('area', $user->area) == 'vendas' ? 'selected' : '' }}>{{ __('Vendas') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('area')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>