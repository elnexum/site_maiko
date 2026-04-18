<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Shopping Yokohama — Gestão</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center"
             style="background: linear-gradient(135deg, #0f1923 0%, #1a2d40 60%, #0f1923 100%);">

            <div class="mb-8 text-center">
                <a href="https://yokohama.elnexum.com.br">
                    <img src="https://yokohama.elnexum.com.br/logo.png" alt="Shopping Yokohama" class="h-20 mx-auto mb-3">
                </a>
                <h1 class="text-white text-xl font-bold tracking-wide">Shopping Yokohama</h1>
                <p class="text-gray-400 text-sm">Área do Gestor</p>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl">
                {{ $slot }}
            </div>

            <p class="mt-6 text-gray-600 text-xs">
                <a href="https://yokohama.elnexum.com.br" class="hover:text-gray-400">← Voltar ao site</a>
            </p>
        </div>
    </body>
</html>
