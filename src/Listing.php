<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class Listing extends DynamicPropertiesInterface
{
    private readonly string $_table;

    public private(set) Sorting $sorting {
        get => $this->sorting ??= new Sorting($this->_table);
    }
    public private(set) Label $label {
        get => $this->label ??= new Label($this->_table);
    }

    public mixed $globalOperations {
        get => $GLOBALS['TL_DCA'][$this->_table]['list']['global_operations'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->_table]['list']['global_operations'][] = match (true) {
                is_callable($value) => $value,
                $value instanceof GlobalOperation => get_object_vars($value),
                default => throw new \LogicException('Global operation must be callable or instance of '
                . GlobalOperation::class),
            };
        }
    }

    public mixed $operations {
        get => $GLOBALS['TL_DCA'][$this->_table]['list']['operations'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->_table]['list']['operations'][] = match (true) {
                is_callable($value) => $value,
                $value instanceof Operation => get_object_vars($value),
                default => throw new \LogicException('Operation must be callable or instance of ' . Operation::class),
            };
        }
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['list'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['list'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['list'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['list'][$name]);
    }

    public function addCallback(ListCallback $name, callable $callback): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['list']['sorting'][$name->value] = $callback;
    }
}
