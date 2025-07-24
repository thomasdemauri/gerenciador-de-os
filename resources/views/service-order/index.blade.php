<x-app-layout>

    <div class="p-4 m-4 bg-white ">
        <h3 class="font-bold">Filtros<span class="text-sm text-gray-500 ml-3">Você pode usar mais de um filtro por consulta</span></h3>
        <form action="{{route('service.index')}}" method="get">
            <div class="grid grid-cols-12 gap-5">

                {{-- Nome do cliente --}}
                <div class="col-span-3 mt-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Filtrar por nome ou apelido</label>
                    <input type="text" id="customer_name" name="filter[customer]" placeholder="João da Silva"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                           value="{{ request('filter.customer') }}"
                    >
                </div>

                {{-- Veiculo --}}
                <div class="col-span-2 mt-4">
                    <label for="vehicle" class="block text-sm font-medium text-gray-700">Filtrar por veículo</label>
                    <input type="text" id="vehicle" name="filter[vehicle]"  placeholder="ASH-9E14"
                           value="{{ request('filter.vehicle', '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>

                {{-- Data inicio --}}
                <div class="col-span-2 mt-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Data inicial</label>
                    <input type="text" id="start_date" name="filter[date][start_date]" placeholder="01/05/2025"
                           value="{{ request('filter.date.start_date', '')}}"  x-data x-mask="99/99/9999"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>
                {{-- Data fim --}}
                <div class="col-span-2 mt-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Data final</label>
                    <input type="text" id="end_date" name="filter[date][end_date]" placeholder="30/05/2025"
                           value="{{ request('filter.date.end_date', '')}}" x-data x-mask="99/99/9999"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                {{-- Situação da ordem de serviço --}}
                <div class="col-span-3 mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Situação da O.S</label>
                    <div class="flex flex-wrap gap-4 pt-2">
                        @foreach(\App\Http\Enums\ServiceOrderStatusEnum::values() as $status)
                            <label class="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    name="filter[status][]"
                                    value="{{ $status }}"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ in_array($status, request('filter.status', [])) ? 'checked' : '' }}
                                >
                                <span>{{ $status }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>
            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                Filtrar
            </button>
        </form>
    </div>

    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Nº O.S</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Data</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Cliente</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Veículo</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Valor</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="bg-white hover:bg-gray-200">
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$order->id}}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">{{\Carbon\Carbon::parse($order->data_os)->format('d/m/Y')}}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$order->customer->full_name}}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$order->vehicle}}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">R$ {{number_format($order->total_so, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $order->status  }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">
                            <a href="{{ route('service.download-order-report', ['order' => $order->id])  }}" class="mr-2 hover:underline text-gray-800-500">
                                Imprimir
                            </a>
                            <a href="{{ route('service.edit', ['order' => $order->id]) }}" class="mr-2 text-blue-600 hover:underline">
                                Editar
                            </a>

                            <form action="{{ route('service.delete', ['order' => $order->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
