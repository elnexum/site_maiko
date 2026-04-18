<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReceivedMonth = Payment::whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $servicesInProgress = Service::whereIn('status', ['aprovado', 'producao'])->count();
        $servicesFinished   = Service::where('status', 'finalizado')->orWhere('status', 'entregue')->count();
        $totalClients       = Client::count();

        return view('dashboard', compact(
            'totalReceivedMonth',
            'servicesInProgress',
            'servicesFinished',
            'totalClients'
        ));
    }
}
