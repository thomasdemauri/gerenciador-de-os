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

<!-- Cabeçalho da Empresa -->
<div class="grid grid-cols-12 mb-8">
    <!-- Logo -->
    <div class="col-span-2">
        <div class="w-40 h-240 border border-gray-400">
            <img src="https://s3-sa-east-1.amazonaws.com/projetos-artes/fullsize%2F2021%2F04%2F30%2F16%2FLogo-275326_493335_163659722_1306160352.jpg">
        </div>
    </div>

    <!-- Dados da Empresa -->
    <div class="col-span-10 pl-4">
        <h1 class="text-lg font-bold">Preto Motores</h1>
        <p class="text-sm">Preto Motores LTDA</p>
        <p class="text-sm">CNPJ: 15.329.731/0001-52</p>
        <p class="text-sm">Contato: (16) 3342-9507 | contato@empresa.com</p>
    </div>
</div>

<!-- Informações do Cliente -->
<div class="grid grid-cols-4 gap-4 mb-4">
    <div>
        <label class="block font-semibold">Nome:</label>
        <p>{{ $order->customer->full_name }}</p>
    </div>
    <div>
        <label class="block font-semibold">Apelido:</label>
        <p>{{ $order->customer->nickname }}</p>
    </div>
    <div>
        <label class="block font-semibold">Data OS:</label>
        <p>{{ \Carbon\Carbon::parse($order->data_os)->format('d/m/Y') }}</p>
    </div>
    <div>
        <label class="block font-semibold">Código OS:</label>
        <p>{{ $order->id }}</p>
    </div>
    <div class="col-span-3">
        <label class="block font-semibold">Veículo:</label>
        <p>{{ $order->vehicle }}</p>
    </div>
</div>

<!-- Serviços -->
<h2 class="font-bold mt-4 mb-1 text-base border-b border-gray-300">Serviços</h2>
<table class="w-full mb-1">
    <thead>
    <tr class="text-left">
        <th class="font-semibold">Descrição</th>
        <th class="font-semibold text-right">Valor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->handymanServices as $service)
        <tr>
            <td>{{ $service->description }}</td>
            <td class="text-right">R$ {{ number_format($service->price, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Produtos -->
<h2 class="font-bold mt-4 mb-1 text-base border-b border-gray-300">Produtos</h2>
<table class="w-full mb-4">
    <thead>
    <tr class="text-left">
        <th class="font-semibold">Descrição</th>
        <th class="font-semibold text-right">Qtde</th>
        <th class="font-semibold text-right">Valor Unitário</th>
        <th class="font-semibold text-right">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->products as $product)
        <tr>
            <td>{{ $product->description }}</td>
            <td class="text-right">{{ $product->quantity }}</td>
            <td class="text-right">R$ {{ number_format($product->unit_price, 2, ',', '.') }}</td>
            <td class="text-right">R$ {{ number_format($product->total_price, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Totais -->
<div class="flex justify-end border-t">
    <table class="text-right">
        <tr>
            <td class="pr-4 font-semibold">Total Serviços:</td>
            <td>R$ {{ number_format($order->total_services, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="pr-4 font-semibold">Total Produtos:</td>
            <td>R$ {{ number_format($order->total_products, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="pr-4 font-semibold">Desconto:</td>
            <td>R$ {{ number_format($order->discount, 2, ',', '.') }}</td>
        </tr>
        <tr class="text-lg font-bold">
            <td class="pr-4">Valor Total:</td>
            <td>R$ {{ number_format($order->total_so, 2, ',', '.') }}</td>
        </tr>
    </table>
</div>
<div style="position: fixed; bottom: 20px; right: 40px; font-size: 12px; color: #666;">
    Mauro Soluções &mdash; Todos os direitos reservados.
</div>
</body>
</html>
