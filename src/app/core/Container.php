<?php


namespace App\Core;


use App\Exceptions\ContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    protected $bindings = [];

    public function get(string $id)
    {
        if($this->has($id)) {

            $resolved = $this->bindings[$id];

            return $resolved($this);
        }


        return $this->tryResolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    public function set(string $id, callable $resolver) {

        if($this->has($id)) {

            throw ContainerException::bindingAlreadyExistsException($id);
        }

        $this->bindings[$id] = $resolver;
    }

    public function tryResolve(string $id) {

        $reflectionClass = new \ReflectionClass($id);

        if(!$reflectionClass->isInstantiable()) {

            throw ContainerException::classIsNotInstantiableException($id);
        }

        $constructor = $reflectionClass->getConstructor();

        if(!$constructor) {

            return $reflectionClass->newInstance();
        }

        $params = $constructor->getParameters();

        if(!$params) {

            return $reflectionClass->newInstance();
        }

        $dependencies = [];

        foreach ($params as $param) {

            $paramName = $param->getName();
            $paramType = $param->getType();

            if(!$paramType) {
                throw ContainerException::missingTypeHintException($paramName);
            }

            if($paramType instanceof \ReflectionUnionType) {
                throw ContainerException::unionTypeHintException($paramName);
            }

            if($paramType instanceof \ReflectionNamedType && ! $paramType->isBuiltin()) {

                array_push($dependencies, $this->get($paramType->getName()));
                continue;
            }

            throw ContainerException::invalidParameterException($id);

        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
