<x-app-layout>
    {{-- Filtros de consulta --}}
    <div class="p-4 m-4 bg-white ">
        <h3 class="font-bold">Filtros<span class="text-sm text-gray-500 ml-3">Você pode usar mais de um filtro por consulta</span></h3>

        <form action="{{ route('reports.month.index') }}" method="get">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                {{-- Data inicio --}}
                <div class="col-span-2 mt-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Mês e ano</label>
                    <input type="text" id="date" name="filter[date]" placeholder="05/2025"
                           value="{{ request('filter.date', '') }}" x-data x-mask="99/9999"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>
            </div>
            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                Filtrar
            </button>
        </form>

        <form action="{{ route('reports.download-report-per-month') }}" method="get">
            @foreach(request()->query('filter', []) as $key => $value)
                @if(is_array($value))
                    @foreach($value as $subKey => $subValue)
                        <input type="hidden" name="filter[{{ $key }}][{{ $subKey }}]" value="{{ $subValue }}">
                    @endforeach
                @else
                    <input type="hidden" name="filter[{{ $key }}]" value="{{ $value }}">
                @endif
            @endforeach
            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-500">
                Gerar PDF
            </button>
        </form>
    </div>

    @if (!empty($context['orders']))
        <div class="ml-4 mr-4 p-4 flex gap-4 bg-white border-gray-200 rounded">
            <p><strong>Total OS: </strong>R$ {{ number_format($context['total'], 2, ',', '.') }}</p>
        </div>

        <div class="ml-4 mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Nº O.S</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Data</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Cliente</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($context['orders'] as $order)
                        <tr class="bg-white hover:bg-gray-200">
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $order->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ \Carbon\Carbon::parse($order->data_os)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $order->customer->full_name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">R$ {{ number_format($order->total_so, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-app-layout>
