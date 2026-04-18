<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('services.index') }}" style="color:#475569;" class="hover:text-white text-xs uppercase tracking-wider">Serviços</a>
            <span style="color:#334155;">/</span>
            <h2 class="page-title">{{ $service->exists ? 'Editar Serviço' : 'Novo Serviço / Orçamento' }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl">
            <div class="card p-8">

                @if($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-lg text-sm" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5;">
                        @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                    </div>
                @endif

                <form method="POST"
                      action="{{ $service->exists ? route('services.update', $service) : route('services.store') }}">
                    @csrf
                    @if($service->exists) @method('PUT') @endif

                    <div class="space-y-5">

                        {{-- BLOCO CLIENTE --}}
                        @if(!$service->exists)
                        <div>
                            <label class="lbl">Cliente</label>
                            <div class="flex gap-2 mb-3">
                                <button type="button" id="btn-existente" onclick="modoCliente('existente')"
                                        class="flex-1 py-2 rounded text-xs font-bold uppercase tracking-wider transition">
                                    Já cadastrado
                                </button>
                                <button type="button" id="btn-novo" onclick="modoCliente('novo')"
                                        class="flex-1 py-2 rounded text-xs font-bold uppercase tracking-wider transition">
                                    Novo (pré-cadastro rápido)
                                </button>
                            </div>

                            <div id="bloco-existente">
                                <select name="client_id" id="client_id" class="inp">
                                    <option value="">Selecione um cliente...</option>
                                    @foreach($clients as $c)
                                        <option value="{{ $c->id }}"
                                            {{ old('client_id', $selectedClient->id ?? '') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}{{ $c->phone ? ' — '.$c->phone : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="bloco-novo" class="hidden space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="lbl">Nome *</label>
                                        <input type="text" name="new_client_name" id="new_client_name"
                                               value="{{ old('new_client_name') }}"
                                               class="inp" placeholder="Nome do cliente">
                                    </div>
                                    <div>
                                        <label class="lbl">WhatsApp</label>
                                        <input type="text" name="new_client_phone"
                                               value="{{ old('new_client_phone') }}"
                                               class="inp" placeholder="(11) 99999-9999">
                                    </div>
                                </div>
                                <p class="text-xs" style="color:#8899aa;">
                                    Um pré-cadastro será criado automaticamente. Complete os dados depois em
                                    <strong style="color:#e0cc70;">Clientes</strong>.
                                </p>
                            </div>
                        </div>
                        @else
                        <div>
                            <label class="lbl">Cliente</label>
                            <select name="client_id" class="inp">
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ $service->client_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="lbl">Título / Descrição do Serviço *</label>
                            <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                                   class="inp" placeholder="Ex: Montagem guarda-roupa casal">
                        </div>

                        <div>
                            <label class="lbl">Detalhes para o cliente</label>
                            <textarea name="description" rows="3" class="inp"
                                      placeholder="Descreva o que será feito...">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div>
                            <label class="lbl">Observações internas <span style="color:#475569; font-weight:400;">(só você vê)</span></label>
                            <textarea name="internal_notes" rows="2" class="inp"
                                      placeholder="Anotações privadas...">{{ old('internal_notes', $service->internal_notes) }}</textarea>
                        </div>

                        <div>
                            <label class="lbl">Status</label>
                            <select name="status" class="inp">
                                @foreach(['orcamento' => 'Orçamento', 'aprovado' => 'Aprovado', 'producao' => 'Em Produção', 'finalizado' => 'Finalizado', 'entregue' => 'Entregue'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('status', $service->status ?? 'orcamento') == $val ? 'selected' : '' }}>
                                        {{ $lbl }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="lbl">Data de início</label>
                                <input type="date" name="start_date"
                                       value="{{ old('start_date', $service->start_date?->format('Y-m-d')) }}"
                                       class="inp">
                            </div>
                            <div>
                                <label class="lbl">Data de entrega</label>
                                <input type="date" name="delivery_date"
                                       value="{{ old('delivery_date', $service->delivery_date?->format('Y-m-d')) }}"
                                       class="inp">
                            </div>
                        </div>

                        <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:1.25rem;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-4" style="color:#e0cc70;">Financeiro</p>

                            <div class="mb-4">
                                <label class="lbl">Valor cobrado do cliente (R$)</label>
                                <input type="number" name="total_value" step="0.01" min="0"
                                       value="{{ old('total_value', $service->total_value ?? '0') }}"
                                       class="inp">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="lbl">Custo mão de obra (R$)</label>
                                    <input type="number" name="labor_cost" step="0.01" min="0"
                                           value="{{ old('labor_cost', $service->labor_cost ?? '0') }}"
                                           class="inp">
                                </div>
                                <div>
                                    <label class="lbl">Custo materiais (R$)</label>
                                    <input type="number" name="material_cost" step="0.01" min="0"
                                           value="{{ old('material_cost', $service->material_cost ?? '0') }}"
                                           class="inp">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <button type="submit" class="btn-gold">{{ $service->exists ? 'Salvar' : 'Criar Orçamento' }}</button>
                        <a href="{{ $service->exists ? route('services.show', $service) : route('services.index') }}" class="btn-outline">Cancelar</a>
                        @if($service->exists)
                            <form method="POST" action="{{ route('services.destroy', $service) }}" class="ml-auto"
                                  onsubmit="return confirm('Remover este serviço?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger">Excluir</button>
                            </form>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
const estilo = {
    ativo:   'background:rgba(224,204,112,0.15); color:#e0cc70; border:1px solid rgba(224,204,112,0.5);',
    inativo: 'background:transparent; color:#8899aa; border:1px solid rgba(255,255,255,0.12);',
};

function modoCliente(modo) {
    const blocoEx   = document.getElementById('bloco-existente');
    const blocoNov  = document.getElementById('bloco-novo');
    const btnEx     = document.getElementById('btn-existente');
    const btnNov    = document.getElementById('btn-novo');
    const selClient = document.getElementById('client_id');
    const inpName   = document.getElementById('new_client_name');

    if (modo === 'existente') {
        blocoEx.classList.remove('hidden');
        blocoNov.classList.add('hidden');
        btnEx.style.cssText  = estilo.ativo;
        btnNov.style.cssText = estilo.inativo;
        if (selClient) selClient.required = true;
        if (inpName)   inpName.required   = false;
    } else {
        blocoEx.classList.add('hidden');
        blocoNov.classList.remove('hidden');
        btnEx.style.cssText  = estilo.inativo;
        btnNov.style.cssText = estilo.ativo;
        if (selClient) selClient.required = false;
        if (inpName)   inpName.required   = true;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const btnEx = document.getElementById('btn-existente');
    if (!btnEx) return;
    @if(old('new_client_name'))
        modoCliente('novo');
    @else
        modoCliente('existente');
    @endif
});
</script>
</x-app-layout>
