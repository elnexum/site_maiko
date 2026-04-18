<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with('client')
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%")
                ->orWhereHas('client', fn($cq) => $cq->where('name', 'like', "%$s%")))
            ->orderByDesc('updated_at')
            ->paginate(20)
            ->withQueryString();

        return view('services.index', compact('services'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $selectedClient = $request->client_id ? Client::find($request->client_id) : null;
        return view('services.form', ['service' => new Service(), 'clients' => $clients, 'selectedClient' => $selectedClient]);
    }

    public function store(Request $request)
    {
        $isNovo = $request->filled('new_client_name');

        $data = $request->validate(array_merge([
            'client_id'      => $isNovo ? 'nullable' : 'required|exists:clients,id',
            'new_client_name'=> $isNovo ? 'required|string|max:255' : 'nullable',
            'new_client_phone'=> 'nullable|string|max:20',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'total_value'    => 'nullable|numeric|min:0',
            'labor_cost'     => 'nullable|numeric|min:0',
            'material_cost'  => 'nullable|numeric|min:0',
            'start_date'     => 'nullable|date',
            'delivery_date'  => 'nullable|date',
            'status'         => 'required|in:orcamento,aprovado,producao,finalizado,entregue',
        ]));

        if ($isNovo) {
            $client = Client::create([
                'name'  => $data['new_client_name'],
                'phone' => $data['new_client_phone'] ?? null,
                'notes' => 'Pré-cadastro criado via orçamento.',
            ]);
            $data['client_id'] = $client->id;
        }

        $data['labor_cost']    = $data['labor_cost'] ?? 0;
        $data['material_cost'] = $data['material_cost'] ?? 0;
        $data['total_value']   = $data['total_value'] ?? 0;

        $service = Service::create(\Illuminate\Support\Arr::only($data, [
            'client_id','title','description','internal_notes',
            'total_value','labor_cost','material_cost','start_date','delivery_date','status',
        ]));

        return redirect()->route('services.show', $service)->with('success', 'Orçamento criado com sucesso!');
    }

    public function show(Service $service)
    {
        $service->load(['client', 'payments']);
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $clients = Client::orderBy('name')->get();
        return view('services.form', compact('service', 'clients'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'client_id'      => 'required|exists:clients,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'total_value'    => 'required|numeric|min:0',
            'labor_cost'     => 'nullable|numeric|min:0',
            'material_cost'  => 'nullable|numeric|min:0',
            'start_date'     => 'nullable|date',
            'delivery_date'  => 'nullable|date',
            'status'         => 'required|in:orcamento,aprovado,producao,finalizado,entregue',
        ]);

        $data['labor_cost']    = $data['labor_cost'] ?? 0;
        $data['material_cost'] = $data['material_cost'] ?? 0;

        $service->update($data);

        return redirect()->route('services.show', $service)->with('success', 'Serviço atualizado!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Serviço removido.');
    }
}
