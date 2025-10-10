<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class Relation extends DynamicPropertiesInterface
{

    private readonly string $_table;
    private readonly string $_field;

    public ?string $type {
        get => $this->__get('type');
        set {
            $this->__set('type', $value);
        }
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public ?string $load {
        get => $this->__get('load');
        set {
            $this->__set('load', $value);
        }
    }

    public function load(string $load): self
    {
        $this->load = $load;

        return $this;
    }


    public ?string $table {
        get => $this->__get('table');
        set {
            $this->__set('table', $value);
        }
    }

    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public ?string $field {
        get => $this->__get('field');
        set {
            $this->__set('field', $value);
        }
    }

    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function __construct(string $table, string $field)
    {
        $this->_table = $table;
        $this->_field = $field;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['relation'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['relation'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['relation'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['relation'][$name]);
    }

}
