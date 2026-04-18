<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Como usar o sistema</h2>
    </x-slot>

    <div class="py-8 max-w-3xl space-y-6">

        @php
        $steps = [
            [
                'num' => '1',
                'title' => 'Cadastrar um Cliente',
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                'steps' => [
                    'Clique em <strong>Clientes</strong> no menu do topo.',
                    'Clique no botão <strong>+ Novo Cliente</strong>.',
                    'Preencha o nome. Os outros campos são opcionais.',
                    '<strong>Dica CEP:</strong> digite o CEP e saia do campo — o endereço, cidade e estado preenchem sozinhos.',
                    '<strong>Dica CNPJ:</strong> se for empresa, digite o CNPJ — o nome e endereço da empresa aparecem automaticamente.',
                    'Clique em <strong>Cadastrar</strong>.',
                ],
            ],
            [
                'num' => '2',
                'title' => 'Criar um Serviço / Orçamento',
                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                'steps' => [
                    'Clique em <strong>Serviços</strong> no menu.',
                    'Clique em <strong>+ Novo Serviço</strong>.',
                    'Escolha o <strong>cliente</strong> na lista (precisa estar cadastrado primeiro).',
                    'Preencha o título do serviço, ex: <em>"Montagem Guarda-Roupa"</em>.',
                    'Coloque o <strong>valor total</strong> cobrado do cliente.',
                    'Defina o <strong>status</strong>: Orçamento → Aprovado → Produção → Finalizado → Entregue.',
                    'Salve. O serviço aparece no Painel e na lista.',
                ],
            ],
            [
                'num' => '3',
                'title' => 'Registrar um Pagamento',
                'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                'steps' => [
                    'Abra o serviço clicando no nome dele na lista.',
                    'Na página do serviço, role até <strong>Pagamentos</strong>.',
                    'Digite o valor recebido e a forma de pagamento.',
                    'Clique em <strong>Adicionar Pagamento</strong>.',
                    'O sistema mostra quanto já foi pago e quanto falta em vermelho/verde.',
                ],
            ],
            [
                'num' => '4',
                'title' => 'Acompanhar o Painel',
                'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                'steps' => [
                    'Clique em <strong>Painel</strong> no menu.',
                    'Veja o resumo: total recebido no mês, serviços em aberto, próximas entregas.',
                    'Os serviços mais recentes aparecem na lista do painel.',
                ],
            ],
            [
                'num' => '5',
                'title' => 'Alterar Status de um Serviço',
                'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                'steps' => [
                    'Abra o serviço.',
                    'Clique em <strong>Editar</strong>.',
                    'Mude o campo <strong>Status</strong> para o estágio atual.',
                    'Salve.',
                    '<strong>Fluxo sugerido:</strong> Orçamento → Aprovado → Produção → Finalizado → Entregue.',
                ],
            ],
        ];
        @endphp

        @foreach($steps as $s)
        <div class="card p-6">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm"
                     style="background:rgba(224,204,112,0.12); color:#e0cc70; border:1px solid rgba(224,204,112,0.3);">
                    {{ $s['num'] }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#e0cc70" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}" />
                        </svg>
                        <h3 class="font-bold text-sm uppercase tracking-wider" style="color:#e0cc70;">{{ $s['title'] }}</h3>
                    </div>
                    <ol class="space-y-2">
                        @foreach($s['steps'] as $i => $step)
                        <li class="flex gap-2 text-sm" style="color:#cbd5e1;">
                            <span class="shrink-0 font-semibold" style="color:#e0cc70;">{{ $i + 1 }}.</span>
                            <span>{!! $step !!}</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        @endforeach

        <div class="card p-6" style="border:1px solid rgba(224,204,112,0.2);">
            <p class="text-sm font-semibold mb-1" style="color:#e0cc70;">Dúvidas?</p>
            <p class="text-sm" style="color:#8899aa;">Entre em contato com o suporte pelo WhatsApp do administrador do sistema.</p>
        </div>

    </div>
</x-app-layout>
