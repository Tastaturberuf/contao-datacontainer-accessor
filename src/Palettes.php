<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class Palettes
{
    public readonly string $_table;
    public readonly array $_path;
    private array $_ref;

    public ?array $__selector__ {
        get => $this->_ref['__selector__'] ?? null;
        set {
            $this->_ref['__selector__'] = $value;
        }
    }

    public string|array $default {
        get => $this->_ref['default'] ?? null;
        set {
            if (is_string($value)) {
                $this->_ref['default'] = $value;
            } else {
                $this->_ref['default'] = implode(',', $value);
            }
        }
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect analysis:mixed-property-type-coercion
     * @mago-expect lint:no-global
     */
    public function __construct(string $table)
    {
        $GLOBALS['TL_DCA'][$table]['palettes'] ??= [];
        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'palettes'];
        $this->_ref = &$GLOBALS['TL_DCA'][$table]['palettes'];
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
