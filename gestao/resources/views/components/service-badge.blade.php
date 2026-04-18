@php
$labels = [
    'orcamento'  => ['Orçamento',  'bg-gray-100 text-gray-700'],
    'aprovado'   => ['Aprovado',   'bg-blue-100 text-blue-700'],
    'producao'   => ['Produção',   'bg-yellow-100 text-yellow-700'],
    'finalizado' => ['Finalizado', 'bg-green-100 text-green-700'],
    'entregue'   => ['Entregue',   'bg-purple-100 text-purple-700'],
];
[$label, $class] = $labels[$status] ?? ['?', 'bg-gray-100 text-gray-500'];
@endphp
<span class="px-2 py-0.5 rounded text-xs font-medium {{ $class }}">{{ $label }}</span>
