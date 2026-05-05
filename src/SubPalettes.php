<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use TypeError;

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
        if (is_string($value)) {
            $this->_ref[$name] = $value;
            return;
        }

        if (is_array($value)) {
            $this->_ref[$name] = implode(';', $value);
            return;
        }

        throw new TypeError(sprintf(
            'The value for type can only be array or string, %s given',
            get_debug_type($value),
        ));
    }

    /** @mago-ignore analysis:mixed-return-statement */
    public function __get(string $name): ?string
    {
        return $this->_ref[$name] ?? null;
    }
}
