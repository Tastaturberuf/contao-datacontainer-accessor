<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Tastaturberuf\ContaoDataContainerAccessor\DynamicPropertiesInterface;

trait AssertPropertyHooksAndMethods
{

    private function assertObjectPropertyHookAcceptNull(string $property, DynamicPropertiesInterface $object): void
    {
        static::assertObjectHasProperty($property, $object);

        $object->{$property} = null;

        static::assertNull($object->{$property});
        static::assertNull($object->__get($property));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectPropertyDeclineNull(string $property, object $object): void
    {
        static::assertObjectHasProperty($property, $object);

        $this->expectException(\TypeError::class);
        $object->{$property} = null;
    }

    private function assertObjectMethodAcceptNull(string $method, DynamicPropertiesInterface $object): void
    {
        static::assertTrue(method_exists($object, $method));

        $returned = $object->{$method}(null);

        static::assertSame($object, $returned);

        static::assertNull($object->{$method});
        static::assertNull($object->__get($method));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectMethodDeclineNull(string $method, object $object): void
    {
        static::assertTrue(method_exists($object, $method));

        $this->expectException(\TypeError::class);
        $object->{$method}(null);
    }

    private function assertObjectPropertyHookAcceptBool(string $property, DynamicPropertiesInterface $object): void
    {
        static::assertObjectHasProperty($property, $object);

        $object->{$property} = true;

        static::assertTrue($object->{$property});
        static::assertTrue($object->__get($property));

        unset($GLOBALS['TL_DCA']);

        $object->{$property} = false;

        static::assertFalse($object->{$property});
        static::assertFalse($object->__get($property));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectMethodAcceptBool(string $method, DynamicPropertiesInterface $object): void
    {
        static::assertTrue(method_exists($object, $method));

        $retuned = $object->{$method}(true);

        static::assertSame($object, $retuned);

        static::assertTrue($object->{$method});
        static::assertTrue($object->__get($method));

        unset($GLOBALS['TL_DCA']);

        $object->{$method}(false);
        static::assertFalse($object->{$method});
        static::assertFalse($object->__get($method));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectPropertyHooksAcceptInt(string $property, DynamicPropertiesInterface $object): void
    {
        static::assertObjectHasProperty($property, $object);

        $object->{$property} = 0;

        static::assertSame(0, $object->{$property});
        static::assertSame(0, $object->__get($property));

        unset($GLOBALS['TL_DCA']);

        $object->{$property} = 1;

        static::assertSame(1, $object->{$property});
        static::assertSame(1, $object->__get($property));

        unset($GLOBALS['TL_DCA']);

        $object->{$property} = -1;
        static::assertSame(-1, $object->{$property});
        static::assertSame(-1, $object->__get($property));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectMethodAcceptInt(string $method, DynamicPropertiesInterface $object): void
    {
        static::assertTrue(method_exists($object, $method));

        $retuned = $object->{$method}(0);

        static::assertSame($object, $retuned);

        static::assertSame(0, $object->{$method});
        static::assertSame(0, $object->__get($method));

        unset($GLOBALS['TL_DCA']);

        $object->{$method}(1);

        static::assertSame(1, $object->{$method});
        static::assertSame(1, $object->__get($method));

        unset($GLOBALS['TL_DCA']);

        $object->{$method}(-1);

        static::assertSame(-1, $object->{$method});
        static::assertSame(-1, $object->__get($method));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectPropertyHookAcceptString(string $property, DynamicPropertiesInterface $object): void
    {
        static::assertObjectHasProperty($property, $object);

        $object->{$property} = 'Test';

        static::assertSame('Test', $object->{$property});
        static::assertSame('Test', $object->__get($property));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectMethodAcceptString(string $method, DynamicPropertiesInterface $object): void
    {
        static::assertTrue(method_exists($object, $method));

        $retuned = $object->{$method}('Test');

        static::assertSame($object, $retuned);

        static::assertSame('Test', $object->__get($method));
        static::assertSame('Test', $object->__get($method));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectPropertyHookAcceptArray(string $property, DynamicPropertiesInterface $object): void
    {
        static::assertObjectHasProperty($property, $object);

        $object->{$property} = ['Test'];

        static::assertSame(['Test'], $object->{$property});
        static::assertSame(['Test'], $object->__get($property));

        unset($GLOBALS['TL_DCA']);

        $object->{$property} = ['key' => 'Test'];

        static::assertSame(['key' => 'Test'], $object->{$property});
        static::assertSame(['key' => 'Test'], $object->__get($property));

        unset($GLOBALS['TL_DCA']);
    }

    private function assertObjectMethodAcceptArray(string $method, DynamicPropertiesInterface $object): void
    {
        static::assertTrue(method_exists($object, $method));

        $retuned = $object->{$method}(['Test']);

        static::assertSame($object, $retuned);

        static::assertSame(['Test'], $object->{$method});
        static::assertSame(['Test'], $object->__get($method));

        unset($GLOBALS['TL_DCA']);

        $object->{$method}(['key' => 'Test']);

        static::assertSame(['key' => 'Test'], $object->{$method});
        static::assertSame(['key' => 'Test'], $object->__get($method));

        unset($GLOBALS['TL_DCA']);
    }

}
