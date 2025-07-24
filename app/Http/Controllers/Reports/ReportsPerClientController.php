<?php

namespace App\Http\Controllers\Reports;

use App\Filters\CustomerNameFilter;
use App\Filters\DataOsFilter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReportsPerClientController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', Auth::id())->get();

        return view('reports.report-per-client-index', compact('customers'));
    }

    public function generateReport(Request $request)
    {
        $baseQuery = QueryBuilder::for(ServiceOrder::class)
            ->allowedFilters([
                AllowedFilter::custom('customer', new CustomerNameFilter),
                AllowedFilter::exact('status'),
                AllowedFilter::partial('vehicle'),
                AllowedFilter::custom('date', new DataOsFilter()),
            ])
            ->where('user_id', Auth::user()->id);

        $sumQuery = clone $baseQuery;
        $ordersQuery = clone $baseQuery;

        $orders = $ordersQuery->with(['customer', 'handymanServices', 'products'])->get();
        $total = $sumQuery->sum('total_so');

//        $customer = $orders[0]->customer;   // Pega cliente a partir de um pedido ja carregado
        $customer = optional($orders->first())->customer;

        $start_date = data_get($request, 'filter.date.start_date', '');
        $end_date = data_get($request, 'filter.date.end_date', '');
        $vehicle = data_get($request, 'filter.vehicle', '');
        $status = data_get($request, 'filter.status', []);

        $start_date = $start_date ? Carbon::createFromFormat('d/m/Y', $start_date)->format('d/m/Y') : '';
        $end_date = $end_date ? Carbon::createFromFormat('d/m/Y', $end_date)->format('d/m/Y') : '';

//        dd($start_date, $end_date, $vehicle, $status, $orders, $customer);

        return Pdf::view('report-pdf.report-per-client',[
            'customer' => $customer,
            'orders' => $orders,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'vehicle' => $vehicle,
            'status' => $status,
            'total' => $total,
        ])->name('relatorio-' . $customer->full_name . '.pdf');

    }
}
