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

        static::assertSame($arr, $bag->all());
    }

    public function testAddCallbackAtLastPosition(): void
    {
        $arr = [fn() => false];
        $bag = new CallbackBag($arr);

        static::assertCount(1, $arr);

        $callback = fn() => true;

        $bag->add($callback);

        static::assertCount(2, $arr);
        static::assertSame($arr[1], $callback);
    }

    public function testAddCallbackAtFirstPosition(): void
    {
        $arr = [fn() => false];
        $bag = new CallbackBag($arr);

        static::assertCount(1, $arr);

        $callback = fn() => true;

        $bag->add($callback, 0);

        static::assertCount(2, $arr);
        static::assertSame($arr[0], $callback);
    }

    public function testCanAddCallbackAtSpecificPosition(): void
    {
        $arr = [fn() => false, fn() => false];
        $bag = new CallbackBag($arr);

        static::assertCount(2, $arr);

        $callback = fn() => true;

        $bag->add($callback, 1);

        static::assertCount(3, $arr);
        static::assertSame($arr[1], $callback);
    }

    public function testGetCallback(): void
    {
        $callback = fn() => true;

        $arr = [fn() => false, $callback, fn() => false];
        $bag = new CallbackBag($arr);

        static::assertCount(3, $arr);
        static::assertSame($callback, $bag->get(1));
        static::assertNull($bag->get(99));
    }

    public function testRemoveCallback(): void
    {
        $callback = fn() => true;
        $arr = [fn() => false, $callback, fn() => false];
        $bag = new CallbackBag($arr);

        static::assertCount(3, $arr);

        $returned = $bag->remove(1);

        static::assertSame($bag, $returned);
        static::assertCount(2, $arr);

        static::assertSame($bag, $bag->remove(99));
        static::assertCount(2, $arr);
    }
}
