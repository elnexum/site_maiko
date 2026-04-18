<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="page-title">Serviços</h2>
            <a href="{{ route('services.create') }}" class="btn-gold">+ Novo Serviço</a>
        </div>
    </x-slot>

    <div class="py-8 space-y-4">
        @if(session('success'))
            <div class="px-4 py-3 rounded-lg text-sm" style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); color:#86efac;">{{ session('success') }}</div>
        @endif

        <div class="card p-4">
            <form method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar cliente ou serviço..." class="inp flex-1" style="min-width:200px;">
                <select name="status" class="inp" style="width:auto;">
                    <option value="">Todos os status</option>
                    @foreach(['orcamento'=>'Orçamento','aprovado'=>'Aprovado','producao'=>'Produção','finalizado'=>'Finalizado','entregue'=>'Entregue'] as $v=>$l)
                        <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <button class="btn-outline">Filtrar</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('services.index') }}" class="btn-outline">Limpar</a>
                @endif
            </form>
        </div>

        <div class="card overflow-hidden">
            @if($services->isEmpty())
                <p class="p-8 text-center text-sm" style="color:#475569;">Nenhum serviço encontrado.</p>
            @else
                <table class="w-full">
                    <thead><tr>
                        <th class="text-left">Cliente</th>
                        <th class="text-left">Serviço</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Entrega</th>
                        <th class="text-right">Valor</th>
                        <th class="text-right">Recebido</th>
                    </tr></thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td><a href="{{ route('clients.show', $service->client) }}" style="color:#e0cc70;" class="hover:underline">{{ $service->client->name }}</a></td>
                            <td><a href="{{ route('services.show', $service) }}" class="hover:underline text-white font-medium">{{ $service->title }}</a></td>
                            <td><x-service-badge :status="$service->status" /></td>
                            <td>{{ $service->delivery_date?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-right font-semibold text-white">R$ {{ number_format($service->total_value, 2, ',', '.') }}</td>
                            <td class="text-right">
                                @php $paid = $service->totalPaid(); @endphp
                                <span style="color: {{ $paid >= $service->total_value ? '#86efac' : '#f87171' }};">
                                    R$ {{ number_format($paid, 2, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4" style="border-top:1px solid rgba(255,255,255,0.05);">{{ $services->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
