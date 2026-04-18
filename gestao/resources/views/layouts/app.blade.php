<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Shopping Yokohama — Gestão</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * { font-family: 'Montserrat', sans-serif; }
            body { background: #07111f; color: #cbd5e1; }
            .card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; }
            .card-gold { border-color: rgba(224,204,112,0.2); }
            .btn-gold { background: linear-gradient(90deg,#c9a227,#e0cc70); color: #0b1a30; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase; padding: 0.6rem 1.2rem; border-radius: 8px; transition: opacity 0.2s; }
            .btn-gold:hover { opacity: 0.85; }
            .btn-outline { border: 1px solid rgba(255,255,255,0.12); color: #94a3b8; font-size: 0.75rem; letter-spacing: 0.05em; padding: 0.6rem 1.2rem; border-radius: 8px; transition: all 0.2s; }
            .btn-outline:hover { border-color: #e0cc70; color: #e0cc70; }
            .btn-danger { border: 1px solid rgba(239,68,68,0.3); color: #f87171; font-size: 0.75rem; padding: 0.6rem 1.2rem; border-radius: 8px; }
            .inp { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0; border-radius: 8px; padding: 0.65rem 1rem; font-size: 0.85rem; width: 100%; outline: none; transition: border-color 0.2s; }
            .inp:focus { border-color: #e0cc70; }
            .inp::placeholder { color: #475569; }
            label.lbl { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; display: block; margin-bottom: 0.4rem; }
            .badge-orcamento { background: rgba(100,116,139,0.2); color: #94a3b8; }
            .badge-aprovado   { background: rgba(59,130,246,0.2); color: #93c5fd; }
            .badge-producao   { background: rgba(234,179,8,0.2);  color: #fde047; }
            .badge-finalizado { background: rgba(34,197,94,0.2);  color: #86efac; }
            .badge-entregue   { background: rgba(168,85,247,0.2); color: #d8b4fe; }
            .badge { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; padding: 0.2rem 0.7rem; border-radius: 999px; }
            th { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #475569; padding: 0.75rem 1rem; }
            td { font-size: 0.82rem; color: #cbd5e1; padding: 0.85rem 1rem; border-top: 1px solid rgba(255,255,255,0.04); }
            tr:hover td { background: rgba(255,255,255,0.02); }
            .page-title { font-size: 1rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #e0cc70; }
            select.inp option { background: #0f1f38; }
        </style>
    </head>
    <body>
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <div style="border-bottom: 1px solid rgba(224,204,112,0.1); background: rgba(0,0,0,0.2);">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
