<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Dto\Request\GetPostRequest;
use App\Handlers\GetPostHandler;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;


final class PostController extends AbstractController
{
    public function __construct(ContainerInterface $container, private GetPostHandler $postHandler)
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
        if (!array_key_exists('slug', $args)) {
            return $this->notFound($response);
        }

        try {
            $result = $this->postHandler->handle(
                new GetPostRequest($args['slug'])
            );
        } catch (GuzzleException) {
            return $this->notFound($response);
        }

        return $this->view->render(
            $response,
            'pages/post.html.twig',
            [
                'post' => $result,
            ]
        );
    }

}
