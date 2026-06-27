<?php

namespace App\Service;

use App\Entity\Crm\History;
use App\Entity\Crm\Sale;
use App\Entity\Crm\Transaction;
use App\Enum\HistoryType;
use App\Enum\TransactionDetail;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class TransactionService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TransactionRepository $transactionRepository,
        private readonly HistoryService $historyService,
        private readonly Security $security,
    ) {
    }

    public function addTransaction(
        Sale $sale,
        TransactionDetail $detail,
        ?float $debit,
        ?float $credit,
        ?string $receiptNo = null,
        ?string $producer = null,
    ): Transaction {
        $previous = $this->transactionRepository->findOneBy(['sale' => $sale], ['transId' => 'DESC']);
        $previousBalance = $previous ? (float) $previous->getRemainder() : 0.0;
        $remainder = $previousBalance + ($debit ?? 0.0) - ($credit ?? 0.0);

        $transaction = (new Transaction())
            ->setSale($sale)
            ->setDetails($detail)
            ->setDebit($debit)
            ->setCredit($credit)
            ->setRemainder($remainder)
            ->setReceiptNo($receiptNo)
            ->setProducer($producer ?? $this->currentUsername())
            ->setTransDate(new \DateTime());

        $this->entityManager->persist($transaction);
        $this->historyService->log(
            HistoryType::Contract,
            'TRANSACTION',
            'saleId',
            $sale->getSaleId(),
            sprintf('%s: debit=%s credit=%s', $detail->value, $debit ?? 0, $credit ?? 0),
        );

        return $transaction;
    }

    private function currentUsername(): ?string
    {
        $user = $this->security->getUser();

        return $user?->getUserIdentifier();
    }
}
