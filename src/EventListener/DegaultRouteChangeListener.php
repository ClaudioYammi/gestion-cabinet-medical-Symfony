<?php

// src/EventListener/DefaultRouteChangeListener.php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultRouteChangeListener
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        // Votre logique de redirection personnalisée ici
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        
        // Rediriger vers "/login"
        if ($path === '/') {
            $url = $this->urlGenerator->generate('app_login'); // Remplacez "app_login" par le nom de votre route vers "/login"
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }
}