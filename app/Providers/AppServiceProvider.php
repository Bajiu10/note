<?php

namespace App\Providers;

use Max\Di\Contracts\PropertyAttribute;
use Max\Di\Exceptions\ContainerException;
use Max\Foundation\Providers\AbstractProvider;
use Psr\Container\ContainerInterface;

class AppServiceProvider extends AbstractProvider
{
    public function register()
    {
        $this->app->afterResolving(function(ContainerInterface $container, \ReflectionClass $reflectionClass, object $object) {
            if (PHP_VERSION_ID >= 80000 && config('app.annotation.enable')) {
                foreach ($reflectionClass->getProperties() as $property) {
                    try {
                        foreach ($property->getAttributes() as $attribute) {
                            $instance = $attribute->newInstance();
                            if (!$instance instanceof PropertyAttribute) {
                                throw new ContainerException('Attribute ' . get_class($instance) . ' must implements ProPertyAttribute interface.');
                            }
                            $instance->handle($container, $property, $object);
                        }
                    } catch (\Exception $e) {
                        throw new ContainerException(sprintf('Property %s cannot be injected into %s. (%s)', $property->getName(), $reflectionClass->getName(), $e->getMessage()));
                    }
                }
            }
        });
    }

    public function boot()
    {
    }

}
