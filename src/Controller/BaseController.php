<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    #[\Override]
    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $parameters['connecte'] = false;
        return parent::render($view, $parameters, $response);
    }
}