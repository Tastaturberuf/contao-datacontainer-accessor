<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;
use PHPUnit\Framework\TestCase;

class CallbackBagTest extends TestCase
{

    public function testCanInstantiate(): void
    {
        $arr = [];

        static::assertInstanceOf(CallbackBag::class, new CallbackBag($arr));
    }

    public function testCanAddCallback(): void
    {
        $arr = [];

        $bag = new CallbackBag($arr);
        $bag[] = fn() => true;
        $bag['sd'] = fn() => true;

        $test = $bag['sd'];

        isset($bag['sd']);

        d($arr);
    }

}
