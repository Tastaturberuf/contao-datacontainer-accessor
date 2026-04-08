<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Override;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use const PHP_INT_MAX;

/**
 * @internal
 */
abstract class TestCase extends PhpUnitTestCase
{
    #[Override]
    protected function setUp(): void
    {
        unset($GLOBALS['TL_DCA']);
    }

    public static function dataProviderNull(): array
    {
        return [
            'null' => [null],
        ];
    }

    public static function dataProviderBool(): array
    {
        return [
            'true' => [true],
            'false' => [false],
        ];
    }

    public static function dataProviderInt(): array
    {
        return [
            'integer 0' => [0],
            'positive integer' => [1],
            'negative integer' => [-1],
            'max integer' => [PHP_INT_MAX],
            'min integer' => [PHP_INT_MIN],
        ];
    }

    public static function dataProviderString(): array
    {
        return [
            'empty string' => [''],
            'empty string with spaces' => ['   '],
            'string' => ['string'],
            'string multiple words' => ['lorem ipsum dolor sit amet'],
        ];
    }

    public static function dataProviderArray(): array
    {
        return [
            'empty array' => [[]],
            'single list array' => [['value']],
            'list array' => [['value1', 'value2']],
            'single associative array' => [['key' => 'value']],
            'associative array' => [['key1' => 'value1', 'key2' => 'value2']],
            'multidimensional array' => [['key' => ['value']]],
        ];
    }

    public static function dataProviderObject(): array
    {
        return [
            'object stdClass' => [new \stdClass()],
            'object DateTime' => [new \DateTime()],
        ];
    }

    public static function dataProviderResource(): array
    {
        return [
            'resource' => [fopen('php://memory', 'rb')],
        ];
    }

    /** @mago-expect lint:prefer-static-closure */
    public static function dataProviderCallable(): array
    {
        return [
            'closure' => [fn(): true => true],
            'static closure' => [static fn(): true => true],
            'first class callable' => [strlen(...)],
            'instance callable' => [new class {
                public function __invoke(): bool
                {
                    return true;
                }
            }],
        ];
    }

    public static function dataProviderClosure(): iterable
    {
        yield 'closure' => [static fn(): true => true];
    }
}
