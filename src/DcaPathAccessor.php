<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use RuntimeException;

final readonly class DcaPathAccessor
{
    /**
     * @throws RuntimeException
     */
    private function __construct()
    {
        throw new RuntimeException('DcaPathAccessor is only statically implemented');
    }

    /**
     * @mago-expect lint:no-global
     * @mago-expect lint:no-isset
     * @mago-expect analysis:mixed-assignment
     */
    public static function get(string ...$path): mixed
    {
        if (!isset($GLOBALS['TL_DCA'])) {
            return null;
        }

        $cursor = $GLOBALS['TL_DCA'];

        foreach ($path as $segment) {
            if (!isset($cursor[$segment])) {
                return null;
            }

            $cursor = $cursor[$segment];
        }

        return $cursor;
    }

    /**
     * @mago-expect lint:no-global
     * @mago-expect lint:no-isset
     * @mago-expect analysis:mixed-assignment
     * @mago-expect analysis:mixed-array-assignment
     */
    public static function set(mixed $value, string ...$path): void
    {
        if ([] === $path) {
            return;
        }

        $lastSegment = array_pop($path);
        $cursor = &$GLOBALS['TL_DCA'];

        foreach ($path as $segment) {
            if (!isset($cursor[$segment]) || !is_array($cursor[$segment])) {
                $cursor[$segment] = [];
            }

            $cursor = &$cursor[$segment];
        }

        $cursor[$lastSegment] = $value;
    }
}
