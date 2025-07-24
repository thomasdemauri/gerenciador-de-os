@props([
    'order' => null,
    'customers' => [],
])

<div class="grid grid-cols-1 md:grid-cols-12 gap-2">

    <div class="col-span-1">
        <label for="id" class="block text-sm font-medium text-gray-700">Código</label>
        <input type="text" id="id" name="id" value="{{ $order ? $order->id : '' }}" readonly
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
    </div>

    <div class="col-span-4">
        <label for="customer" class="block text-sm font-medium text-gray-700">Cliente</label>
        <select id="customer" name="customer_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Selecione um cliente</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}"
                        @if($order && $order->customer_id == $customer->id) selected @endif
                >
                    {{ $customer->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-span-1">
        <label for="created_at" class="block text-sm font-medium text-gray-700">Data</label>
        <input type="date" id="created_at" name="data_os"
               value="{{ $order ? $order->data_os : \Carbon\Carbon::now()->format('Y-m-d') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
    </div>

    <div class="col-span-2">
        <label for="vehicle" class="block text-sm font-medium text-gray-700">Veículo</label>
        <input type="text" id="vehicle" name="vehicle"
               value="{{ $order ? $order->vehicle : '' }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
    </div>

    <div class="col-span-2">
        <label for="status" class="block text-sm font-medium text-gray-700">Status da O.S</label>
        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach(\App\Http\Enums\ServiceOrderStatusEnum::values() as $status)
                <option value="{{$status}}" {{ $order && $order->status == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

</div>
