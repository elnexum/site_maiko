<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%")->orWhere('phone', 'like', "%$s%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.form', ['client' => new Client()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:30',
            'email'    => 'nullable|email|max:255',
            'document' => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:500',
            'notes'    => 'nullable|string',
        ]);

        $client = Client::create($data);

        return redirect()->route('clients.show', $client)->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Client $client)
    {
        $client->load(['services.payments']);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.form', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:30',
            'email'    => 'nullable|email|max:255',
            'document' => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:500',
            'notes'    => 'nullable|string',
        ]);

        $client->update($data);

        return redirect()->route('clients.show', $client)->with('success', 'Cliente atualizado!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente removido.');
    }
}
