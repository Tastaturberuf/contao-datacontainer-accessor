<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Contracts;

/**
 * @internal
 */
interface ConfigSqlPropertyInterface
{
    public ?string $engine { get; set; }
    public ?string $charset { get; set; }
    public ?array $keys { get; set; }

}
