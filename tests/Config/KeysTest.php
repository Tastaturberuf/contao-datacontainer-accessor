<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests\Config;

use Tastaturberuf\ContaoDataContainerAccessor\Config\Keys;
use Tastaturberuf\ContaoDataContainerAccessor\Tests\TestCase;

/**
 * @mago-expect analysis:mixed-array-access
 * @mago-expect lint:no-global
 */
final class KeysTest extends TestCase
{
    public function testCanInstantiateClass(): void
    {
        $keys = new Keys('tl_test');

        static::assertSame('tl_test', $keys->_table);
        static::assertSame(['TL_DCA', 'tl_test', 'config', 'sql', 'keys'], $keys->_path);
    }

    public function testCreateMethod(): void
    {
        $keys = Keys::create('tl_test');

        static::assertInstanceOf(Keys::class, $keys);
    }

    public function testSetterGetter(): void
    {
        $keys = new Keys('tl_test');

        $keys->id = 'primary';

        static::assertSame('primary', $keys->id);
        static::assertSame('primary', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']['id']);
    }

    /** @mago-expect analysis:non-documented-property */
    public function testSetterGetterWithCommaNotion(): void
    {
        $keys = new Keys('tl_test');

        $keys->{'pid,tstamp'} = 'unique';

        static::assertSame('unique', $keys->{'pid,tstamp'});
        static::assertSame('unique', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']['pid,tstamp']);
    }

    public function testGetterWithNull(): void
    {
        $keys = new Keys('tl_test');

        $value = $keys->__get('tstamp');

        static::assertNull($value);
    }

    /** @mago-expect lint:no-isset */
    public function testIsset(): void
    {
        $keys = new Keys('tl_test');

        $keys->id = 'primary';

        static::assertTrue(isset($keys->id));
        static::assertTrue($keys->__isset('id'));
        static::assertSame('primary', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']['id']);
    }

    /** @mago-expect analysis:mixed-argument */
    public function testUnset(): void
    {
        $keys = new Keys('tl_test');

        $keys->id = 'primary';

        static::assertSame('primary', $keys->id);

        unset($keys->id);

        static::assertNull($keys->id);
        static::assertArrayNotHasKey('id', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']);
    }
}
