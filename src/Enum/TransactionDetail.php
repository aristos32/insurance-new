<?php

namespace App\Enum;

enum TransactionDetail: string
{
    case New = 'NEW';
    case Cash = 'CASH';
    case Check = 'CHECK';
    case Renewal = 'RENEWAL';
    case Cancel = 'CANCEL';
    case Discount = 'DISCOUNT';
    case Alter = 'ALTER';
    case Transfer = 'TRANSFER';
    case Correction = 'CORRECTION';
}
