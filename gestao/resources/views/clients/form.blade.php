<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('clients.index') }}" style="color:#475569;" class="hover:text-white text-xs uppercase tracking-wider">Clientes</a>
            <span style="color:#334155;">/</span>
            <h2 class="page-title">{{ $client->exists ? 'Editar Cliente' : 'Novo Cliente' }}</h2>
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

                <form method="POST" action="{{ $client->exists ? route('clients.update', $client) : route('clients.store') }}">
                    @csrf
                    @if($client->exists) @method('PUT') @endif

                    <div class="space-y-5">

                        <div>
                            <label class="lbl">Nome *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required class="inp">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="lbl">Telefone / WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="inp">
                            </div>
                            <div>
                                <label class="lbl">CPF / CNPJ</label>
                                <div class="relative">
                                    <input type="text" name="document" id="document"
                                           value="{{ old('document', $client->document) }}"
                                           class="inp pr-10" placeholder="00.000.000/0001-00"
                                           oninput="formatarDoc(this)" onblur="buscarCNPJ(this.value)">
                                    <span id="doc-loading" class="absolute right-3 top-1/2 -translate-y-1/2 hidden text-xs" style="color:#e0cc70;">⟳</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="lbl">Email</label>
                            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="inp">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label class="lbl">Endereço</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}" class="inp" placeholder="Rua, número, bairro">
                            </div>
                            <div>
                                <label class="lbl">CEP</label>
                                <input type="text" name="cep" id="cep" class="inp" placeholder="00000-000"
                                       oninput="formatarCEP(this)" onblur="buscarCEP(this.value)">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="lbl">Cidade</label>
                                <input type="text" name="city" id="city" class="inp">
                            </div>
                            <div>
                                <label class="lbl">Estado</label>
                                <input type="text" name="state" id="state" class="inp" maxlength="2" style="text-transform:uppercase;">
                            </div>
                        </div>

                        <div>
                            <label class="lbl">Observações</label>
                            <textarea name="notes" rows="3" class="inp">{{ old('notes', $client->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <button type="submit" class="btn-gold">{{ $client->exists ? 'Salvar' : 'Cadastrar' }}</button>
                        <a href="{{ $client->exists ? route('clients.show', $client) : route('clients.index') }}" class="btn-outline">Cancelar</a>
                        @if($client->exists)
                            <form method="POST" action="{{ route('clients.destroy', $client) }}" class="ml-auto"
                                  onsubmit="return confirm('Remover este cliente?')">
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
function formatarCEP(input) {
    let v = input.value.replace(/\D/g,'').slice(0,8);
    if (v.length > 5) v = v.slice(0,5) + '-' + v.slice(5);
    input.value = v;
}

function formatarDoc(input) {
    let v = input.value.replace(/\D/g,'');
    if (v.length <= 11) {
        // CPF
        v = v.replace(/(\d{3})(\d)/, '$1.$2')
             .replace(/(\d{3})(\d)/, '$1.$2')
             .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        // CNPJ
        v = v.slice(0,14)
             .replace(/(\d{2})(\d)/, '$1.$2')
             .replace(/(\d{3})(\d)/, '$1.$2')
             .replace(/(\d{3})(\d)/, '$1/$2')
             .replace(/(\d{4})(\d{1,2})$/, '$1-$2');
    }
    input.value = v;
}

async function buscarCEP(cep) {
    const nums = cep.replace(/\D/g,'');
    if (nums.length !== 8) return;
    try {
        const r = await fetch(`https://viacep.com.br/ws/${nums}/json/`);
        const d = await r.json();
        if (d.erro) return;
        document.getElementById('address').value = `${d.logradouro}, ${d.bairro}`;
        document.getElementById('city').value = d.localidade;
        document.getElementById('state').value = d.uf;
    } catch(e) {}
}

async function buscarCNPJ(doc) {
    const nums = doc.replace(/\D/g,'');
    if (nums.length !== 14) return;
    const loading = document.getElementById('doc-loading');
    loading.classList.remove('hidden');
    loading.style.animation = 'spin 1s linear infinite';
    try {
        const r = await fetch(`https://brasilapi.com.br/api/cnpj/v1/${nums}`);
        const d = await r.json();
        if (d.razao_social) {
            document.getElementById('name').value = d.razao_social;
            if (d.logradouro) {
                document.getElementById('address').value = `${d.logradouro}, ${d.numero} - ${d.bairro}`;
            }
            if (d.municipio) document.getElementById('city').value = d.municipio;
            if (d.uf) document.getElementById('state').value = d.uf;
            if (d.cep) document.getElementById('cep').value = d.cep.replace(/(\d{5})(\d{3})/, '$1-$2');
        }
    } catch(e) {}
    loading.classList.add('hidden');
}
</script>

<style>
@keyframes spin { from { transform: translateY(-50%) rotate(0deg); } to { transform: translateY(-50%) rotate(360deg); } }
</style>
</x-app-layout>
