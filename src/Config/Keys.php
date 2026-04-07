<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Config;

/**
 * @mago-expect lint:no-global
 */
final readonly class Keys
{
    public array $_path;
    public string $_table;

    public function __construct(
        public string $table,
    ) {
        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'config', 'sql', 'keys'];
    }

    public static function create(string $table): self
    {
        return new self($table);
    }

    /**
     * @mago-expect analysis:mixed-return-statement
     */
    public function __get(string $name): ?string
    {
        return $GLOBALS['TL_DCA'][$this->_table]['config']['sql']['keys'][$name] ?? null;
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     */
    public function __set(string $name, string $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['config']['sql']['keys'][$name] = $value;
    }

    /**
     * @mago-expect lint:no-isset
     */
    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['config']['sql']['keys'][$name]);
    }

    /**
     * @mago-expect analysis:mixed-array-access
     */
    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['config']['sql']['keys'][$name]);
    }
}
