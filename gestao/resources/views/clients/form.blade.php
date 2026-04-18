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
                            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="inp">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="lbl">Telefone / WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="inp">
                            </div>
                            <div>
                                <label class="lbl">CPF / CNPJ</label>
                                <input type="text" name="document" value="{{ old('document', $client->document) }}" class="inp">
                            </div>
                        </div>
                        <div>
                            <label class="lbl">Email</label>
                            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="inp">
                        </div>
                        <div>
                            <label class="lbl">Endereço</label>
                            <input type="text" name="address" value="{{ old('address', $client->address) }}" class="inp">
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
</x-app-layout>
