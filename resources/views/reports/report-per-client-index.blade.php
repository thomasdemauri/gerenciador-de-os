<x-app-layout>
    {{-- Filtros de consulta --}}
    <div class="p-4 m-4 bg-white ">
        <h3 class="font-bold">Filtros<span class="text-sm text-gray-500 ml-3">Você pode usar mais de um filtro por consulta</span></h3>
        <form action="{{ route('reports.download-report-per-client' )}}" method="get">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">

                {{-- Nome do cliente --}}
                <div class="col-span-3 mt-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Filtrar por nome ou apelido</label>
                    <select name="filter[customer]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach($customers as $customer)
                            <option value="{{ $customer->full_name }}"
                                    {{ $customer->full_name == request('filter.customer', []) ? 'selected' : '' }}
                            >
                                {{ $customer->full_name }} | {{  $customer->nickname }}
                            </option>
                        @endforeach
                    </select>
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
</x-app-layout>
