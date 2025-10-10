<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use AllowDynamicProperties;

#[AllowDynamicProperties]
final class Field extends DynamicPropertiesInterface
{

    private readonly string $_table;

    private readonly string $_name;

    public ?string $label {
        get => $this->__get('label');
        set {
            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['label'] = &$value;
        }
    }

    public mixed $default {
        get => $this->__get('default');
        set {
            $this->__set('default', $value);
        }
    }

    public ?bool $exclude {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['exclude'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['exclude'] = $value;
        }
    }

    public ?bool $toggle {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['toggle'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['toggle'] = $value;
        }
    }

    public ?bool $search {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['search'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['search'] = $value;
        }
    }

    public ?bool $sorting {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['sorting'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['sorting'] = $value;
        }
    }

    /**
     * @var callable
     */
    public mixed $options_callback {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['options_callback'] ?? null;
        set {
            if (!is_callable($value)) {
                throw new \InvalidArgumentException('The options_callback must be a callable.');
            }

            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['options_callback'] = $value;
        }
    }

    public ?bool $filter {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['filter'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['filter'] = $value;
    }

    public ?int $flag {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['flag'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['flag'] = $value;
    }

    public ?int $length {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['length'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['length'] = $value;
    }

    public ?string $inputType {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['inputType'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['inputType'] = $value;
    }

    public ?array $options {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['options'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['options'] = $value;
    }

    public ?\BackedEnum $enum {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['enum'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['enum'] = $value;
    }

    public ?string $foreignKey {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['foreignKey'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['foreignKey'] = $value;
    }

    public ?array $reference {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['reference'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['reference'] = &$value;
    }

    public ?array $explanation {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['explanation'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['explanation'] = &$value;
    }

    /**
     * @var callable
     */
    public mixed $input_field_callback {
        get => $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['input_field_callback'] ?? null;
        set {
            if (!is_callable($value)) {
                throw new \InvalidArgumentException('The input_field_callback must be a callable.');
            }

            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name]['input_field_callback'] = $value;
        }
    }

    public Evaluation $eval {
        get => $this->eval;
        set(array|callable|Evaluation $value) {
            match (true) {
                is_array($value) => $this->__set('eval', $value),
                is_callable($value) => $value($this->eval),
                $value instanceof Evaluation => $this->eval = $value
            };
        }
    }

    public FieldSql $sql {
        get => $this->sql;
        set(string|array|FieldSql $value) {
            match (true) {
                $value instanceof FieldSql => $this->sql = $value,
                default => $this->__set('sql', $value),
            };
        }
    }

    public Relation $relation {
        get => $this->relation;
        set(array|Relation $value) {
            match (true) {
                $value instanceof Relation => $this->relation = $value,
                default => $this->__set('relation', $value),
            };
        }
    }

    public readonly CallbackBag $wizard;
    public readonly CallbackBag $loadCallback;
    public readonly CallbackBag $saveCallback;
    public readonly CallbackBag $xLabelCallback;

    public function __construct(string $table, string $name)
    {
        // Use internal names to avoid conflicts with dynamic properties
        $this->_table = $table;
        $this->_name = $name;

        $this->eval = new Evaluation($table, $name);
        $this->sql = new FieldSql($table, $name);


        $this->wizard = new CallbackBag($this->getReference('wizard'));
        $this->loadCallback = new CallbackBag($this->getReference('load_callback'));
        $this->saveCallback = new CallbackBag($this->getReference('save_callback'));
        $this->xLabelCallback = new CallbackBag($this->getReference('xlabel'));
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name]);
    }

    /**
     * @todo https://www.php.net/manual/en/language.oop5.property-hooks.php#language.oop5.property-hooks.virtual (Chapter Reference)
     */
    private function &getReference(string $name): array
    {
        // make sure that the array exists because we can only return valid variable as reference
        if (!isset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name])) {
            $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name] = [];
        }

        return $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name][$name];
    }

    public function setArray(array $array): self
    {
        $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_name] = $array;

        return $this;
    }

}
