<?php


namespace App\exceptions;


class RouterException extends \Exception
{

    public static function routeNotFoundException(string $uri) {

        return new self("Route $uri not found.");
    }

    public static function undefinedMethodException(string $class, string $method) {

        return new self("Method $method not defined in $class");
    }
}
