<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;
use Generator;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\SortingCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\ConfigInterface;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\LabelInterface;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\SortingInterface;

/**
 * @mago-expect lint:no-global
 */
final class DataContainerAccessor
{
    public readonly string $_table;

    /**
     * Returns a ConfigInterface instance:
     *
     *     $this->config->dataContainer = DC_Table::class;
     *     $this->config->enableVersioning = true;
     *
     * Accepts a Closure that receives the ConfigInterface instance and the table name as parameters:
     *
     *     $this->config = function (ConfigInterface $config, string $table): void {
     *         $config->dataContainer = DC_Table::class;
     *         $config->enableVersioning = true;
     *     };
     */
    public ConfigInterface $config {
        get => $this->config ??= new Config($this->_table);
        /**
         * @param ConfigInterface|Closure(ConfigInterface $config, string $table): void $callback
         */
        set(ConfigInterface|Closure $callback) {
            if ($callback instanceof ConfigInterface) {
                /* @todo Check if the table name is the same as the one passed to the constructor,
                 *   better where to find a way to only set a classname for ConfigInterface and initialize it dynamic.
                 *   or drop an error or a warning.
                 *   With PHP 8.5 maybe "clone with" can be a solution.
                 */
                $this->config = $callback;
                return;
            }

            $this->config ??= new Config($this->_table);
            $this->config->__invoke($callback);
        }
    }

    /**
     * @param Closure(ConfigInterface $config, string $table): void $callback
     */
    public function config(Closure $callback): self
    {
        $this->config->__invoke($callback);

        return $this;
    }

    public SortingInterface $sorting {
        get => $this->sorting ??= new Sorting($this->_table);
        /**
         * @param SortingInterface|Closure(SortingInterface $sorting, string $table): void $callback
         */
        set(SortingInterface|Closure $callback) {
            if ($callback instanceof SortingInterface) {
                $this->sorting = $callback;
                return;
            }

            $this->sorting ??= new Sorting($this->_table);
            $this->sorting->__invoke($callback);
        }
    }

    /**
     * @param Closure(SortingInterface $sorting, string $table): void $callback
     */
    public function sorting(Closure $callback): self
    {
        $this->sorting->__invoke($callback);

        return $this;
    }

    public LabelInterface $label {
        get => $this->label ??= new Label($this->_table);
        /**
         * @param LabelInterface|Closure(LabelInterface $label, string $table): void $value
         */
        set(LabelInterface|Closure $value) {
            if ($value instanceof LabelInterface) {
                $this->label = $value;
                return;
            }

            $this->label ??= new Label($this->_table);
            $this->label->__invoke($value);
        }
    }

    /**
     * @param Closure(LabelInterface $label, string $table): void $callback
     */
    public function label(Closure $callback): self
    {
        $this->label->__invoke($callback);

        return $this;
    }

    public GlobalOperationBag $globalOperation {
        get => $this->globalOperation ??= new GlobalOperationBag($this->_table);
    }

    /**
     * @param Closure(GlobalOperation $operation, string $table): void $callback
     */
    public function globalOperation(string $name, Closure $callback): self
    {
        $callback(new GlobalOperation($name, $this->_table), $this->_table);

        return $this;
    }

    public private(set) FieldBag $fields {
        get => $this->fields ??= new FieldBag($this->_table);
    }

    /**
     * @param Closure(Generator $fields, string $table): void $callback
     */
    public function fields(Closure $callback): self
    {
        $callback($this->fields->all(), $this->_table);

        return $this;
    }

    public Palettes $palettes {
        get => $this->palettes ??= new Palettes($this->_table);
    }

    public function palettes(Closure $callback): self
    {
        $callback($this->palettes, $this->_table);

        return $this;
    }

    public SubPalettes $subPalettes {
        get => $this->subPalettes ??= new SubPalettes($this->_table);
    }

    public private(set) OperationBag $operation {
        get => $this->operation ??= new OperationBag($this->_table);
    }

    /**
     * @param Closure(Operation $operation, string $table): void $callback
     */
    public function operation(string $name, Closure $callback): self
    {
        $callback(new Operation($name, $this->_table), $this->_table);

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

    /** @mago-expect analysis:mixed-array-assignment */
    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table][$name] = $value;
    }

    /** @mago-ignore lint:no-isset */
    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table][$name]);
    }

    /** @mago-ignore analysis:mixed-array-access */
    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table][$name]);
    }

    /** @mago-ignore analysis:mixed-array-assignment */
    public function __call(string $name, array $arguments): self
    {
        $GLOBALS['TL_DCA'][$this->_table][$name] = $arguments[0];

        return $this;
    }

    public static function create(string $table): self
    {
        static $instances = [];

        return $instances[$table] ??= new static($table);
    }

    public function addCallback(ConfigCallback|SortingCallback|LabelCallback $name, Closure $callback): self
    {
        $name->create($this->_table, $callback);

        return $this;
    }
}
