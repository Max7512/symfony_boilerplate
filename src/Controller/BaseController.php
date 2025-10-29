<?php

namespace App\Controller;

use Override;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    #[Override]
    public function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $parameters["locales"] = ["en", "fr"];
        
        return parent::render($view, $parameters, $response);
    }
}