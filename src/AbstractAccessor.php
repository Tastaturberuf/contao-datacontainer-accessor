<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use AllowDynamicProperties;
use Closure;
use Tastaturberuf\ContaoDataContainerAccessor\Exception\AccessorTypeError;
use TypeError;

/**
 * @internal
 */
#[AllowDynamicProperties]
abstract class AbstractAccessor
{
    abstract public string $_table { get; }

    /**
     * @var list<string>
     */
    abstract public array $_path { get; }

    abstract public function __get(string $name): mixed;

    abstract public function __set(string $name, mixed $value): void;

    abstract public function __isset(string $name): bool;

    abstract public function __unset(string $name): void;

    abstract public function __invoke(Closure $callback): void;

    /**
     * @throws TypeError
     */
    protected function getNullableString(string $name): ?string
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_string($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?string', $value);
    }

    /**
     * @throws TypeError
     */
    protected function getNullableInt(string $name): ?int
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_int($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?int', $value);
    }

    /**
     * @throws TypeError
     */
    protected function getNullableBool(string $name): ?bool
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_bool($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?bool', $value);
    }

    /**
     * @throws TypeError
     * @return array<array-key, mixed>|null
     */
    protected function getNullableArray(string $name): ?array
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_array($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?array', $value);
    }
}
