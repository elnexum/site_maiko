<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Painel</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cards de resumo --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-5 text-center">
                    <p class="text-sm text-gray-500">Recebido este mês</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">R$ {{ number_format($totalReceivedMonth, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-5 text-center">
                    <p class="text-sm text-gray-500">Em andamento</p>
                    <p class="text-2xl font-bold text-yellow-500 mt-1">{{ $servicesInProgress }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-5 text-center">
                    <p class="text-sm text-gray-500">Finalizados</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $servicesFinished }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-5 text-center">
                    <p class="text-sm text-gray-500">Clientes</p>
                    <p class="text-2xl font-bold text-gray-700 mt-1">{{ $totalClients }}</p>
                </div>
            </div>

            {{-- Ações rápidas --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Ações Rápidas</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('clients.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm font-medium">
                        + Novo Cliente
                    </a>
                    <a href="{{ route('services.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm font-medium">
                        + Novo Serviço / Orçamento
                    </a>
                    <a href="{{ route('clients.index') }}"
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm font-medium">
                        Ver Clientes
                    </a>
                    <a href="{{ route('services.index') }}"
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm font-medium">
                        Ver Serviços
                    </a>
                </div>
            </div>

            {{-- Serviços recentes em andamento --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Serviços em Andamento</h3>
                @php
                    $recentes = \App\Models\Service::with('client')
                        ->whereIn('status', ['aprovado', 'producao'])
                        ->orderByDesc('updated_at')
                        ->limit(10)
                        ->get();
                @endphp
                @if($recentes->isEmpty())
                    <p class="text-gray-400 text-sm">Nenhum serviço em andamento.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="pb-2">Cliente</th>
                                    <th class="pb-2">Serviço</th>
                                    <th class="pb-2">Status</th>
                                    <th class="pb-2">Entrega</th>
                                    <th class="pb-2">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentes as $s)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2">
                                        <a href="{{ route('clients.show', $s->client) }}" class="text-blue-600 hover:underline">
                                            {{ $s->client->name }}
                                        </a>
                                    </td>
                                    <td class="py-2">
                                        <a href="{{ route('services.show', $s) }}" class="hover:underline">{{ $s->title }}</a>
                                    </td>
                                    <td class="py-2">
                                        <x-service-badge :status="$s->status" />
                                    </td>
                                    <td class="py-2">{{ $s->delivery_date?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="py-2">R$ {{ number_format($s->total_value, 2, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
