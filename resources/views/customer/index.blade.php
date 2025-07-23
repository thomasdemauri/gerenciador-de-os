<x-app-layout>
<div class="p-4">
    <div class="overflow-x-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('failed'))
            <div class="bg-red-100 border border-red-400 text-red-700-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('failed') }}</span>
            </div>
        @endif
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Nº Cliente</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Nome</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Apelido</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Telefone</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr class="bg-white hover:bg-gray-200">
                    <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$customer->id}}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$customer->full_name}}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$customer->nickname}}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 border-b">{{$customer->phone}}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 border-b">
                        <a href="#" class="mr-2 text-blue-600 hover:underline">
                            Editar
                        </a>
                        <form action="{{route('customer.delete', ['customer' => $customer->id])}}" method="POST" class="inline">
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
        <div class="my-5 px-10">
            {{ $customers->links() }}
        </div>
    </div>
</div>
</x-app-layout>
