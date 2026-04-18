<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('services.index') }}" class="text-gray-400 hover:text-gray-700">Serviços</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('clients.show', $service->client) }}" class="text-gray-400 hover:text-gray-700">
                    {{ $service->client->name }}
                </a>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-xl text-gray-800">{{ $service->title }}</h2>
            </div>
            <a href="{{ route('services.edit', $service) }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200">Editar</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
            @endif

            {{-- Cabeçalho do serviço --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-400">
                            Cliente:
                            <a href="{{ route('clients.show', $service->client) }}" class="text-blue-600 hover:underline">
                                {{ $service->client->name }}
                            </a>
                            @if($service->client->phone)
                                · {{ $service->client->phone }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Criado em {{ $service->created_at->format('d/m/Y') }}
                            @if($service->start_date) · Início: {{ $service->start_date->format('d/m/Y') }} @endif
                            @if($service->delivery_date) · Entrega: {{ $service->delivery_date->format('d/m/Y') }} @endif
                        </p>
                    </div>
                    <x-service-badge :status="$service->status" />
                </div>

                @if($service->description)
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 font-medium mb-1">Descrição</p>
                        <p class="text-sm whitespace-pre-line">{{ $service->description }}</p>
                    </div>
                @endif

                @if($service->internal_notes)
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-3">
                        <p class="text-xs text-yellow-600 font-medium mb-1">Obs. interna</p>
                        <p class="text-sm whitespace-pre-line">{{ $service->internal_notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Financeiro --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Financeiro</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-6">
                    <div class="bg-blue-50 rounded p-3 text-center">
                        <p class="text-gray-500 text-xs">Valor cobrado</p>
                        <p class="font-bold text-blue-700 text-lg">R$ {{ number_format($service->total_value, 2, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-50 rounded p-3 text-center">
                        <p class="text-gray-500 text-xs">Recebido</p>
                        <p class="font-bold text-green-700 text-lg">R$ {{ number_format($service->totalPaid(), 2, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-50 rounded p-3 text-center">
                        <p class="text-gray-500 text-xs">A receber</p>
                        <p class="font-bold text-red-600 text-lg">R$ {{ number_format($service->remainingBalance(), 2, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded p-3 text-center">
                        <p class="text-gray-500 text-xs">Lucro estimado</p>
                        @php $profit = $service->profit(); @endphp
                        <p class="font-bold text-lg {{ $profit >= 0 ? 'text-gray-700' : 'text-red-600' }}">
                            R$ {{ number_format($profit, 2, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="text-xs text-gray-400 flex gap-6 mb-6">
                    <span>Mão de obra: <strong>R$ {{ number_format($service->labor_cost, 2, ',', '.') }}</strong></span>
                    <span>Material: <strong>R$ {{ number_format($service->material_cost, 2, ',', '.') }}</strong></span>
                    <span>Total custo: <strong>R$ {{ number_format($service->totalCost(), 2, ',', '.') }}</strong></span>
                </div>

                {{-- Registrar pagamento --}}
                @if($service->remainingBalance() > 0)
                <div class="border-t pt-4">
                    <h4 class="text-sm font-medium text-gray-600 mb-3">Registrar Pagamento</h4>
                    <form method="POST" action="{{ route('payments.store') }}" class="flex flex-wrap gap-2">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="number" name="amount" step="0.01" min="0.01"
                               value="{{ number_format($service->remainingBalance(), 2, '.', '') }}"
                               placeholder="Valor (R$)"
                               class="border rounded px-3 py-2 text-sm w-36 focus:outline-none focus:ring focus:ring-blue-200">
                        <input type="date" name="paid_at" value="{{ date('Y-m-d') }}"
                               class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        <select name="method" class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            <option value="pix">PIX</option>
                            <option value="dinheiro">Dinheiro</option>
                            <option value="cartao">Cartão</option>
                        </select>
                        <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
                            Registrar
                        </button>
                    </form>
                </div>
                @endif

                {{-- Histórico de pagamentos --}}
                @if($service->payments->isNotEmpty())
                <div class="border-t pt-4 mt-4">
                    <h4 class="text-sm font-medium text-gray-600 mb-3">Pagamentos recebidos</h4>
                    <table class="w-full text-sm">
                        <thead class="text-gray-400 text-xs">
                            <tr>
                                <th class="text-left pb-1">Data</th>
                                <th class="text-left pb-1">Forma</th>
                                <th class="text-right pb-1">Valor</th>
                                <th class="pb-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service->payments->sortByDesc('paid_at') as $payment)
                            <tr class="border-t">
                                <td class="py-2">{{ $payment->paid_at->format('d/m/Y') }}</td>
                                <td class="py-2 uppercase text-xs">{{ $payment->method }}</td>
                                <td class="py-2 text-right font-medium">R$ {{ number_format($payment->amount, 2, ',', '.') }}</td>
                                <td class="py-2 text-right">
                                    <form method="POST" action="{{ route('payments.destroy', $payment) }}"
                                          onsubmit="return confirm('Remover este pagamento?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-600 text-xs">Remover</button>
                                    </form>
                                </td>
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
