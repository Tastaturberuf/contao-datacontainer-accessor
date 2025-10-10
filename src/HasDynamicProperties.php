<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

trait HasDynamicProperties
{
    abstract public function __get(string $name): mixed;

    abstract public function __set(string $name, mixed $value): void;

    abstract public function __isset(string $name): bool;

    abstract public function __unset(string $name): void;

}
