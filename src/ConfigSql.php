<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 */
final class ConfigSql extends DynamicPropertiesInterface
{

    private readonly string $_table;


    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public ?string $engine {
        get => $this->__get('engine');
        set {
            $this->__set('engine', $value);
        }
    }

    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public function engine(string $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    public ?string $charset {
        get => $this->__get('charset');
        set {
            $this->__set('charset', $value);
        }
    }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    public function charset(string $charset): self
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     */
    public array $keys {
        get => $this->__get('keys') ?? [];
        set {
            $this->__set('keys', $value);
        }
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     */
    public function keys(array $keys): self
    {
        $this->keys = $keys;

        return $this;
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name]);
    }

}
