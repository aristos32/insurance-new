<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function expiring(Request $request): View
    {
        $days = (int) $request->input('days', 30);

        $sales = Sale::query()
            ->with('owner')
            ->where('status', 'ACTIVE')
            ->whereBetween('endDate', [now(), now()->addDays($days)])
            ->orderBy('endDate')
            ->paginate(50)
            ->withQueryString();

        return view('reports.expiring', compact('sales', 'days'));
    }

    public function balances(): View
    {
        $balances = Transaction::query()
            ->select('saleId', DB::raw('MAX(transId) as last_trans_id'))
            ->groupBy('saleId')
            ->get();

        $lastIds = $balances->pluck('last_trans_id');

        $rows = Transaction::query()
            ->with('sale.owner')
            ->whereIn('transId', $lastIds)
            ->where('remainder', '!=', 0)
            ->orderByDesc('remainder')
            ->get();

        return view('reports.balances', compact('rows'));
    }

    public function production(Request $request): View
    {
        $from = $request->input('from', now()->startOfYear()->toDateString());
        $to = $request->input('to', now()->toDateString());

        $rows = Sale::query()
            ->select('company', 'insuranceType', DB::raw('COUNT(*) as total'))
            ->whereBetween('startDate', [$from, $to])
            ->groupBy('company', 'insuranceType')
            ->orderBy('company')
            ->get();

        return view('reports.production', compact('rows', 'from', 'to'));
    }
}
