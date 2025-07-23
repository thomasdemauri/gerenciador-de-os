<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastro de Cliente
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="{{route('customer.store')}}" method="post">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <div class="col-span-4">
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Digite o nome completo do cliente"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>
                <div class="col-span-4">
                    <label for="nickname" class="block text-sm font-medium text-gray-700">Apelido</label>
                    <input type="text" id="nickname" name="nickname" placeholder="Digite o apelido do cliente"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>
                <div class="col-span-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                    <input type="text" id="phone" name="phone" placeholder="Digite o telefone do cliente"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-500">
                    Salvar alteração
                </button>
            </div>

        </form>
    </div>

</x-app-layout>
