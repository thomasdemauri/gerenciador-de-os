<?php

namespace App\Http\Controllers;

use App\Filters\CustomerNameFilter;
use App\Filters\DataOsFilter;
use App\Models\Customer;
use App\Models\HandymanService;
use App\Models\ProductService;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceOrderController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $customers = Customer::where('user_id', $user->id)->get();
        return view('service-order.create', [
            'customers' => $customers
        ]);
    }

    public function update(Request $request, ServiceOrder $order)
    {

        $request->validate([
            'customer_id' => ['exists:customers,id']
        ]);

        $services = $request->input('services');
        $products = $request->input('products');

        // Obtem os ids antes de qualquer atualização para comparar
        // com os ids vindo da request. Se estiver faltando algum siginifica
        // que o usuário removeu algum que já existia.
        $allServicesIdsBeforeUpdate = $order->handymanServices->pluck('id')->toArray();

        $deletedServicesIds = [];
        if ($services) {
            $servicesIdsFromRequest = array_column($services, 'id');
            $deletedServicesIds = array_diff($allServicesIdsBeforeUpdate, $servicesIdsFromRequest);
        }

        $allProductsIdsBeforeUpdate = $order->products->pluck('id')->toArray();
        $deletedProductsIds = [];
        if ($products) {
            $productsIdsFromRequest = array_column($products, 'id');
            $deletedProductsIds = array_diff($allProductsIdsBeforeUpdate, $productsIdsFromRequest);
        }


        try {
            DB::beginTransaction();

            $order->update([
                'customer_id' => $request->customer_id,
                'vehicle' => $request->vehicle,
                'total_services' => $request->total_services,
                'total_products' => $request->total_products,
                'discount' => $request->discount,
                'total_so' => $request->total_so,
                'status' => $request->status,
                'data_os' => Carbon::parse($request->data_os)->format('Y-m-d'),
                'observation' => $request->observation
            ]);

            // Deleta serviços e produtos que já existiam
            if ($deletedServicesIds) {
                foreach ($deletedServicesIds as $deletedServiceId) {
                    HandymanService::where("id", $deletedServiceId)->delete();
                }
            }

            if ($deletedProductsIds) {
                foreach ($deletedProductsIds as $deletedProductId) {
                    ProductService::where("id", $deletedProductId)->delete();
                }
            }

            // Adiciona ou altera os serviços
            if ($services) {
                foreach ($services as $service) {

                    if (!array_key_exists('id', $service)) {

                        $order->handymanServices()->create([
                            'description' => $service['name'],
                            'quantity' => $service['quantity'],
                            'unit_price' => $service['unit_price'],
                            'total_price' => $service['total_price']
                        ]);

                    } else {

                        $handymanService = HandymanService::find($service['id']);
                        $handymanService->update([
                            'description' => $service['name'],
                            'quantity' => $service['quantity'],
                            'unit_price' => $service['unit_price'],
                            'total_price' => $service['total_price']
                        ]);

                    }
                }
            }

            // Adiciona ou altera os produtos
            if ($products) {
                foreach ($products as $product) {

                    if (!array_key_exists('id', $product)) {

                        $order->products()->create([
                            'description' => $product['description'],
                            'quantity' => $product['quantity'],
                            'unit_price' => $product['unit_price'],
                            'total_price' => $product['total_price']
                        ]);

                    } else {

                        $productService = ProductService::find($product['id']);
                        $productService->update([
                            'description' => $product['description'],
                            'quantity' => $product['quantity'],
                            'unit_price' => $product['unit_price'],
                            'total_price' => $product['total_price']
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Alterado com sucesso!');

        } catch (\Exception $e) {

            dd([
                'mensagem' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();

        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $orders = QueryBuilder::for(ServiceOrder::class)
            ->allowedFilters([
                AllowedFilter::custom('customer', new CustomerNameFilter),
                AllowedFilter::exact('status'),
                AllowedFilter::partial('vehicle'),
                AllowedFilter::custom('date', new DataOsFilter()),
            ])
            ->where('user_id', $user->id)
            ->with('customer')
            ->get();

        return view('service-order.index', compact('orders'));
    }

    public function delete(ServiceOrder $order)
    {
        $order->delete();

        return redirect()->route('service.index');
    }

    public function store(Request $request)
    {
//        dd($request);
        $request->validate([
            'customer_id' => ['exists:customers,id']
        ]);

        $services = $request->input('services');
        $products = $request->input('products');

        try {

            DB::beginTransaction();

            $order = ServiceOrder::create([
                'customer_id' => $request->customer_id,
                'user_id' => Auth::user()->id,
                'vehicle' => $request->vehicle,
                'total_services' => $request->total_services,
                'total_products' => $request->total_products,
                'discount' => $request->discount,
                'total_so' => $request->total_so,
                'status' => $request->status,
                'data_os' => Carbon::parse($request->data_os)->format('Y-m-d'),
                'observation' => $request->observation
            ]);

            foreach ($services as $service) {
                $order->handymanServices()->create([
                    'description' => $service['name'],
                    'quantity' => $service['quantity'],
                    'unit_price' => $service['unit_price'],
                    'total_price' => $service['total_price']
                ]);
            }

            if ($products) {
                foreach ($products as $product) {
                    $order->products()->create([
                        'description' => $product['description'],
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['unit_price'],
                        'total_price' => $product['total_price']
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('service.index');

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }

    }

    public function edit(ServiceOrder $order)
    {
        $order->load(['handymanServices', 'products', 'customer']);
        $user = Auth::user();
        $customers = Customer::where('user_id', $user->id)->get();

        $order->data_os = Carbon::parse($order->data_os)->format('Y-m-d');

        return view('service-order.edit', [
            'customers' => $customers,
            'order' => $order,
        ]);
    }

    public function downloadOrderReport(ServiceOrder $order)
    {
        $order->load(['handymanServices', 'products', 'customer']);

        return Pdf::view('report-pdf.order-report',[ 'order' => $order ])
            ->download('invoice-' . $order->id . '.pdf');

    }
}
