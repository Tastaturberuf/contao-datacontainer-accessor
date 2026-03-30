<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Tastaturberuf\ContaoDataContainerAccessor\Exception\DynamicPropertyTypeError;
use TypeError;

/**
 * @internal
 */
#[\AllowDynamicProperties]
abstract class DynamicProperties
{
    abstract public function __get(string $name): mixed;

    abstract public function __set(string $name, mixed $value): void;

    abstract public function __isset(string $name): bool;

    abstract public function __unset(string $name): void;

    /**
     * @param array<array-key, mixed> $arguments
     */
    final public function __call(string $name, array $arguments): self
    {
        return $this->set($name, $arguments[0] ?? null);
    }

    /**
     * Getter with a default value.
     * If the property does not exist, the default value is returned.
     */
    final public function get(string $name, mixed $default = null): mixed
    {
        return $this->__get($name) ?? $default;
    }

    /**
     * Fluid setter for dynamic properties.
     *
     *     $dca->set('foo', 'bar')
     *         ->set('baz', ['bar']);
     */
    final public function set(string $name, mixed $value): self
    {
        $this->__set($name, $value);

        return $this;
    }

    final public function isset(string $name): bool
    {
        return $this->__isset($name);
    }

    final public function unset(string $name): self
    {
        $this->__unset($name);

        return $this;
    }

    /**
     * This is used for debugging and error messages. Should something like this:
     *
     *     return "\$GLOBALS['TL_DCA']['$this->_table']['config']['sql']['$name']";
     */
    abstract protected function _path(string $name): string;

    /**
     * @throws TypeError
     */
    final protected function _getNullableString(string $name): ?string
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_string($value)) {
            return $value;
        }

        throw DynamicPropertyTypeError::for($this->_path($name), '?string', $value);
    }

    /**
     * @throws TypeError
     */
    final protected function _getNullableInt(string $name): ?int
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_int($value)) {
            return $value;
        }

        throw DynamicPropertyTypeError::for($this->_path($name), '?int', $value);
    }

    /**
     * @throws TypeError
     */
    final protected function _getNullableBool(string $name): ?bool
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_bool($value)) {
            return $value;
        }

        throw DynamicPropertyTypeError::for($this->_path($name), '?bool', $value);
    }

    /**
     * @throws TypeError
     * @return array<array-key, mixed>|null
     */
    final protected function _getNullableArray(string $name): ?array
    {
        /** @mago-expect analysis:mixed-assignment */
        $value = $this->__get($name);

        if (is_null($value) || is_array($value)) {
            return $value;
        }

        throw DynamicPropertyTypeError::for($this->_path($name), '?array', $value);
    }
}
