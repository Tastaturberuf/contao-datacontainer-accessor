<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use function implode;
use function is_array;

final class SubPalettes
{
    public readonly string $_table;
    public readonly array $_path;
    private array $_ref;

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect analysis:mixed-property-type-coercion
     * @mago-expect lint:no-global
     */
    public function __construct(string $table)
    {
        $GLOBALS['TL_DCA'][$table]['subpalettes'] ??= [];
        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'subpalettes'];
        $this->_ref = &$GLOBALS['TL_DCA'][$table]['subpalettes'];
    }

    public function __set(string $name, string|array $value): void
    {
        if (is_array($value)) {
            $value = implode(';', $value);
        }

        $this->_ref[$name] = $value;
    }

    /** @mago-expect analysis:mixed-return-statement */
    public function __get(string $name): ?string
    {
        return $this->_ref[$name] ?? null;
    }

    /** @mago-expect lint:no-isset */
    public function __isset(string $name): bool
    {
        return isset($this->_ref[$name]);
    }
}
