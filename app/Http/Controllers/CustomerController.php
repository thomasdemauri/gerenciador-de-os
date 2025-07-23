<?php

namespace App\Http\Controllers;

use Cassandra\Custom;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', Auth::user()->id)->paginate(20);

        return view('customer.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'nickname' => 'required',
            'phone' => 'nullable',
        ]);

        $customer = Customer::create([
            'full_name' => $request->full_name,
            'user_id' => Auth::user()->id,
            'nickname' => $request->nickname,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customer.index');
    }

    public function create()
    {
        return view('customer.create');
    }

    public function delete(Customer $customer)
    {

        // Cliente não possui ordens de serviço
        if (!$customer->orderServices) {
            $customer->delete();
            return redirect()->route('customer.index')->with('success', 'Cliente excluído com sucesso!');
        }

        return redirect()->route('customer.index')->with('failed', 'Falha ao excluir! Cliente possui ordens de serviço.');

    }

    public function update()
    {
        // TODO
    }

    public function edit()
    {
        // TODO
    }
}
