<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case OFFLINE = 'offline';
    case ONLINE = 'online';
}
