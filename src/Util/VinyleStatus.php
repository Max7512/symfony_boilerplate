<?php

namespace App\Util;

enum VinyleStatus: string
{
    case IN_STOCK = "En stock";
    case OUT_OF_STOCK = "En rupture de stock";
    case PREORDER = "En précommande";
}
