<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ListCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Config;

final class DataContainerAccessor extends DynamicProperties
{
    private string $_table;

    /**
     * If you get it, you become every time a Config. If you set it, you can only use a Closure.
     *
     * @property Config
     * @property-write Closure(Config $config, string $table): void
     */
    public Config $config {
        get => $this->config ??= new Config($this->_table);
        set(Closure|Config $value) {
            if (!$value instanceof Closure) {
                throw new \TypeError('You can only set a Closure here');
            }

            $this->config($value);
        }
    }

    /**
     * @param Closure(Config $config, string $table): void $callback
     */
    public function config(Closure $callback): self
    {
        $callback($this->config, $this->_table);

        return $this;
    }

    public Listing $list {
        get => $this->list ??= new Listing($this->_table);
        set(array|Listing $value) {
            $this->__set('list', $value);
        }
    }

    public function listing(callable $callback): self
    {
        $callback($this->list, $this->_table);

        return $this;
    }

    public FieldBag $fields {
        get => $this->fields ??= new FieldBag($this->_table);
        set(array|FieldBag $value) {
            $this->__set('fields', $value);
        }
    }

    public function fields(callable $callback): self
    {
        $callback($this->fields, $this->_table);

        return $this;
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table][$name]);
    }

    public function addCallback(string|ConfigCallback|ListCallback|LabelCallback $name, callable $callback): self
    {
        match ($name) {
            'config.oncreate', ConfigCallback::Create => $GLOBALS['TL_DCA'][$this->_table]['config']['oncreate_callback'][] = $callback,
            'config.onload', ConfigCallback::Load => $GLOBALS['TL_DCA'][$this->_table]['config']['onload_callback'][] = $callback,
            'config.onsubmit', ConfigCallback::Submit => $GLOBALS['TL_DCA'][$this->_table]['config']['onsubmit_callback'][] = $callback,

            default => $GLOBALS['TL_DCA'][$this->_table]['config'][$name->value ?? $name][] = $callback
        };

        if ($name instanceof ConfigCallback) {
            $GLOBALS['TL_DCA'][$this->_table]['config'][$name->value][] = $callback;
        }

        if ($name instanceof ListCallback) {
            $GLOBALS['TL_DCA'][$this->_table]['list']['sorting'][$name->value] = $name;
        }

        if ($name instanceof LabelCallback) {
            $GLOBALS['TL_DCA'][$this->_table]['list']['label'][$name->value] = $name;
        }

        return $this;
    }

}
