<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class CustomSchemaOptions extends DynamicPropertiesInterface
{

    private readonly string $_table;
    private readonly string $_field;


    /**
     * The character set to use for the column. Currently only supported on MySQL.
     */
    public ?string $charset {
        get => $this->__get('charset');
        set {
            $this->__set('charset', $value);
        }
    }

    /**
     * The character set to use for the column. Currently only supported on MySQL.
     */
    public function charset(string $charset): self
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * The collation to use for the column. Supported by MySQL, PostgreSQL, Sqlite and SQL Server.
     */
    public string $collation {
        get => $this->__get('collation');
        set {
            $this->__set('collation', $value);
        }
    }

    /**
     * The collation to use for the column. Supported by MySQL, PostgreSQL, Sqlite and SQL Server.
     */
    public function collation(string $collation): self
    {
        $this->collation = $collation;

        return $this;
    }

    public function __construct(string $table, string $field)
    {
        $this->_table = $table;
        $this->_field = $field;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql']['customSchemaOptions'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql']['customSchemaOptions'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql']['customSchemaOptions'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql']['customSchemaOptions'][$name]);
    }

}
