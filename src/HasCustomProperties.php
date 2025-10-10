<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

trait HasCustomProperties
{

    public function __get(string $name): mixed
    {
        return $this->getDcaPath()[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->getDcaPath()[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->getDcaPath()[$name]);
    }

    abstract protected function &getDcaPath(): array;

}
