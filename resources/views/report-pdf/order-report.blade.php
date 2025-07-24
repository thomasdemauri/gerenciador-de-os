<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Ordem de Serviço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
            padding: 2rem;
            margin: 0;
        }
        .header-grid {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }
        .logo-container {
            width: 100%;
            height: 6rem;
            border: 1px solid #999;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .logo-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        .company-info h1 {
            margin: 0 0 0.2rem 0;
            font-weight: bold;
            font-size: 1rem;
        }
        .company-info p {
            margin: 0.1rem 0;
            font-size: 0.85rem;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .customer-info {
            display: grid;
            grid-template-columns: repeat(4, auto);
            gap: 0.25rem 1.5rem; /* pouco espaço vertical, espaço maior só entre colunas */
            margin-bottom: 0.8rem; /* espaçamento menor abaixo do bloco */
            align-items: start;
        }

        .customer-info > div {
            line-height: 1.1;
        }

        .customer-info label {
            font-weight: bold;
            display: inline-block;
            margin-bottom: 0; /* elimina espaço extra abaixo do label */
            margin-right: 0.3rem; /* pequeno espaço entre label e valor */
        }

        .customer-info p {
            display: inline; /* inline pra não quebrar linha */
            margin: 0;
        }

        .customer-info .vehicle {
            grid-column: 1 / -1; /* faz o veículo ocupar a linha toda, abaixo dos outros */
            margin-top: 0.25rem;
        }

        h2 {
            font-weight: bold;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            margin-bottom: 0.3rem;
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0.5rem;
            font-size: 12px;
        }
        thead th {
            font-weight: bold;
            text-align: left;
            border-bottom: 1px solid #ccc;
            padding: 0.2rem 0.3rem;
        }
        tbody td {
            padding: 0.15rem 0.3rem; /* menos espaçamento vertical */
            vertical-align: top;
        }
        tbody td.text-right {
            text-align: left;
        }
        .totals {
            width: 300px;
            margin-left: auto;
            border-top: 1px solid #ccc;
            margin-top: 10px;
            padding-top: 0.5rem;
            font-size: 12px;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 0.15rem 0.3rem;
        }
        .totals td.label {
            font-weight: bold;
            text-align: right;
            padding-right: 1rem;
        }
        .totals tr.total-row td.label {
            font-size: 1.1rem;
        }
        .totals tr.total-row td.value {
            font-size: 1.1rem;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 40px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header-grid">
    <div class="logo-container">
        <img
            src="https://s3-sa-east-1.amazonaws.com/projetos-artes/fullsize%2F2021%2F04%2F30%2F16%2FLogo-275326_493335_163659722_1306160352.jpg"
            alt="Logo">
    </div>
    <div class="company-info">
        <h1>Thomas Mauro</h1>
        <p>Tom Lindinho LTDA</p>
        <p>CNPJ: 15.329.731/0001-52</p>
        <p>Contato: (16) 3342-9507 | contato@empresa.com</p>
    </div>
</div>

<div class="title">ORDEM DE SERVIÇO</div>

<div class="customer-info">
    <div>
        <label>Nome:</label>
        <p>{{ $order->customer->full_name }}</p>
    </div>
    <div>
        <label>Apelido:</label>
        <p>{{ $order->customer->nickname }}</p>
    </div>
    <div>
        <label>Data OS:</label>
        <p>{{ \Carbon\Carbon::parse($order->data_os)->format('d/m/Y') }}</p>
    </div>
    <div>
        <label>Número OS:</label>
        <p>{{ $order->id }}</p>
    </div>
    <div class="vehicle">
        <label>Veículo:</label>
        <p>{{ $order->vehicle }}</p>
    </div>
</div>

<h2>Serviços</h2>
<table>
    <thead>
    <tr>
        <th>Descrição</th>
        <th class="text-right">Quantidade</th>
        <th class="text-right">Valor unitário</th>
        <th class="text-right">Valor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->handymanServices as $service)
        <tr>
            <td>{{ $service->description }}</td>
            <td>{{ number_format($service->quantity, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($service->unit_price, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($service->total_price, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Produtos</h2>
<table>
    <thead>
    <tr>
        <th>Descrição</th>
        <th class="text-right">Qtde</th>
        <th class="text-right">Valor Unitário</th>
        <th class="text-right">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->products as $product)
        <tr>
            <td>{{ $product->description }}</td>
            <td>{{ $product->quantity }}</td>
            <td>R$ {{ number_format($product->unit_price, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($product->total_price, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="totals">
    <table>
        <tr>
            <td class="label">Total Serviços:</td>
            <td class="value">R$ {{ number_format($order->total_services, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total Produtos:</td>
            <td class="value">R$ {{ number_format($order->total_products, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Desconto:</td>
            <td class="value">R$ {{ number_format($order->discount, 2, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td class="label">Valor Total:</td>
            <td class="value">R$ {{ number_format($order->total_so, 2, ',', '.') }}</td>
        </tr>
    </table>
</div>

<div class="footer">
    Mauro Soluções &mdash; Todos os direitos reservados.
</div>

</body>
</html>
