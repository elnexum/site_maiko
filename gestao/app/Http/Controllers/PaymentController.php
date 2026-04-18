<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('service.client')
            ->orderByDesc('paid_at')
            ->paginate(30);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return redirect()->route('services.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'amount'     => 'required|numeric|min:0.01',
            'paid_at'    => 'required|date',
            'method'     => 'required|in:pix,dinheiro,cartao',
        ]);

        Payment::create($data);

        return redirect()->route('services.show', $data['service_id'])->with('success', 'Pagamento registrado!');
    }

    public function show(Payment $payment)
    {
        return redirect()->route('services.show', $payment->service_id);
    }

    public function edit(Payment $payment)
    {
        return redirect()->route('services.show', $payment->service_id);
    }

    public function update(Request $request, Payment $payment)
    {
        return redirect()->route('services.show', $payment->service_id);
    }

    public function destroy(Payment $payment)
    {
        $serviceId = $payment->service_id;
        $payment->delete();
        return redirect()->route('services.show', $serviceId)->with('success', 'Pagamento removido.');
    }
}
