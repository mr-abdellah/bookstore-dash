<?php
namespace App\Enums;

enum PublisherPayoutStatus: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FAILED = 'failed';
}