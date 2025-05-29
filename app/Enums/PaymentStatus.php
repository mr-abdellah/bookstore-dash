<?php
namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PO_SIGNED = 'po_signed';
    case PAYMENT_CONFIRMED = 'payment_confirmed';
    case PAID = 'paid';
    case FAILED = 'failed';
}