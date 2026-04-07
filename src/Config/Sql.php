<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Config;

use Closure;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\AbstractAccessor;
use function array_replace;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 * @mago-ignore analysis:incompatible-property-access
 * @mago-ignore analysis:incompatible-readonly-modifier
 */
final class Sql extends AbstractAccessor
{
    public readonly string $_table;
    public readonly array $_path;

    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public ?string $engine {
        get => $this->getNullableString('engine');
        set {
            $this->__set('engine', $value);
        }
    }

    public function engine(?string $engine = null): self
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    public ?string $charset {
        get => $this->getNullableString('charset');
        set {
            $this->__set('charset', $value);
        }
    }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    public function charset(?string $charset = null): self
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     *
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     *
     */
    public Keys $keys {
        get => $this->keys ??= new Keys($this->_table);
        set(null|array|Keys|Closure $value) {
            if ($value instanceof Keys) {
                $this->keys = $value;
                return;
            }
            if ($value instanceof Closure) {
                $value(new Keys($this->_table));
                return;
            }

            $this->__set('keys', $value);
        }
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     *
     * @param null|array<array-key, mixed> $keys
     */
    public function keys(?array $keys = null): self
    {
        $this->keys = array_replace($this->keys ?? [], $keys ?? []);

        return $this;
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'config', 'sql'];
    }

    public static function create(string $table): self
    {
        return new self($table);
    }

    /**
     * @param Closure(Sql $sql, string $table): void $callback
     */
    #[Override]
    public function __invoke(Closure $callback): void
    {
        $callback($this, $this->_table);
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
}
