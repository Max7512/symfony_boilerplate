<?php

namespace App\Twig\Components\Dashboard;

use App\Repository\OrderRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'DashboardVentes', template: 'components/Dashboard/DashboardVentes.html.twig')]
class DashboardVentes
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {
    }

    public function getSalesByMonth()
    {
        return $this->orderRepository->getSalesByMonth();
    }
}
