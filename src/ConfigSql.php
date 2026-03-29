<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Override;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\ConfigSqlMethodInterface;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\ConfigSqlPropertyInterface;

use function array_replace;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 */

final class ConfigSql extends DynamicProperties implements ConfigSqlPropertyInterface, ConfigSqlMethodInterface
{
    private readonly string $_table;

    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public ?string $engine {
        get => $this->_getNullableString('engine');
        set {
            $this->__set('engine', $value);
        }
    }

    #[Override]
    public function engine(?string $engine = null): self
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    public ?string $charset {
        get => $this->_getNullableString('charset');
        set {
            $this->__set('charset', $value);
        }
    }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    #[Override]
    public function charset(?string $charset = null): self
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     * @todo find a nice way to add and remove keys e.g. by using a method like `add()`, `has()` and `remove()`. Maybe with ArrayOffsets.
     *
     */
    public ?array $keys {
        get => $this->_getNullableArray('keys');
        set {
            $this->__set('keys', $value);
        }
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     *
     * @param null|array<array-key, mixed> $keys
     */
    #[Override]
    public function keys(?array $keys = null): self
    {
        $this->keys = array_replace($this->keys ?? [], $keys ?? []);

        return $this;
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    #[Override]
    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name] ?? null;
    }

    /** @mago-expect analysis:mixed-array-assignment */
    #[Override]
    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name] = $value;
    }

    #[Override]
    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name]);
    }

    /** @mago-expect analysis:mixed-array-access */
    #[Override]
    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['config']['sql'][$name]);
    }

    #[Override]
    protected function _path(string $name): string
    {
        return "\$GLOBALS['TL_DCA']['$this->_table']['config']['sql']['$name']";
    }
}
