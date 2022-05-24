<?php

declare(strict_types=1);

namespace App\Controllers;


use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

abstract class AbstractController
{
    protected Twig $view;
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get('twig');
    }

}
