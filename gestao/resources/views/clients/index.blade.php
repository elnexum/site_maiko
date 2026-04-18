<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="page-title">Clientes</h2>
            <a href="{{ route('clients.create') }}" class="btn-gold">+ Novo Cliente</a>
        </div>
    </x-slot>

    <div class="py-8 space-y-4">
        @if(session('success'))
            <div class="px-4 py-3 rounded-lg text-sm" style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); color:#86efac;">{{ session('success') }}</div>
        @endif

        <div class="card p-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou telefone..."
                       class="inp flex-1">
                <button class="btn-outline">Buscar</button>
                @if(request('search'))
                    <a href="{{ route('clients.index') }}" class="btn-outline">Limpar</a>
                @endif
            </form>
        </div>

        <div class="card overflow-hidden">
            @if($clients->isEmpty())
                <p class="p-8 text-center text-sm" style="color:#475569;">Nenhum cliente cadastrado.</p>
            @else
                <table class="w-full">
                    <thead><tr>
                        <th class="text-left">Nome</th>
                        <th class="text-left">Telefone</th>
                        <th class="text-left">Email</th>
                        <th class="text-center">Serviços</th>
                        <th></th>
                    </tr></thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td><a href="{{ route('clients.show', $client) }}" style="color:#e0cc70;" class="hover:underline font-semibold">{{ $client->name }}</a></td>
                            <td>{{ $client->phone ?? '—' }}</td>
                            <td>{{ $client->email ?? '—' }}</td>
                            <td class="text-center">{{ $client->services()->count() }}</td>
                            <td class="text-right"><a href="{{ route('clients.edit', $client) }}" class="btn-outline text-xs" style="padding:0.3rem 0.8rem;">Editar</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4" style="border-top:1px solid rgba(255,255,255,0.05);">{{ $clients->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
