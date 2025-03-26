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
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Seu endereço de e-mail não está verificado.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
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

        <div class="flex space-x-4">
            <div class="flex-1">
                <x-input-label for="status" :value="__('Status')" />
                <x-dropdown align="left">
                    <x-slot name="trigger">
                        <div id="status-trigger"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 w-full">
                            <div id="status-text">{{ old('status', $user->status ?? '') ? __('Ativo') : __('Inativo') }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link @click.prevent="document.getElementById('status').value = 1; document.getElementById('status-text').innerText = '{{ __('Ativo') }}';">
                            {{ __('Ativo') }}
                        </x-dropdown-link>
                        <x-dropdown-link @click.prevent="document.getElementById('status').value = 0; document.getElementById('status-text').innerText = '{{ __('Inativo') }}';">
                            {{ __('Inativo') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                <input type="hidden" id="status" name="status" value="{{ old('status', $user->status ?? '') }}">
                <x-input-error class="mt-2" :messages="$errors->get('status')" />
            </div>

            <div class="flex-1">
                <x-input-label for="atende_rua" :value="__('Atende na Rua')" />
                <x-dropdown align="left">
                    <x-slot name="trigger">
                        <div id="atende_rua-trigger"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 w-full">
                            <div id="atende_rua-text">{{ old('atende_rua', $user->atende_rua ?? '') ? __('Sim') : __('Não') }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link @click.prevent="document.getElementById('atende_rua').value = 1; document.getElementById('atende_rua-text').innerText = '{{ __('Sim') }}';">
                            {{ __('Sim') }}
                        </x-dropdown-link>
                        <x-dropdown-link @click.prevent="document.getElementById('atende_rua').value = 0; document.getElementById('atende_rua-text').innerText = '{{ __('Não') }}';">
                            {{ __('Não') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                <input type="hidden" id="atende_rua" name="atende_rua" value="{{ old('atende_rua', $user->atende_rua ?? '') }}">
                <x-input-error class="mt-2" :messages="$errors->get('atende_rua')" />
            </div>

            <div class="flex-1">
                <x-input-label for="area" :value="__('Área')" />
                <x-dropdown align="left">
                    <x-slot name="trigger">
                        <div id="area-trigger"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 w-full">
                            <div id="area-text">
                                @switch(old('area', $user->area ?? ''))
                                    @case('administracao')
                                        {{ __('Administração') }}
                                        @break
                                    @case('gerencia')
                                        {{ __('Gerência') }}
                                        @break
                                    @case('laboratorio')
                                        {{ __('Laboratório') }}
                                        @break
                                    @case('vendas')
                                        {{ __('Vendas') }}
                                        @break
                                    @default
                                        {{ __('Selecione uma área') }}
                                @endswitch
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link @click.prevent="document.getElementById('area').value = 'administracao'; document.getElementById('area-text').innerText = '{{ __('Administração') }}';">
                            {{ __('Administração') }}
                        </x-dropdown-link>
                        <x-dropdown-link @click.prevent="document.getElementById('area').value = 'gerencia'; document.getElementById('area-text').innerText = '{{ __('Gerência') }}';">
                            {{ __('Gerência') }}
                        </x-dropdown-link>
                        <x-dropdown-link @click.prevent="document.getElementById('area').value = 'laboratorio'; document.getElementById('area-text').innerText = '{{ __('Laboratório') }}';">
                            {{ __('Laboratório') }}
                        </x-dropdown-link>
                        <x-dropdown-link @click.prevent="document.getElementById('area').value = 'vendas'; document.getElementById('area-text').innerText = '{{ __('Vendas') }}';">
                            {{ __('Vendas') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                <input type="hidden" id="area" name="area" value="{{ old('area', $user->area ?? '') }}">
                <x-input-error class="mt-2" :messages="$errors->get('area')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>