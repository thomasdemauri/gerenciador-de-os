<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nova Ordem de Serviço
        </h2>
    </x-slot>

    <div class="p-6">
        <form id="os-form" action="{{ route('service.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-basic-info-order :customers="$customers"/>

            <!-- Serviços -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800">Serviços<span class="ml-2 text-sm text-slate-400 xg:hidden">Digite o serviço e o valor e então clique em adicionar</span></h3>
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
                    <tbody  ></tbody>
                </table>
            </div>

            <!-- Produtos -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800">Produtos<span class="ml-2 text-sm text-slate-400 xg:hidden">Digite o produto, quantidade e o valor unitário e então clique em adicionar</span></h3>
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
                    <tbody></tbody>
                </table>
            </div>

            <!-- Observações -->
            <div>
                <label for="observations" class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea id="observations" name="observation" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

            <!-- Resumo -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="total-services" class="block text-sm font-medium text-gray-700">Valor Serviços</label>
                    <input type="number" id="total-services" name="total_services" readonly value="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="total-products" class="block text-sm font-medium text-gray-700">Valor Produtos</label>
                    <input type="number" id="total-products" name="total_products" readonly value="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="discount" class="block text-sm font-medium text-gray-700">Desconto</label>
                    <input type="number" id="discount" name="discount" step="0.01" value="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="total-os" class="block text-sm font-medium text-gray-700">Total O.S</label>
                    <input type="number" id="total-os" name="total_so" readonly value="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                    Salvar O.S
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <x-scripts.handle-dynamic-tables />
    @endpush
</x-app-layout>
