<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ListCallback;

final class DataContainerAccessor
{

    public readonly Config $config;
    public readonly Listing $list;

    public readonly FieldBag $fields;


    public function __construct(private readonly string $table)
    {
        $this->config = new Config($table);
        $this->list = new Listing($table);
        $this->fields = new FieldBag($table);
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->table][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->table][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->table][$name]);
    }

    public function config(callable $callback): Config
    {
        $callback($this->config);

        return $this->config;
    }

    public function addCallback(ConfigCallback|ListCallback|LabelCallback $name, callable $callback): void
    {
        if ($name instanceof ConfigCallback) {
            $GLOBALS['TL_DCA'][$this->table]['config'][$name->value][] = $callback;
        }

        if ($name instanceof ListCallback) {
            $GLOBALS['TL_DCA'][$this->table]['list']['sorting'][$name->value] = $name;
        }

        if ($name instanceof LabelCallback) {
            $GLOBALS['TL_DCA'][$this->table]['list']['label'][$name->value] = $name;
        }
    }

}
