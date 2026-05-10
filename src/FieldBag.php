<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use BackedEnum;
use Closure;
use InvalidArgumentException;

final class FieldBag
{
    public function __construct(
        private readonly string $table,
    ) {}

    public function __get(string|BackedEnum $name): Field
    {
        $name = $this->parseFieldName($name);

        return $this->get($name);
    }

    /**
     * @param array<array-key, string>|Closure(Field $field): void $value
     * @throws InvalidArgumentException
     */
    public function __set(string $name, array|Closure $value): void
    {
        if (!is_array($value) && !$value instanceof Closure) {
            throw new InvalidArgumentException(
                'The dynamic property "'
                . $name
                . '" value must be an array or a Closure. '
                . gettype($value)
                . ' given.',
            );
        }

        $this->add($name, $value);
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->table]['fields'][$name]);
    }

    /**
     * @return \Generator<string, Field>
     */
    public function all(): \Generator
    {
        foreach (array_keys($GLOBALS['TL_DCA'][$this->table]['fields'] ?? []) as $name) {
            yield $name => $this->get($name);
        }

    }

    public function get(string|BackedEnum $name): Field
    {
        $name = $this->parseFieldName($name);

        return new Field($this->table, $name);
    }

    /**
     * Add a new field to the data container
     */
    public function add(string|BackedEnum $name, null|array|Closure $callback = null): self
    {
        $name = $this->parseFieldName($name);

        $field = new Field($this->table, $name);

        if (is_array($callback)) {
            $field->setArray($callback);
        }

        if ($callback instanceof Closure) {
            $callback($field, $name, $this->table);
        }

        return $this;
    }

    public function has(string|BackedEnum $name): bool
    {
        $name = $this->parseFieldName($name);

        return isset($GLOBALS['TL_DCA'][$this->table]['fields'][$name]);
    }

    public function remove(string|BackedEnum $name): void
    {
        $name = $this->parseFieldName($name);

        unset($GLOBALS['TL_DCA'][$this->table]['fields'][$name]);
    }

    /**
     * Copy a field from another table and optionally rename it.
     */
    public function copy(
        string $table,
        string|BackedEnum $name,
        null|string|BackedEnum $newName = null,
        null|array|Closure $callback = null,
    ): Field {
        $name = $this->parseFieldName($name);
        $newName = $newName ? $this->parseFieldName($newName) : $name;

        new DcaLoader($table)->load();

        if (!isset($GLOBALS['TL_DCA'][$table]['fields'][$name])) {
            throw new InvalidArgumentException(sprintf("Field '%s' does not exist in table '%s'.", $name, $table));
        }

        if (!is_array($GLOBALS['TL_DCA'][$table]['fields'][$name])) {
            throw new InvalidArgumentException(sprintf(
                "Field '%s' is not an array. Got '%s'.",
                $name,
                gettype($GLOBALS['TL_DCA'][$this->table]['fields'][$name]),
            ));
        }

        $fieldArray = $GLOBALS['TL_DCA'][$table]['fields'][$name];

        // replace if the callback is an array
        if (is_array($callback)) {
            $fieldArray = array_replace_recursive($fieldArray, $callback);
        }

        $GLOBALS['TL_DCA'][$this->table]['fields'][$newName] = $fieldArray;

        $field = new Field($this->table, $newName);

        if ($callback instanceof Closure) {
            $callback($field, $newName, $this->table);
        }

        return $field;
    }

    /**
     * Copy a field from the same table and rename it.
     */
    public function duplicate(
        string|BackedEnum $name,
        string|BackedEnum $newName,
        null|array|Closure $callback = null,
    ): Field {
        return $this->copy($this->table, $name, $newName, $callback);
    }

    private function parseFieldName(string|BackedEnum $name): string
    {
        if ($name instanceof BackedEnum) {
            return (string) $name->value;
        }

        return $name;
    }
}
