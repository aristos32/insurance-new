<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function record(
        Sale $sale,
        string $details,
        float $debit = 0,
        float $credit = 0,
        ?string $producer = null,
        ?string $receiptNo = null,
        ?\DateTimeInterface $transDate = null,
    ): Transaction {
        return DB::transaction(function () use ($sale, $details, $debit, $credit, $producer, $receiptNo, $transDate) {
            $previous = (float) $sale->transactions()->orderByDesc('transId')->value('remainder');
            $remainder = round($previous + $debit - $credit, 2);

            return Transaction::create([
                'saleId' => $sale->saleId,
                'details' => $details,
                'debit' => $debit,
                'credit' => $credit,
                'remainder' => $remainder,
                'producer' => $producer,
                'receiptNo' => $receiptNo,
                'transDate' => $transDate ?? now(),
            ]);
        });
    }
}
