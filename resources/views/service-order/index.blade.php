<x-app-layout>

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
                        <td class="px-4 py-2 text-sm text-gray-800 border-b">
                            <a href="{{ route('service.download-order-report', ['order' => $order->id])  }}" class="mr-2 hover:underline text-yellow-500">
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
