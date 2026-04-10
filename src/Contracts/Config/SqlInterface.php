<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Contracts\Config;

use Closure;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Keys;

/**
 * @api
 *
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 */
interface SqlInterface
{
    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public ?string $engine { get; set; }

    /**
     * Allows you to define the character set for this table different to the default.
     */
    public ?string $charset { get; set; }

    /**
     * Allows you to define primary keys and indexes for your fields.
     *
     * @see https://docs.contao.org/dev/reference/dca/config/#sql-keys-and-indexes
     *
     */
    public Keys $keys { get; set(null|array|Keys|Closure $value); }
}
