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

    abstract protected array $_ref { get; }

    public function __get(string $name): mixed
    {
        return $this->_ref[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->_ref[$name] = $value;
    }

    /** @mago-expect lint:no-isset */
    public function __isset(string $name): bool
    {
        return isset($this->_ref[$name]);
    }

    /**
     * @throws TypeError
     * @deprecated Use _ref instead
     */
    protected function getNullableInt(string $name): ?int
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->_ref[$name] ?? null;

        if (null === $value || is_int($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?int', $value);
    }

    public function __unset(string $name): void
    {
        unset($this->_ref[$name]);
    }

    abstract public function __invoke(Closure $callback): void;

    /**
     * @throws TypeError
     * @deprecated Use _ref instead
     */
    protected function getNullableString(string $name): ?string
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->_ref[$name] ?? null;

        if (null === $value || is_string($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?string', $value);
    }

    /**
     * @throws TypeError
     * @deprecated Use _ref instead
     */
    protected function getNullableBool(string $name): ?bool
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->_ref[$name] ?? null;

        if (null === $value || is_bool($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?bool', $value);
    }

    /**
     * @throws TypeError
     * @return array<array-key, mixed>|null
     * @deprecated Use _ref instead
     */
    protected function getNullableArray(string $name): ?array
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->_ref[$name] ?? null;

        if (null === $value || is_array($value)) {
            return $value;
        }

        throw AccessorTypeError::for([...$this->_path, $name], '?array', $value);
    }
}
