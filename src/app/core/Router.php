<?php

namespace App\Core;

use App\exceptions\RouterException;

class Router
{
    private static $router;

    private function __construct(protected Container $container, protected array $routes = [])
    {
    }

    public static function getRouter(): self {

        if(!isset(self::$router)) {

            self::$router = new self((new Container()));
        }

        return self::$router;
    }

    public function get(string $uri, string $action): void {

        $this->register($uri, $action, "GET");
    }

    public function post(string $uri, string $action): void {

        $this->register($uri, $action, "POST");
    }

    public function put(string $uri, string $action): void {

        $this->register($uri, $action, "PUT");
    }

    public function delete(string $uri, string $action): void{

        $this->register($uri, $action, "DELETE");
    }

    public function route(string $method, string $uri): bool {

        $result = dataGet($this->routes, $method .".". $uri);

        if(!$result) throw RouterException::routeNotFoundException($uri);

        $controller = $result['controller'];
        $function = $result['method'];

        if(class_exists($controller)) {

            $controllerInstance = $this->container->get($controller);

            if(method_exists($controllerInstance, $function)) {

                $controllerInstance->$function();
                return true;

            } else {

                throw RouterException::undefinedMethodException($controller, $function);
            }
        }

        return false;
    }

    public function getRoutes(): array {

        return $this->routes;
    }

    protected function register(string $uri, string $action, string $method): void {

        if(!isset($this->routes[$method])) $this->routes[$method] = [];

        list($controller, $function) = $this->extractAction($action);

        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'method' => $function
        ];
    }

    protected function extractAction(string $action, string $seperator = '@'): array {

       $sepIdx = strpos($action, $seperator);

       $controller = substr($action, 0, $sepIdx);
       $function = substr($action, $sepIdx + 1, strlen($action));

       return [$controller, $function];
    }
}
