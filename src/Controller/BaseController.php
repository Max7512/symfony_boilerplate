<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    public function renderAndSwitchLocale(Request $request, string $view, array $parameters = [], ?Response $response = null): Response
    {
        $parameters["locales"] = ["en", "fr"];
        
        $request->setLocale($request->getSession()->get("_locale", "fr"));
        
        return $this->render($view, $parameters, $response);
    }
}