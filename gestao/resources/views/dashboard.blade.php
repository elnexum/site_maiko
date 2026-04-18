<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Painel</h2>
    </x-slot>

    <div class="py-8 space-y-6">

        {{-- Cards resumo --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="card card-gold p-5 text-center">
                <p class="lbl">Recebido este mês</p>
                <p class="text-2xl font-bold mt-2" style="color:#e0cc70;">R$ {{ number_format($totalReceivedMonth, 2, ',', '.') }}</p>
            </div>
            <div class="card p-5 text-center">
                <p class="lbl">Em andamento</p>
                <p class="text-2xl font-bold mt-2" style="color:#fde047;">{{ $servicesInProgress }}</p>
            </div>
            <div class="card p-5 text-center">
                <p class="lbl">Finalizados</p>
                <p class="text-2xl font-bold mt-2" style="color:#86efac;">{{ $servicesFinished }}</p>
            </div>
            <div class="card p-5 text-center">
                <p class="lbl">Clientes</p>
                <p class="text-2xl font-bold mt-2 text-white">{{ $totalClients }}</p>
            </div>
        </div>

        {{-- Ações rápidas --}}
        <div class="card p-6">
            <p class="lbl mb-4">Ações Rápidas</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('clients.create') }}" class="btn-gold">+ Novo Cliente</a>
                <a href="{{ route('services.create') }}" class="btn-outline" style="border-color:rgba(224,204,112,0.3); color:#e0cc70;">+ Novo Serviço / Orçamento</a>
                <a href="{{ route('clients.index') }}" class="btn-outline">Ver Clientes</a>
                <a href="{{ route('services.index') }}" class="btn-outline">Ver Serviços</a>
            </div>
        </div>

        {{-- Serviços em andamento --}}
        <div class="card p-6">
            <p class="lbl mb-4">Serviços em Andamento</p>
            @php
                $recentes = \App\Models\Service::with('client')
                    ->whereIn('status', ['aprovado', 'producao'])
                    ->orderByDesc('updated_at')->limit(10)->get();
            @endphp
            @if($recentes->isEmpty())
                <p style="color:#475569; font-size:0.82rem;">Nenhum serviço em andamento.</p>
            @else
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full">
                        <thead><tr>
                            <th class="text-left">Cliente</th>
                            <th class="text-left">Serviço</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Entrega</th>
                            <th class="text-right">Valor</th>
                        </tr></thead>
                        <tbody>
                            @foreach($recentes as $s)
                            <tr>
                                <td><a href="{{ route('clients.show', $s->client) }}" style="color:#e0cc70;" class="hover:underline">{{ $s->client->name }}</a></td>
                                <td><a href="{{ route('services.show', $s) }}" class="hover:underline text-white">{{ $s->title }}</a></td>
                                <td><x-service-badge :status="$s->status" /></td>
                                <td>{{ $s->delivery_date?->format('d/m/Y') ?? '—' }}</td>
                                <td class="text-right font-semibold text-white">R$ {{ number_format($s->total_value, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
