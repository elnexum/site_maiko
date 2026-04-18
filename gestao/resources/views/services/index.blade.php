<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Serviços</h2>
            <a href="{{ route('services.create') }}" class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">+ Novo Serviço</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white rounded-lg shadow p-4">
                <form method="GET" class="flex flex-wrap gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar cliente ou serviço..."
                           class="border rounded px-3 py-2 text-sm flex-1 focus:outline-none focus:ring focus:ring-blue-200">
                    <select name="status" class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        <option value="">Todos os status</option>
                        <option value="orcamento"  {{ request('status') == 'orcamento'  ? 'selected' : '' }}>Orçamento</option>
                        <option value="aprovado"   {{ request('status') == 'aprovado'   ? 'selected' : '' }}>Aprovado</option>
                        <option value="producao"   {{ request('status') == 'producao'   ? 'selected' : '' }}>Produção</option>
                        <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        <option value="entregue"   {{ request('status') == 'entregue'   ? 'selected' : '' }}>Entregue</option>
                    </select>
                    <button class="bg-gray-100 px-4 py-2 rounded text-sm hover:bg-gray-200">Filtrar</button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('services.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:underline">Limpar</a>
                    @endif
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($services->isEmpty())
                    <p class="p-6 text-gray-400 text-center">Nenhum serviço encontrado.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Serviço</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Entrega</th>
                                <th class="px-4 py-3 text-right">Valor</th>
                                <th class="px-4 py-3 text-right">Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('clients.show', $service->client) }}" class="text-blue-600 hover:underline">
                                        {{ $service->client->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('services.show', $service) }}" class="hover:underline font-medium">
                                        {{ $service->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-3"><x-service-badge :status="$service->status" /></td>
                                <td class="px-4 py-3">{{ $service->delivery_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">R$ {{ number_format($service->total_value, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right">
                                    @php $paid = $service->totalPaid(); @endphp
                                    <span class="{{ $paid >= $service->total_value ? 'text-green-600' : 'text-red-500' }}">
                                        R$ {{ number_format($paid, 2, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 py-3">{{ $services->links() }}</div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
