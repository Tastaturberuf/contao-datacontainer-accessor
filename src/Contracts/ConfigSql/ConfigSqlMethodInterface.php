<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Contracts\ConfigSql;

/**
 * @internal
 */
interface ConfigSqlMethodInterface
{
    /**
     * Allows you to define the storage engine for this table different to the default.
     */
    public function engine(?string $engine = null): self;

    public function charset(?string $charset = null): self;

    public function keys(?array $keys = null): self;
}
