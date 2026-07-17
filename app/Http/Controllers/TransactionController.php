<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\HistoryService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactions,
        private HistoryService $history,
    ) {}

    public function index(Sale $sale): View
    {
        $sale->load(['owner', 'transactions']);

        return view('transactions.index', compact('sale'));
    }

    public function create(Sale $sale): View
    {
        return view('transactions.form', compact('sale'));
    }

    public function store(Request $request, Sale $sale): RedirectResponse
    {
        $data = $request->validate([
            'details' => ['required', 'string', 'max:30'],
            'debit' => ['nullable', 'numeric', 'min:0'],
            'credit' => ['nullable', 'numeric', 'min:0'],
            'producer' => ['nullable', 'string', 'max:20'],
            'receiptNo' => ['nullable', 'string', 'max:30'],
            'transDate' => ['nullable', 'date'],
        ]);

        $this->transactions->record(
            $sale,
            $data['details'],
            (float) ($data['debit'] ?? 0),
            (float) ($data['credit'] ?? 0),
            $data['producer'] ?? null,
            $data['receiptNo'] ?? null,
            isset($data['transDate']) ? new \DateTimeImmutable($data['transDate']) : null,
        );

        $this->history->log('CONTRACT', 'TRANSACTION', 'saleId', $sale->saleId, $data['details']);

        return redirect()->route('transactions.index', $sale)->with('success', 'Transaction recorded.');
    }
}
