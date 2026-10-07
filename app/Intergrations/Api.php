<?php

declare(strict_types=1);


use App\Services\V1\Logger\Field\ExtendedHttp;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Hamidrezaniazi\Pecs\Fields\Host;
use Hamidrezaniazi\Pecs\Fields\Http;
use Hamidrezaniazi\Pecs\Fields\Url;
use Hamidrezaniazi\Pecs\Properties\HttpMethod;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Api
{
    private ?object $response = null;

    abstract protected function baseUrl(): string;

    protected function getClient(?string $baseUrl = null, int $timeout = 5, int $connectTimeout = 2): Client
    {
        $stack = new HandlerStack;
        $stack->setHandler(new CurlHandler);
        $stack->push($this->logRequest());
        $stack->push($this->logResponse());

        return new Client([
            'base_uri' => $baseUrl ?: $this->baseUrl(),
            'timeout' => $timeout,
            'connect_timeout' => $connectTimeout,
            'handler' => $stack,
        ]);
    }

    public function logRequest(): Closure
    {
        return Middleware::mapRequest(function (RequestInterface $request) {

            logger()->channel('ecs')->info('Integration request', [
                new Http(
                    requestBodyContent: $request->getBody()->getContents(),
                    requestId: app('request_id'),
                    requestMethod: HttpMethod::from($request->getMethod()),
                ),
                new Url(
                    path: $request->getUri()->getPath(),
                    query: $request->getUri()->getQuery(),
                ),
                new Host(hostname: $request->getUri()->getHost()),
                new ExtendedHttp(
                    requestHeaders: $request->getHeaders(),
                    requestCookies: $request->getHeader('Cookie'),
                ),
            ]);

            return $request;
        });
    }

    public function logResponse(): Closure
    {
        return Middleware::mapResponse(function (ResponseInterface $response) {
            logger()->channel('ecs')->info('Integration response', [
                new Http(
                    requestId: app('request_id'),
                    responseBodyContent: $response->getBody()->getContents(),
                    responseStatusCode: $response->getStatusCode(),
                ),
                new ExtendedHttp(
                    responseHeaders: $response->getHeaders(),
                    responseCookies: $response->getHeader('Cookie'),
                ),
            ]);

            return $response;
        });
    }

    public function setResponse(?object $response): void
    {
        $this->response = $response;
    }

    public function getResponse(): ?object
    {
        return $this->response ?? null;
    }
}
