<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

abstract class DynamicPropertiesInterface
{

    abstract public function __get(string $name): mixed;

    abstract public function __set(string $name, mixed $value): void;

    abstract public function __isset(string $name): bool;

    abstract public function __unset(string $name): void;

    public function set(string $name, mixed $value): static
    {
        $this->__set($name, $value);

        return $this;
    }

    public function unset(string $name): static
    {
        $this->__unset($name);

        return $this;
    }

}
