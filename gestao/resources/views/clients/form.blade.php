<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('clients.index') }}" class="text-gray-400 hover:text-gray-700">Clientes</a>
            <span class="text-gray-400">/</span>
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $client->exists ? 'Editar Cliente' : 'Novo Cliente' }}
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
                      action="{{ $client->exists ? route('clients.update', $client) : route('clients.store') }}">
                    @csrf
                    @if($client->exists) @method('PUT') @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                            <input type="text" name="name" value="{{ old('name', $client->name) }}" required
                                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone / WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CPF / CNPJ</label>
                                <input type="text" name="document" value="{{ old('document', $client->document) }}"
                                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $client->email) }}"
                                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                            <input type="text" name="address" value="{{ old('address', $client->address) }}"
                                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                            <textarea name="notes" rows="3"
                                      class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">{{ old('notes', $client->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 text-sm font-medium">
                            {{ $client->exists ? 'Salvar' : 'Cadastrar' }}
                        </button>
                        <a href="{{ $client->exists ? route('clients.show', $client) : route('clients.index') }}"
                           class="px-4 py-2 text-sm text-gray-600 hover:underline">Cancelar</a>

                        @if($client->exists)
                            <form method="POST" action="{{ route('clients.destroy', $client) }}" class="ml-auto"
                                  onsubmit="return confirm('Remover este cliente? Os serviços também serão excluídos.')">
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
