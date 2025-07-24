<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            </div>
            <a href="{{route('service.index')}}" class="text-sm text-gray-400">Voltar</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex ml-4">
                Manutenção Ordem de Serviço
            </h2>
        <div/>
    </x-slot>

    <div class="p-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <form id="os-form" action="{{ route('service.update', ['order' => $order->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <x-basic-info-order :customers="$customers" :order="$order"/>

            <!-- Serviços -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800">Serviços</h3>
                <div class="flex space-x-2 mb-2">
                    <input type="text" id="new-service-name" placeholder="Serviço" class="flex-1 border-gray-300 rounded-md shadow-sm px-2 py-1">
                    <input type="number" id="new-service-value" placeholder="Valor" step="0.01" class="w-32 border-gray-300 rounded-md shadow-sm px-2 py-1">
                    <button type="button" id="btn-add-service" class="bg-green-500 text-white px-4 py-1 rounded">Adicionar</button>
                </div>
                <table id="services-table" class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-200 text-left text-sm text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-b">Serviço</th>
                        <th class="px-4 py-2 border-b">Valor</th>
                        <th class="px-4 py-2 border-b w-24">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($order->handymanServices as $index => $service)
                            <tr class="bg-white border-b">
                                <td>
                                    <input type="hidden" name="services[{{$index}}][id]" value="{{$service->id}}">
                                    <input type="text" name="services[{{$index}}][name]" value="{{$service->description}}"
                                           class="w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
                                    >
                                </td>
                                <td>
                                    <input type="number" name="services[{{$index}}][price]" value="{{$service->price}}"
                                           class="service-price-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
                                    >
                                </td>
                                <td class="flex">
                                    <button type="button" class="btn-remove-row ml-2 text-red-500">Excluir</button>
                                    <button type="button" class="btn-edit-product-row ml-2 mr-2 text-blue-500">Alterar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Produtos -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800">Produtos</h3>
                <div class="flex space-x-2 mb-2">
                    <input type="text" id="new-product-name" placeholder="Descrição" class="flex-1 border-gray-300 rounded-md shadow-sm px-2 py-1">
                    <input type="number" id="new-product-qty" placeholder="Qtd" step="1" class="w-24 border-gray-300 rounded-md shadow-sm px-2 py-1">
                    <input type="number" id="new-product-price" placeholder="Valor Unit." step="0.01" class="w-32 border-gray-300 rounded-md shadow-sm px-2 py-1">
                    <input type="number" id="new-product-total-price" placeholder="Valor Total" step="0.01" class="w-32 border-gray-300 rounded-md shadow-sm px-2 py-1" readonly>
                    <button type="button" id="btn-add-product" class="bg-green-500 text-white px-4 py-1 rounded">Adicionar</button>
                </div>
                <table id="products-table" class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-200 text-left text-sm text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-b">Descrição</th>
                        <th class="px-4 py-2 border-b">Qtd</th>
                        <th class="px-4 py-2 border-b">Valor Unit.</th>
                        <th class="px-4 py-2 border-b">Total</th>
                        <th class="px-4 py-2 border-b w-24">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $index => $product)
                            <tr class="bg-white border-b">
                                <td>
                                    <input type="hidden" name="products[{{ $index }}][id]" value="{{$product->id}}">
                                    <input type="text" name="products[{{ $index }}][description]" value="{{$product->description}}"
                                           class="w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
                                    >
                                </td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][quantity]" value="{{$product->quantity}}"
                                           class="w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
                                    >
                                </td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][unit_price]" value="{{$product->unit_price}}"
                                           class="w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
                                    >
                                </td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][total_price]" value="{{$product->total_price}}"
                                           class="product-total-price-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
                                    >
                                </td>
                                <td class="flex">
                                    <button type="button" class="btn-remove-row ml-2 text-red-500">Excluir</button>
                                    <button type="button" class="btn-edit-product-row ml-2 mr-2 text-blue-500">Alterar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Observações -->
            <div>
                <label for="observations" class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea id="observations" name="observation" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{$order->observation}}</textarea>
            </div>

            <!-- Resumo -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="total-services" class="block text-sm font-medium text-gray-700">Valor Serviços</label>
                    <input type="number" id="total-services" name="total_services" readonly value="{{$order->total_services}}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="total-products" class="block text-sm font-medium text-gray-700">Valor Produtos</label>
                    <input type="number" id="total-products" name="total_products" readonly value="{{$order->total_products}}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="discount" class="block text-sm font-medium text-gray-700">Desconto</label>
                    <input type="number" id="discount" name="discount" step="0.01" value="{{$order->discount}}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="total-os" class="block text-sm font-medium text-gray-700">Total O.S</label>
                    <input type="number" id="total-os" name="total_so" readonly value="{{$order->total_so}}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-white hover:bg-amber-700">
                    Salvar alteração
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            // Tem que fazer isso pra poder transefir o numero de linhas existentes vindo do php
            // para o javascript comecar com o index certo caso seja adicionado alguma linha a mais
            // dinamicamente
            window.productIndex = @json(count($order->products));
            window.serviceIndex = @json(count($order->handymanServices));
        </script>
    @endpush
    @push('scripts')
        <x-scripts.handle-dynamic-tables />
    @endpush
</x-app-layout>
