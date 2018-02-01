<?php

namespace App\Support\Postman;

use Mpociot\ApiDoc\Generators\LaravelGenerator;

class PostmanGenerator extends LaravelGenerator
{
    /**
     * @param  \Illuminate\Routing\Route $route
     * @param array $bindings
     * @param array $headers
     * @param bool $withResponse
     *
     * @return array
     */
    public function processRoute($route, $bindings = [], $headers = [], $withResponse = true)
    {
        $content = '';

        $routeAction = $route->getAction();
        $routeGroup = $this->getRouteGroup($routeAction['uses']);
        $routeDescription = $this->getRouteDescription($routeAction['uses']);

        if ($withResponse) {
            $response = $this->getRouteResponse($route, $bindings, $headers);
            if ($response->headers->get('Content-Type') === 'application/json') {
                $content = json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT);
            } else {
                $content = $response->getContent();
            }
        }

        return $this->getParameters([
            'id' => md5($this->getUri($route).':'.implode($this->getMethods($route))),
            'resource' => $routeGroup,
            'title' => $routeDescription['short'],
            'description' => $routeDescription['long'],
            'methods' => $this->getMethods($route),
            'uri' => $this->getUri($route),
            'parameters' => [],
            'middlewares' => $route->middleware(),
            'response' => $content,
        ], $routeAction, $bindings);
    }
    
}
