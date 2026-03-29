<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use stdClass;
use Tastaturberuf\ContaoDataContainerAccessor\ConfigSql;
use TypeError;

class ConfigSqlTest extends TestCase
{
    /** @mago-ignore analysis:mixed-array-assignment */
    public function testWrongTypeInGlobalArray(): void
    {
        $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine'] = new StdClass();

        $sql = new ConfigSql('tl_test');

        $this->expectException(TypeError::class);

        /** @mago-ignore analysis:unused-statement */
        $sql->engine;
    }

    public function testCanInstantiateClass(): void
    {
        $sql = new ConfigSql('tl_test');
        static::assertInstanceOf(ConfigSql::class, $sql);
    }

    public function testEnginePropertyHookSetsAndReadsFromGlobals(): void
    {
        $sql = new ConfigSql('tl_test');
        $sql->engine = 'InnoDB';

        static::assertSame('InnoDB', $sql->engine);
        static::assertSame('InnoDB', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine']);
        static::assertTrue($sql->__isset('engine'));
        static::assertTrue(isset($sql->engine));
    }

    public function testEngineMethodIsChainableAndSetsGlobals(): void
    {
        $sql = new ConfigSql('tl_test');
        $returned = $sql->engine('MyISAM');

        static::assertSame($sql, $returned);
        static::assertSame('MyISAM', $sql->engine);
        static::assertSame('MyISAM', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine']);
    }

    public function testEngineAllowsNullAndUnsetsIsset(): void
    {
        $sql = new ConfigSql('tl_test');
        $sql->engine = null;

        static::assertNull($sql->engine);
        static::assertArrayHasKey('engine', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine']);
        static::assertFalse($sql->__isset('engine'));
        static::assertFalse(isset($sql->engine));
    }

    public function testEngineInvalidTypeThrowsTypeError(): void
    {
        $sql = new ConfigSql('tl_test');

        $this->expectException(TypeError::class);
        // property hook enforces ?string, so assigning an int should fail
        $invalid = self::mixed(123);
        $sql->engine = $invalid;
    }

    public function testCharsetPropertyHookSetsAndReadsFromGlobals(): void
    {
        $sql = new ConfigSql('tl_test');
        $sql->charset = 'utf8mb4';

        static::assertSame('utf8mb4', $sql->charset);
        static::assertSame('utf8mb4', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);
        static::assertTrue($sql->__isset('charset'));
        static::assertTrue(isset($sql->charset));
    }

    public function testCharsetMethodIsChainableAndSetsGlobals(): void
    {
        $sql = new ConfigSql('tl_test');
        $returned = $sql->charset('latin1');

        static::assertSame($sql, $returned);
        static::assertSame('latin1', $sql->charset);
        static::assertSame('latin1', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);
    }

    public function testCharsetAllowsNullAndUnsetsIsset(): void
    {
        $sql = new ConfigSql('tl_test');
        $sql->charset = null;

        static::assertNull($sql->charset);
        static::assertArrayHasKey('charset', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);
        static::assertFalse($sql->__isset('charset'));
        static::assertFalse(isset($sql->charset));
    }

    public function testCharsetInvalidTypeThrowsTypeError(): void
    {
        $sql = new ConfigSql('tl_test');

        $this->expectException(TypeError::class);
        $invalid = self::mixed(42.0);
        $sql->charset = $invalid;
    }

    public function testKeysDefaultIsNullAndNotSetInGlobals(): void
    {
        $sql = new ConfigSql('tl_test');

        static::assertNull($sql->keys);
        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys'] ?? null);
        static::assertFalse($sql->__isset('keys'));
        static::assertFalse(isset($sql->keys));
    }

    public function testKeysPropertyHookSetsArrayAndIsset(): void
    {
        $sql = new ConfigSql('tl_test');
        $keys = [
            'PRIMARY' => 'id',
            'idx_name' => 'name',
        ];
        $sql->keys = $keys;

        static::assertSame($keys, $sql->keys);
        static::assertSame($keys, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']);
        static::assertTrue($sql->__isset('keys'));
        static::assertTrue(isset($sql->keys));
    }

    public function testKeysSetArrayOffsetsThrowsError(): void
    {
        $sql = new ConfigSql('tl_test');

        $this->expectException(\Error::class);
        /** @phpstan-ignore-next-line */
        $sql->keys['PRIMARY'] = 'id';
    }

    public function testKeysArrayOffsetsAreAccessible(): void
    {
        $sql = new ConfigSql('tl_test');
        $keys = [
            'PRIMARY' => 'id',
            'idx_name' => 'name',
        ];
        $sql->keys = $keys;

        static::assertSame($keys, $sql->keys);
        static::assertSame($sql->keys['PRIMARY'], $keys['PRIMARY']);
        static::assertSame($sql->keys['idx_name'], $keys['idx_name']);
        static::assertSame($sql->keys['PRIMARY'], $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']['PRIMARY']);
        static::assertSame($sql->keys['idx_name'], $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']['idx_name']);
    }

    public function testKeysMethodIsChainableAndSetsGlobals(): void
    {
        $sql = new ConfigSql('tl_test');
        $keys = ['PRIMARY' => 'id'];
        $returned = $sql->keys($keys);

        static::assertSame($sql, $returned);
        static::assertSame($keys, $sql->keys);
        static::assertSame($keys, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']);
    }

    public function testKeysInvalidTypeThrowsTypeError(): void
    {
        $sql = new ConfigSql('tl_test');

        $this->expectException(TypeError::class);
        $sql->keys = self::mixed('not-an-array');
    }

    public function testMagicGetSetIssetAndUnsetWorkAndAffectGlobals(): void
    {
        $sql = new ConfigSql('tl_test');

        $sql->__set('custom', 'value');
        static::assertTrue($sql->__isset('custom'));
        static::assertSame('value', $sql->__get('custom'));
        static::assertSame('value', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['custom']);

        $sql->__unset('custom');
        static::assertFalse($sql->__isset('custom'));
        static::assertNull($sql->__get('custom'));
        static::assertArrayNotHasKey('custom', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
    }

    public function testDynamicPropertyAccessUsesMagicAndAffectsGlobals(): void
    {
        $sql = new ConfigSql('tl_test');

        $sql->comment = 'table comment';
        static::assertSame('table comment', $sql->comment);
        static::assertSame('table comment', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['comment']);

        unset($sql->comment);
        static::assertNull($sql->comment);
        static::assertArrayNotHasKey('comment', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
    }

    public function testPropertyHooksUnsetThrowsError(): void
    {
        $sql = new ConfigSql('tl_test');

        $sql->charset = 'utf8mb4';
        static::assertSame('utf8mb4', $sql->charset);
        static::assertSame('utf8mb4', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);

        $this->expectException(\Error::class);
        unset($sql->charset);
    }

    public function testUnsetFromBaseClass(): void
    {
        $sql = new ConfigSql('tl_test');

        $sql->engine = 'InnoDB';

        static::assertSame('InnoDB', $sql->engine);
        static::assertSame('InnoDB', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine']);

        $sql->unset('engine');

        static::assertNull($sql->engine);
        static::assertArrayNotHasKey('engine', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
    }

    public function testFluentSetAndUnsetFromBaseClass(): void
    {
        $sql = new ConfigSql('tl_test');
        $returned = $sql->set('foo', 'bar')->set('bar', 'baz');

        static::assertSame($sql, $returned);
        static::assertSame('bar', $sql->__get('foo'));
        static::assertSame('bar', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['foo']);
        static::assertSame('baz', $sql->__get('bar'));
        static::assertSame('baz', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['bar']);

        $returned = $sql->unset('foo')->unset('bar');

        static::assertSame($sql, $returned);
        static::assertNull($sql->__get('foo'));
        static::assertArrayNotHasKey('foo', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
        static::assertNull($sql->__get('bar'));
        static::assertArrayNotHasKey('bar', $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
    }

    private static function mixed(mixed $v): mixed
    {
        return $v;
    }
}
