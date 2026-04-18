<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if($errors->any())
            <div class="mb-4 bg-red-50 text-red-600 text-sm px-4 py-3 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                Lembrar de mim
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full py-3 rounded-lg font-bold text-sm tracking-wide transition"
                style="background:#d4a017; color:#000;">
            ENTRAR
        </button>
    </form>
</x-guest-layout>
