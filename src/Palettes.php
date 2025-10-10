<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class Palettes
{
    use HasCustomProperties;

    public function __construct(private readonly string $table)
    {
    }

    protected function &getDcaPath(): array
    {
        // TODO: Implement getDcaPath() method.
    }
}
