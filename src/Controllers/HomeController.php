<?php

declare(strict_types=1);

namespace App\Controllers;

use FFTrader\KeycloakSDK\IDP\Entity\Response\KeycloakTokenResponse;
use FFTrader\KeycloakSDK\IDP\Exception\ExpiredTokenException;
use FFTrader\KeycloakSDK\ImsClient;
use FFTrader\KeycloakSDK\KeycloakClient;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteInterface;
use Slim\Routing\RouteCollector;
use Throwable;


class HomeController extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     * @throws Throwable
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render(
            $response,
            'pages/home.html.twig',
            [
                'test' => 'test',
            ]
        );
    }
}
