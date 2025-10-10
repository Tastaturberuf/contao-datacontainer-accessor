<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use BackedEnum;
use Contao\DcaLoader;

final class FieldBag
{

    public array $all {
        get => $GLOBALS['TL_DCA'][$this->table]['fields'] ?? [];
    }


    public function __construct(private readonly string $table)
    {
    }

    public function new(string|BackedEnum $name): Field
    {
        return $this->get($name);
    }

    public function get(string|BackedEnum $name): Field
    {
        return $this->add($name);
    }

    public function add(string|BackedEnum $name, null|callable|array $callback = null): Field
    {
        $name = $this->parseFieldName($name);

        $field = new Field($this->table, $name);

        if (is_array($callback)) {
            return $field->setArray($callback);
        }

        if (is_callable($callback)) {
            $callback($field, $name, $this->table);
        }

        return $field;
    }

    public function has(string|BackedEnum $name): bool
    {
        $name = $this->parseFieldName($name);

        return isset($GLOBALS['TL_DCA'][$this->table]['fields'][$name]);
    }

    public function copy(string $table, string|BackedEnum $name, null|string|BackedEnum $newName = null, null|callable|array $callback = null): Field
    {
        $name = $this->parseFieldName($name);
        $newName = $newName ? $this->parseFieldName($newName) : $name;

        new DcaLoader($table)->load();

        if (!isset($GLOBALS['TL_DCA'][$table]['fields'][$name])) {
            throw new \InvalidArgumentException(
                sprintf("Field '%s' does not exist in table '%s'.", $name, $table)
            );
        }

        $fieldArray = $GLOBALS['TL_DCA'][$table]['fields'][$name];

        // replace if the callback is an array
        if (is_array($callback)) {
            $fieldArray = array_replace_recursive($fieldArray, $callback);
        }

        $GLOBALS['TL_DCA'][$this->table]['fields'][$newName] = $fieldArray;

        $field = new Field($this->table, $newName);

        if (is_callable($callback)) {
            $callback($field, $newName, $this->table);
        }

        return $field;
    }

    public function duplicate(string|BackedEnum $name, string|BackedEnum $newName, null|callable|array $callback = null): Field
    {
        return $this->copy($this->table, $name, $newName, $callback);
    }

    private function parseFieldName(string|BackedEnum $name): string
    {
        if ($name instanceof BackedEnum) {
            return $name->value;
        }

        return $name;
    }

}
