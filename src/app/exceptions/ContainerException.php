<?php


namespace App\Exceptions;


use Psr\Container\ContainerExceptionInterface;

class ContainerException extends \Exception implements ContainerExceptionInterface
{
    public static function bindingAlreadyExistsException(string $key) {

        return new self("Binding already exists for key $key");
    }

    public static function classIsNotInstantiableException(string $class) {

        return new self("$class is not instantiable.");
    }

    public static function missingTypeHintException(string $name) {

        return new self("$name is missing type hint.");
    }

    public static function unionTypeHintException(string $name) {

        return new self("$name is having union type hinting.");
    }

    public static function invalidParameterException(string $name) {

        return new self("$name is invalid parameter");
    }
}
