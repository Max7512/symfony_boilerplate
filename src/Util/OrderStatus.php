<?php

namespace App\Util;

enum OrderStatus: string
{
    case IN_PREPARATION = "En préparation";
    case SENT = "Expédiée";
    case DELIVERED = "Livrée";
    case CANCELLED = "Annulée";
}
