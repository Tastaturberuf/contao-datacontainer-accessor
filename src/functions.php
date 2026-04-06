<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;

function ref(mixed &$value): Closure
{
    return static function &() use (&$value): mixed {
        return $value;
    };
}
