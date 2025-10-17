<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;

class CallbackBagTest extends TestCase
{

    public function testCanInstantiate(): void
    {
        $arr = [];
        $bag = new CallbackBag($arr);

        static::assertInstanceOf(CallbackBag::class, $bag);
    }

    public function testAllMethod(): void
    {
        $arr = ['A', 'B', 'C'];

        $bag = new CallbackBag($arr);

        self::assertSame($arr, $bag->all());
    }

    public function testAddCallbackAtLastPosition(): void
    {
        $arr = [fn() => false];
        $bag = new CallbackBag($arr);

        self::assertCount(1, $arr);

        $callback = fn() => true;

        $bag->add($callback);

        self::assertCount(2, $arr);
        self::assertSame($arr[1], $callback);
    }

    public function testAddCallbackAtFirstPosition(): void
    {
        $arr = [fn() => false];
        $bag = new CallbackBag($arr);

        self::assertCount(1, $arr);

        $callback = fn() => true;

        $bag->add($callback, 0);

        self::assertCount(2, $arr);
        self::assertSame($arr[0], $callback);
    }

    public function testCanAddCallbackAtSpecificPosition(): void
    {
        $arr = [fn() => false, fn() => false];
        $bag = new CallbackBag($arr);

        self::assertCount(2, $arr);

        $callback = fn() => true;

        $bag->add($callback, 1);

        self::assertCount(3, $arr);
        self::assertSame($arr[1], $callback);
    }

    public function testGetCallback(): void
    {
        $callback = fn() => true;

        $arr = [fn() => false, $callback, fn() => false];
        $bag = new CallbackBag($arr);

        self::assertCount(3, $arr);
        self::assertSame($callback, $bag->get(1));
        self::assertNull($bag->get(99));
    }

    public function testRemoveCallback(): void
    {
        $callback = fn() => true;
        $arr = [fn() => false, $callback, fn() => false];
        $bag = new CallbackBag($arr);

        self::assertCount(3, $arr);

        $returned = $bag->remove(1);

        self::assertSame($bag, $returned);
        self::assertCount(2, $arr);

        self::assertSame($bag, $bag->remove(99));
        self::assertCount(2, $arr);
    }

}
