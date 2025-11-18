<?php

namespace App\Twig\Components\Modal;

use Symfony\Component\Form\FormView;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Modal', template: 'components/Modal/Modal.html.twig')]
class Modal
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(useSerializerForHydration: true)]
    public ?FormView $form = null;

    #[LiveProp]
    public bool $visible = false;

    public function __construct() {}

    #[LiveAction]
    public function success(): void
    {
        $this->emit("modal-success", ["form" => $this->form]);
        $this->visible = false;
    }

    #[LiveListener("modal-close")]
    public function cancel(): void
    {
        $this->visible = false;
    }

    #[LiveListener("modal-open")]
    public function open(): void 
    {
        $this->visible = true;
    }
}
