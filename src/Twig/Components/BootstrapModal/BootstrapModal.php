<?php

namespace App\Twig\Components\BootstrapModal;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent("BootstrapModal", template: "components/BootstrapModal/BootstrapModal.html.twig")]
class BootstrapModal
{
    public ?string $id = null;
}