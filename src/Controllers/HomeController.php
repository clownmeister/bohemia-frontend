<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Dto\Request\GetPostsRequest;
use App\Handlers\GetPostsHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;


final class HomeController extends AbstractController
{
    public function __construct(ContainerInterface $container, private GetPostsHandler $postsHandler)
    {
        parent::__construct($container);
    }

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
        $posts = $this->postsHandler->handle(
            new GetPostsRequest(0, 10)
        );

        return $this->view->render(
            $response,
            'pages/home.html.twig',
            [
                'posts' => $posts,
            ]
        );
    }
}
