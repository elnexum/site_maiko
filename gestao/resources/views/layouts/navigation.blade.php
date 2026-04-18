<nav x-data="{ open: false }" style="background:linear-gradient(90deg,#0f1f38,#0b1a30); border-bottom:1px solid rgba(224,204,112,0.2); font-family:'Montserrat',sans-serif;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <img src="https://yokohama.elnexum.com.br/logo.png" alt="Logo" class="h-8 w-8 rounded">
                    <span class="font-bold text-xs tracking-widest uppercase hidden sm:block" style="color:#e0cc70;">Shopping Yokohama</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded text-xs font-semibold uppercase tracking-wider transition"
                       style="color: {{ request()->routeIs('dashboard') ? '#e0cc70' : '#8899aa' }}; background: {{ request()->routeIs('dashboard') ? 'rgba(224,204,112,0.08)' : 'transparent' }};">
                        Painel
                    </a>
                    <a href="{{ route('clients.index') }}"
                       class="px-3 py-2 rounded text-xs font-semibold uppercase tracking-wider transition"
                       style="color: {{ request()->routeIs('clients.*') ? '#e0cc70' : '#8899aa' }}; background: {{ request()->routeIs('clients.*') ? 'rgba(224,204,112,0.08)' : 'transparent' }};">
                        Clientes
                    </a>
                    <a href="{{ route('services.index') }}"
                       class="px-3 py-2 rounded text-xs font-semibold uppercase tracking-wider transition"
                       style="color: {{ request()->routeIs('services.*') ? '#e0cc70' : '#8899aa' }}; background: {{ request()->routeIs('services.*') ? 'rgba(224,204,112,0.08)' : 'transparent' }};">
                        Serviços
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-4">
                <span class="text-xs font-medium" style="color:#8899aa;">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-semibold uppercase tracking-wider transition hover:opacity-80" style="color:#e0cc70;">Sair</button>
                </form>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2" style="color:#8899aa;">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background:#0b1a30; border-top:1px solid rgba(224,204,112,0.1);">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded text-xs font-semibold uppercase tracking-wider" style="color:#8899aa;">Painel</a>
            <a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded text-xs font-semibold uppercase tracking-wider" style="color:#8899aa;">Clientes</a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded text-xs font-semibold uppercase tracking-wider" style="color:#8899aa;">Serviços</a>
        </div>
        <div class="px-4 py-3" style="border-top:1px solid rgba(255,255,255,0.05);">
            <p class="text-xs mb-2" style="color:#8899aa;">{{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-xs font-semibold uppercase tracking-wider" style="color:#e0cc70;">Sair</button>
            </form>
        </div>
    </div>
</nav>
