<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Config;

use Closure;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\AbstractAccessor;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\Config\SqlInterface;
use function array_replace;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 * @mago-expect analysis:incompatible-property-access
 * @mago-expect analysis:incompatible-readonly-modifier
 */
final class Sql extends AbstractAccessor implements SqlInterface
{
    public readonly string $_table;
    public readonly array $_path;
    protected array $_ref;

    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public ?string $engine {
        get => $this->getNullableString('engine');
        set {
            $this->_ref['engine'] = $value;
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
            $this->_ref['charset'] = $value;
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

            $this->keys ??= new Keys($this->_table);

            if ($value instanceof Closure) {
                $this->keys->__invoke($value);
                return;
            }

            $this->_ref['keys'] = $value;
        }
    }

    /**
     * Allows you to define primary keys and indexes for your fields.
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     * @todo fix this
     *
     * @param null|array<array-key, mixed> $keys
     */
    public function keys(?array $keys = null): self
    {
        $this->keys = array_replace($this->keys ?? [], $keys ?? []);

        return $this;
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect analysis:mixed-property-type-coercion
     * @mago-expect lint:no-global
     */
    public function __construct(string $table)
    {
        $GLOBALS['TL_DCA'][$table]['config']['sql'] ??= [];

        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'config', 'sql'];
        $this->_ref = &$GLOBALS['TL_DCA'][$table]['config']['sql'];
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
}
