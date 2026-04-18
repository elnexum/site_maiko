<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Clientes</h2>
            <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">+ Novo Cliente</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow p-4">
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por nome ou telefone..."
                           class="border rounded px-3 py-2 text-sm flex-1 focus:outline-none focus:ring focus:ring-blue-200">
                    <button class="bg-gray-100 px-4 py-2 rounded text-sm hover:bg-gray-200">Buscar</button>
                    @if(request('search'))
                        <a href="{{ route('clients.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:underline">Limpar</a>
                    @endif
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($clients->isEmpty())
                    <p class="p-6 text-gray-400 text-center">Nenhum cliente cadastrado.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Nome</th>
                                <th class="px-4 py-3 text-left">Telefone</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Serviços</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:underline font-medium">
                                        {{ $client->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ $client->phone ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $client->email ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $client->services_count ?? $client->services()->count() }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('clients.edit', $client) }}" class="text-gray-500 hover:text-blue-600 text-xs">Editar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 py-3">{{ $clients->links() }}</div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
