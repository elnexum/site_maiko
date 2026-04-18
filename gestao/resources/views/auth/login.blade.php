<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if($errors->any())
            <div class="mb-5 text-sm px-4 py-3 rounded-lg" style="background:rgba(239,68,68,0.15); color:#fca5a5; border:1px solid rgba(239,68,68,0.3);">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-5">
            <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color:#8899aa;">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="w-full px-4 py-3 rounded-lg text-sm outline-none transition"
                   style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); color:#e2e8f0; caret-color:#e0cc70;"
                   onfocus="this.style.borderColor='#e0cc70'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
        </div>

        <div class="mb-5">
            <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color:#8899aa;">Senha</label>
            <div class="relative">
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       class="w-full px-4 py-3 pr-12 rounded-lg text-sm outline-none transition"
                       style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); color:#e2e8f0; caret-color:#e0cc70;"
                       onfocus="this.style.borderColor='#e0cc70'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                <button type="button" onclick="toggleSenha()" class="absolute right-3 top-1/2 -translate-y-1/2 opacity-50 hover:opacity-100 transition">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#e0cc70">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2 text-xs cursor-pointer" style="color:#8899aa;">
                <input type="checkbox" name="remember" class="rounded" style="accent-color:#e0cc70;">
                Lembrar de mim
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs hover:underline" style="color:#8899aa;">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full py-3 rounded-lg text-sm font-bold tracking-widest uppercase transition hover:opacity-90 active:scale-95"
                style="background:linear-gradient(90deg,#c9a227,#e0cc70); color:#0b1a30;">
            Entrar
        </button>
    </form>

    <script>
    function toggleSenha() {
        const inp = document.getElementById('password');
        inp.type = inp.type === 'password' ? 'text' : 'password';
    }
    </script>
</x-guest-layout>
