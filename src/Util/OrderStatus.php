<?php

namespace App\Util;

enum OrderStatus: string
{
    case IN_PREPARATION = "in_preparation";
    case SENT = "sent";
    case DELIVERED = "delivered";
    case CANCELLED = "cancelled";
}
