<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Exception;

use TypeError;

final class AccessorTypeError extends TypeError
{
    private function __construct(
        public readonly string $path,
        public readonly string $expected,
        public readonly string $actualType,
    ) {
        parent::__construct(sprintf('Invalid type at %s: expected %s, got %s.', $path, $expected, $actualType));
    }

    /**
     * @throws TypeError
     */
    public static function for(array $path, string $expected, mixed $actual): self
    {
        return new self(static::generateGlobalArrayString($path), $expected, get_debug_type($actual));
    }

    private static function generateGlobalArrayString(array $path): string
    {
        return '$GLOBALS[\'' . implode('\'][\'', $path) . '\']';
    }
}
