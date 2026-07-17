<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Owner;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $expiring = Sale::query()
            ->with('owner')
            ->where('status', 'ACTIVE')
            ->whereBetween('endDate', [now(), now()->addDays(30)])
            ->orderBy('endDate')
            ->limit(10)
            ->get();

        return view('dashboard.index', [
            'ownerCount' => Owner::query()->where('type', 'account')->count(),
            'leadCount' => Owner::query()->where('type', 'lead')->count(),
            'saleCount' => Sale::query()->count(),
            'claimCount' => Claim::query()->count(),
            'transactionCount' => Transaction::query()->count(),
            'expiring' => $expiring,
        ]);
    }
}
