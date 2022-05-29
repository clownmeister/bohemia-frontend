<?php

declare(strict_types=1);


namespace App\Handlers;

use App\Dto\Request\RequestInterface;
use App\Exception\HandlerException;
use App\Exception\InvalidClassnameException;
use App\Service\ServiceInterface;
use GuzzleHttp\Client;
use ReflectionClass;
use ReflectionException;

abstract class AbstractApiHandler implements HandlerApiInterface
{
    protected string $serviceClass;
    protected ServiceInterface $service;

    /**
     * @throws InvalidClassnameException
     * @throws HandlerException
     */
    public function __construct(private Client $client)
    {
        $this->service = $this->createService();
    }

    /**
     * @throws InvalidClassnameException
     * @throws HandlerException
     */
    protected function createService(): ServiceInterface
    {
        if (!class_exists($this->getServiceClass())) {
            throw new InvalidClassnameException(
                sprintf("Class string %s is not valid.", $this->getServiceClass())
            );
        }

        try {
            $service_reflection = new ReflectionClass($this->getServiceClass());
            /** @var ServiceInterface $service */
            $service = $service_reflection->newInstanceArgs([$this->client]);
        } catch (ReflectionException $exception) {
            throw new HandlerException('Could not create reflection class');
        }
        if (!($service instanceof ServiceInterface)) {
            throw new HandlerException('Invalid service type');
        }

        return $service;
    }

    public function getServiceClass(): string
    {
        return $this->serviceClass;
    }

    public function handle(?RequestInterface $request = null): array
    {
        return $this->getService()->call($request);
    }

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface
    {
        return $this->service;
    }
}
