<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('clients.index') }}" class="text-gray-400 hover:text-gray-700">Clientes</a>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-xl text-gray-800">{{ $client->name }}</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('services.create', ['client_id' => $client->id]) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">+ Serviço</a>
                <a href="{{ route('clients.edit', $client) }}"
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
            @endif

            {{-- Dados do cliente --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Dados do Cliente</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400">Telefone</p>
                        <p class="font-medium">{{ $client->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Email</p>
                        <p class="font-medium">{{ $client->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">CPF / CNPJ</p>
                        <p class="font-medium">{{ $client->document ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400">Endereço</p>
                        <p class="font-medium">{{ $client->address ?? '-' }}</p>
                    </div>
                    @if($client->notes)
                    <div class="col-span-3">
                        <p class="text-gray-400">Observações</p>
                        <p class="font-medium whitespace-pre-line">{{ $client->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Histórico de serviços --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-700">Histórico de Serviços</h3>
                    <span class="text-sm text-gray-400">{{ $client->services->count() }} serviço(s)</span>
                </div>

                @if($client->services->isEmpty())
                    <p class="text-gray-400 text-sm">Nenhum serviço registrado.</p>
                @else
                    <div class="space-y-3">
                        @foreach($client->services->sortByDesc('created_at') as $service)
                        <div class="border rounded p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('services.show', $service) }}" class="font-medium text-blue-600 hover:underline">
                                        {{ $service->title }}
                                    </a>
                                    <div class="flex gap-3 mt-1 text-xs text-gray-500">
                                        <span>Criado: {{ $service->created_at->format('d/m/Y') }}</span>
                                        @if($service->delivery_date)
                                            <span>Entrega: {{ $service->delivery_date->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <x-service-badge :status="$service->status" />
                                    <p class="text-sm font-medium mt-1">R$ {{ number_format($service->total_value, 2, ',', '.') }}</p>
                                    @php $remaining = $service->remainingBalance(); @endphp
                                    @if($remaining > 0)
                                        <p class="text-xs text-red-500">Falta: R$ {{ number_format($remaining, 2, ',', '.') }}</p>
                                    @else
                                        <p class="text-xs text-green-600">Pago</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totais --}}
                    <div class="mt-4 pt-4 border-t flex justify-end gap-6 text-sm">
                        <div class="text-right">
                            <p class="text-gray-400">Total em serviços</p>
                            <p class="font-bold">R$ {{ number_format($client->services->sum('total_value'), 2, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-400">Total recebido</p>
                            <p class="font-bold text-green-600">
                                R$ {{ number_format($client->services->sum(fn($s) => $s->totalPaid()), 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
