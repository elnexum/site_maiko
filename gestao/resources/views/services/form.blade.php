<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('services.index') }}" class="text-gray-400 hover:text-gray-700">Serviços</a>
            <span class="text-gray-400">/</span>
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $service->exists ? 'Editar Serviço' : 'Novo Serviço / Orçamento' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ $service->exists ? route('services.update', $service) : route('services.store') }}">
                    @csrf
                    @if($service->exists) @method('PUT') @endif

                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
                            <select name="client_id" required
                                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                                <option value="">Selecione...</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('client_id', $service->client_id ?? ($selectedClient->id ?? '')) == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Título / Descrição do Serviço *</label>
                            <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200"
                                   placeholder="Ex: Manutenção portão eletrônico">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Detalhes para o cliente</label>
                            <textarea name="description" rows="3"
                                      class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200"
                                      placeholder="Descreva o que será feito...">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observações internas</label>
                            <textarea name="internal_notes" rows="2"
                                      class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200"
                                      placeholder="Anotações só para você (não aparece para o cliente)">{{ old('internal_notes', $service->internal_notes) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                                @foreach(['orcamento' => 'Orçamento', 'aprovado' => 'Aprovado', 'producao' => 'Em Produção', 'finalizado' => 'Finalizado', 'entregue' => 'Entregue'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('status', $service->status ?? 'orcamento') == $val ? 'selected' : '' }}>
                                        {{ $lbl }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data de início</label>
                                <input type="date" name="start_date"
                                       value="{{ old('start_date', $service->start_date?->format('Y-m-d')) }}"
                                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data de entrega</label>
                                <input type="date" name="delivery_date"
                                       value="{{ old('delivery_date', $service->delivery_date?->format('Y-m-d')) }}"
                                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                        </div>

                        <hr>
                        <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Financeiro</p>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Valor cobrado (R$) *</label>
                            <input type="number" name="total_value" step="0.01" min="0"
                                   value="{{ old('total_value', $service->total_value ?? '0') }}" required
                                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Custo mão de obra (R$)</label>
                                <input type="number" name="labor_cost" step="0.01" min="0"
                                       value="{{ old('labor_cost', $service->labor_cost ?? '0') }}"
                                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Custo materiais (R$)</label>
                                <input type="number" name="material_cost" step="0.01" min="0"
                                       value="{{ old('material_cost', $service->material_cost ?? '0') }}"
                                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 text-sm font-medium">
                            {{ $service->exists ? 'Salvar' : 'Criar Serviço' }}
                        </button>
                        <a href="{{ $service->exists ? route('services.show', $service) : route('services.index') }}"
                           class="px-4 py-2 text-sm text-gray-600 hover:underline">Cancelar</a>

                        @if($service->exists)
                            <form method="POST" action="{{ route('services.destroy', $service) }}" class="ml-auto"
                                  onsubmit="return confirm('Remover este serviço?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">Excluir</button>
                            </form>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
