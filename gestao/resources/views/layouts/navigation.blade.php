<nav x-data="{ open: false }" style="background:#0f1923; border-bottom:1px solid #d4a01733;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <img src="https://yokohama.elnexum.com.br/logo.png" alt="Shopping Yokohama" class="h-9 w-9 rounded">
                    <span class="font-bold text-sm hidden sm:block" style="color:#d4a017;">Shopping Yokohama</span>
                </a>

                <!-- Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-8 space-x-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'text-yellow-400 bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        Painel
                    </a>
                    <a href="{{ route('clients.index') }}"
                       class="px-3 py-2 rounded text-sm font-medium transition {{ request()->routeIs('clients.*') ? 'text-yellow-400 bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        Clientes
                    </a>
                    <a href="{{ route('services.index') }}"
                       class="px-3 py-2 rounded text-sm font-medium transition {{ request()->routeIs('services.*') ? 'text-yellow-400 bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        Serviços
                    </a>
                </div>
            </div>

            <!-- Usuário -->
            <div class="hidden sm:flex sm:items-center gap-3">
                <span class="text-gray-400 text-sm">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 hover:text-red-400 transition">Sair</button>
                </form>
            </div>

            <!-- Hamburger mobile -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="text-gray-400 hover:text-white p-2">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background:#0f1923; border-top:1px solid #ffffff11;">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded text-sm text-gray-300 hover:text-white hover:bg-white/10">Painel</a>
            <a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded text-sm text-gray-300 hover:text-white hover:bg-white/10">Clientes</a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded text-sm text-gray-300 hover:text-white hover:bg-white/10">Serviços</a>
        </div>
        <div class="px-4 py-3 border-t border-white/10">
            <p class="text-sm text-gray-400 mb-2">{{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-400">Sair</button>
            </form>
        </div>
    </div>
</nav>
