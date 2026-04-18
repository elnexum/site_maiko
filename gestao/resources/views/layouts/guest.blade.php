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
            body { font-family: 'Montserrat', sans-serif; }
        </style>
    </head>
    <body style="background: linear-gradient(180deg, #0f1f38 0%, #0b1a30 100%); min-height: 100vh;">
        <div class="min-h-screen flex flex-col items-center justify-center px-4">

            <div class="mb-8 text-center">
                <a href="https://yokohama.elnexum.com.br">
                    <img src="https://yokohama.elnexum.com.br/logo.png" alt="Shopping Yokohama" class="h-16 mx-auto mb-4" style="filter: drop-shadow(0 0 12px rgba(224,204,112,0.3));">
                </a>
                <h1 class="font-bold text-lg tracking-widest uppercase" style="color:#e0cc70;">Shopping Yokohama</h1>
                <p class="text-xs mt-1 tracking-wider uppercase" style="color:#8899aa;">Área do Gestor</p>
            </div>

            <div class="w-full sm:max-w-md rounded-2xl overflow-hidden"
                 style="background:rgba(255,255,255,0.04); border:1px solid rgba(224,204,112,0.15); backdrop-filter:blur(12px);">
                <div class="px-8 py-8">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-6 text-xs" style="color:#4a5568;">
                <a href="https://yokohama.elnexum.com.br" class="hover:underline" style="color:#8899aa;">← Voltar ao site</a>
            </p>
        </div>
    </body>
</html>
