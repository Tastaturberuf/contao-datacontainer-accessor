<?php

namespace Tastaturberuf\ContaoDataContainerAccessor;


final class FieldSql extends DynamicPropertiesInterface
{

    private readonly string $_table;
    private readonly string $_field;

    /**
     * The Doctrine type of the column.
     *
     * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/types.html
     */
    public string $type {
        get => $this->__get('type');
        set {
            $this->__set('type', $value);
        }
    }

    /**
     * The Doctrine type of the column.
     *
     * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/types.html
     */
    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Whether the column is nullable or not.
     *
     * Defaults to true.
     */
    public bool $notnull {
        get => $this->__get('notnull') ?? true;
        set {
            $this->__set('notnull', $value);
        }
    }

    /**
     * Whether the column is nullable or not.
     *
     * Defaults to true.
     */
    public function notnull(bool $notnull = true): self
    {
        $this->notnull = $notnull;

        return $this;
    }

    /**
     * The default value of the column if no value was specified.
     *
     * Defaults to null.
     */
    public null|float|string $default {
        get => $this->__get('default');
        set {
            $this->__set('default', $value);
        }
    }

    /**
     * The default value of the column if no value was specified.
     *
     * Defaults to null.
     */
    public function default(null|float|string $default = null): self
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Whether this column should use an autoincremented value if no value was specified. Only applies to
     * Doctrine's smallint, integer and bigint types.
     *
     * Defaults to false.
     */
    public bool $autoincrement {
        get => $this->__get('autoincrement') ?? false;
        set {
            $this->__set('autoincrement', $value);
        }
    }

    /**
     * Whether this column should use an autoincremented value if no value was specified. Only applies to
     * Doctrine's smallint, integer and bigint types.
     *
     * Defaults to false.
     */
    public function autoincrement(bool $autoincrement = true): self
    {
        $this->autoincrement = $autoincrement;

        return $this;
    }

    /**
     * The maximum length of the column. Only applies to Doctrine's string and binary types.
     *
     * Defaults to null and is evaluated to 255 in the platform.'
     */
    public ?int $length {
        get => $this->__get('length');
        set {
            $this->__set('length', $value);
        }
    }

    /**
     * The maximum length of the column. Only applies to Doctrine's string and binary types.
     *
     * Defaults to null and is evaluated to 255 in the platform.'
     */
    public function length(int $length, ?bool $fixed = null): self
    {
        $this->length = $length;

        if ($fixed !== null) {
            $this->fixed = $fixed;
        }

        return $this;
    }

    /**
     * Whether a string or binary Doctrine type column has a fixed length.
     *
     * Defaults to false.
     */
    public bool $fixed {
        get => $this->__get('fixed') ?? false;
        set {
            $this->__set('fixed', $value);
        }
    }

    /**
     * Whether a string or binary Doctrine type column has a fixed length.
     *
     * Defaults to false.
     */
    public function fixed(bool $fixed = true, ?int $length = null): self
    {
        $this->fixed = $fixed;

        if ($length) {
            $this->length = $length;
        }

        return $this;
    }

    /**
     * The precision of a Doctrine decimal, number or float type column that determines the overall maximum number
     * of digits to be stored (including scale).
     *
     * Defaults to 10.
     */
    public int $precision {
        get => $this->__get('precision') ?? 10;
        set {
            $this->__set('precision', $value);
        }
    }

    /**
     * The precision of a Doctrine decimal, number or float type column that determines the overall maximum number
     * of digits to be stored (including scale).
     *
     * Defaults to 10.
     */
    public function precision(int $precision = 10): self
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * The scale of a Doctrine decimal, number or float type column that determines the maximum number of digits
     * to be stored after the decimal point.
     *
     * Defaults to 0.
     */
    public int $scale {
        get => $this->__get('scale') ?? 0;
        set {
            $this->__set('scale', $value);
        }
    }

    /**
     * The scale of a Doctrine decimal, number or float type column that determines the maximum number of digits
     * to be stored after the decimal point.
     *
     * Defaults to 0.
     */
    public function scale(int $scale = 0): self
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * Whether a smallint, integer or bigint Doctrine type column should allow unsigned values only.
     *
     * Supported only by MySQL. Defaults to false.
     */
    public bool $unsigned {
        get => $this->__get('unsigned') ?? false;
        set {
            $this->__set('unsigned', $value);
        }
    }

    /**
     * Whether a smallint, integer or bigint Doctrine type column should allow unsigned values only.
     *
     * Supported only by MySQL. Defaults to false.
     */
    public function unsigned(bool $unsigned = true): self
    {
        $this->unsigned = $unsigned;

        return $this;
    }

    /**
     * The column comment. Supported by MySQL, PostgreSQL, Oracle and SQL Server.
     *
     * Defaults to null.
     */
    public int|string $comment {
        get => $this->__get('comment');
        set {
            $this->__set('comment', $value);
        }
    }

    /**
     * The column comment. Supported by MySQL, PostgreSQL, Oracle and SQL Server.
     *
     * Defaults to null.
     */
    public function comment(int|string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * The custom column declaration SQL snippet to use instead of the generated SQL by Doctrine. Defaults to null.
     * This can useful to add vendor specific declaration information that is not evaluated by Doctrine
     * (such as the ZEROFILL attribute on MySQL).
     */
    public ?string $columnDefinition {
        get => $this->__get('columnDefinition');
        set {
            $this->__set('columnDefinition', $value);
        }
    }

    /**
     * The custom column declaration SQL snippet to use instead of the generated SQL by Doctrine. Defaults to null.
     * This can useful to add vendor specific declaration information that is not evaluated by Doctrine
     * (such as the ZEROFILL attribute on MySQL).
     */
    public function columnDefinition(string $columnDefinition): self
    {
        $this->columnDefinition = $columnDefinition;
    }

    /**
     * Additional options for the column that are supported by all vendors.
     */
    public CustomSchemaOptions $customSchemaOptions {
        get => $this->customSchemaOptions ??= new CustomSchemaOptions($this->_table, $this->_field);
        set(array|CustomSchemaOptions $value) {
            match (true) {
                $value instanceof CustomSchemaOptions => $this->customSchemaOptions = $value,
                default => $this->__set('customSchemaOptions', $value)
            };
        }
    }

    /**
     * Additional options for the column that are supported by all vendors:
     */
    public function customSchemaOptions(array $customSchemaOptions): self
    {
        $this->customSchemaOptions = $customSchemaOptions;

        return $this;
    }

    public function __construct(string $table, string $field)
    {
        $this->_table = $table;
        $this->_field = $field;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['sql'][$name]);
    }

}
