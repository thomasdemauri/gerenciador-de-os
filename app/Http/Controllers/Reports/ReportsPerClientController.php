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
    private array $context = [];

    public function index(Request $request)
    {

        $customers = Customer::where('user_id', Auth::id())->get();

        $filter = $request->has('filter.customer');

        if ($filter) {

            $baseQuery = QueryBuilder::for(ServiceOrder::class)
                ->allowedFilters([
                    AllowedFilter::custom('customer', new CustomerNameFilter)->ignore('no_filter'),
                    AllowedFilter::exact('status'),
                    AllowedFilter::partial('vehicle'),
                    AllowedFilter::custom('date', new DataOsFilter()),
                ])
                ->where('user_id', Auth::user()->id);

            $sumQuery = clone $baseQuery;
            $ordersQuery = clone $baseQuery;

            $orders = $ordersQuery->with(['customer', 'handymanServices', 'products'])->get();
            $total = $sumQuery->sum('total_so');

            $customer = optional($orders->first())->customer;

            $start_date = data_get($request, 'filter.date.start_date', '');
            $end_date = data_get($request, 'filter.date.end_date', '');
            $vehicle = data_get($request, 'filter.vehicle', '');
            $status = data_get($request, 'filter.status', []);

            $start_date = $start_date ? Carbon::createFromFormat('d/m/Y', $start_date)->format('d/m/Y') : '';
            $end_date = $end_date ? Carbon::createFromFormat('d/m/Y', $end_date)->format('d/m/Y') : '';

            $this->context = [
                'orders' => $orders,
                'total' => $total,
                'customer' => $customer,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'vehicle' => $vehicle,
                'status' => $status,
            ];

        }

        return view('reports.report-per-client-index', [
            'customers' => $customers,
            'context' => $this->context,
        ]);
    }

    public function generateReport(Request $request)
    {
        $baseQuery = QueryBuilder::for(ServiceOrder::class)
            ->allowedFilters([
                AllowedFilter::custom('customer', new CustomerNameFilter)->ignore('no_filter'),
                AllowedFilter::exact('status'),
                AllowedFilter::partial('vehicle'),
                AllowedFilter::custom('date', new DataOsFilter()),
            ])
            ->where('user_id', Auth::user()->id);

        $sumQuery = clone $baseQuery;
        $ordersQuery = clone $baseQuery;

        $orders = $ordersQuery->with(['customer', 'handymanServices', 'products'])->get();
        $total = $sumQuery->sum('total_so');

        $customer = optional($orders->first())->customer;

        $start_date = data_get($request, 'filter.date.start_date', '');
        $end_date = data_get($request, 'filter.date.end_date', '');
        $vehicle = data_get($request, 'filter.vehicle', '');
        $status = data_get($request, 'filter.status', []);

        $start_date = $start_date ? Carbon::createFromFormat('d/m/Y', $start_date)->format('d/m/Y') : '';
        $end_date = $end_date ? Carbon::createFromFormat('d/m/Y', $end_date)->format('d/m/Y') : '';

        return Pdf::view('report-pdf.report-per-client',[
            'customer' => $customer,
            'orders' => $orders,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'vehicle' => $vehicle,
            'status' => $status,
            'total' => $total
        ])->name('relatorio-' . $customer->full_name . '.pdf');

    }

    public function configureReportPerMonth(Request $request)
    {
        $customers = Customer::all();
        $orders = [];
        $total = 0;

        $date = data_get($request, 'filter.date', '');

        if (is_string($date) && str_contains($date, '/')) {
            [$month, $year] = explode('/', $date);

            $query = ServiceOrder::with(['customer', 'handymanServices', 'products'])
                ->whereMonth('data_os', $month)
                ->whereYear('data_os', $year)
                ->where('user_id', Auth::id());

            $orders = $query->get();
            $total = $query->sum('total_so');
        }

        return view('reports.report-per-month-index', [
            'customers' => $customers,
            'context' => [
                'orders' => $orders,
                'total' => $total
            ]
        ]);
    }

    public function downloadReportPerMonth(Request $request)
    {
        $date = data_get($request, 'filter.date', '');

        $orders = [];
        $total = 0;
        $month = $year = null;

        if (is_string($date) && str_contains($date, '/')) {
            [$month, $year] = explode('/', $date);

            $query = ServiceOrder::with(['customer', 'handymanServices', 'products'])
                ->whereMonth('data_os', $month)
                ->whereYear('data_os', $year)
                ->where('user_id', Auth::id());

            $orders = $query->get();
            $total = $query->sum('total_so');
        }

        return Pdf::view('report-pdf.report-per-month', [
            'month' => $month,
            'year' => $year,
            'orders' => $orders,
            'total' => $total
        ])->name('relatorio-' . $month . '-' . $year . '.pdf');
    }
}
