<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Ordem de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            padding: 0.5rem;
        }
    </style>
</head>
<body class="text-sm text-gray-900 p-8 font-sans">

<div class="grid grid-cols-12 mb-4 items-center">
    <div class="col-span-3">
        <div class="w-full h-24 border border-gray-400 overflow-hidden flex items-center"> <!-- Altura fixa de 6rem (h-24) -->
            <img
                src="https://s3-sa-east-1.amazonaws.com/projetos-artes/fullsize%2F2021%2F04%2F30%2F16%2FLogo-275326_493335_163659722_1306160352.jpg"
                class="w-full h-auto max-h-full object-contain"
             alt="" >
        </div>
    </div>

    <!-- Dados da Empresa -->
    <div class="col-span-9 pl-4">
        <h1 class="text-lg font-bold">Preto Motores</h1>
        <p class="text-sm">Preto Motores LTDA</p>
        <p class="text-sm">CNPJ: 15.329.731/0001-52</p>
        <p class="text-sm">Contato: (16) 3342-9507 | contato@empresa.com</p>
    </div>
</div>

<div class="text-center mb-3">
    <p class="font-bold">RELATÓRIO DE ORDENS DE SERVIÇO POR CLIENTE</p>
</div>

<!-- Informações do Cliente -->
<div>

    <div class="flex gap-4">
        <div>
            <label class="block font-semibold">Nome:</label>
            <p>{{ $customer->full_name }}</p>
        </div>
        <div>
            <label class="block font-semibold">Apelido:</label>
            <p>{{ $customer->nickname ?? ''}}</p>
        </div>

        <div>
            <label class="block font-semibold">Período inicial</label>
            <p>{{ $start_date ?? '' }}</p>
        </div>

        <div>
            <label class="block font-semibold">Período final</label>
            <p>{{ $end_date ?? '' }}</p>
        </div>

        <div>
            <label class="block font-semibold">Veículo:</label>
            <p>{{ $vehicle ?? '' }}</p>
        </div>

        <div>
            <label class="block font-semibold">Status:</label>
            <p>{{ $status ? implode(', ', (array) $status) : 'Todos' }}</p>
        </div>

</div>

<!-- Serviços -->
<h2 class="font-bold mt-4 mb-1 text-base border-b border-gray-300">Relação de O.S</h2>
<table class="w-full mb-1">
    <thead>
    <tr class="text-left">
        <th class="font-semibold text-right">Nº O.S</th>
        <th class="font-semibold">Data</th>
        <th class="font-semibold text-left">Veículo</th>
        <th class="font-semibold text-left">Status</th>
        <th class="font-semibold text-left">Valor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td class="text-right">{{ $order->id  }}</td>
            <td>{{ \Carbon\Carbon::parse($order->data_os)->format('d/m/Y') }}</td>
            <td class="text-left">{{ $order->vehicle }}</td>
            <td class="text-left">{{ $order->status }}</td>
            <td class="text-left">R$ {{ number_format( $order->total_so, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Totais -->
<div class="flex justify-end border-t">
    <table class="text-right">
        <tr>
            <td class="pr-4 font-semibold">Total:</td>
            <td>R$ {{ number_format($total, 2, ',', '.') }}</td>
        </tr>
    </table>
</div>
<div style="position: fixed; bottom: 20px; right: 40px; font-size: 12px; color: #666;">
    Mauro Soluções &mdash; Todos os direitos reservados.
</div>
</body>
</html>
