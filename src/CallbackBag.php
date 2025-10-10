<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class CallbackBag implements \ArrayAccess
{

    public function __construct(private array &$path)
    {
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->path[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->path[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if(!\is_callable($value)) {
            throw new \InvalidArgumentException('The callback must be a callable.');
        }

        if (null === $offset) {
            $this->path[] = $value;
        } else {
            $this->path[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->path[$offset]);
    }

}
