<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests\Config;

use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Keys;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Sql;
use Tastaturberuf\ContaoDataContainerAccessor\Tests\TestCase;
use TypeError;

/**
 * @mago-expect analysis:mixed-array-access
 * @mago-expect lint:no-global
 */
final class SqlTest extends TestCase
{
    /** @mago-expect analysis:mixed-array-assignment */
    public function testWrongTypeInGlobalArray(): void
    {
        $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine'] = new StdClass();

        $sql = new Sql('tl_test');

        $this->expectException(TypeError::class);

        /** @mago-expect analysis:unused-statement */
        $sql->engine;
    }

    public function testCanInstantiateClass(): void
    {
        $sql = new Sql('tl_test');

        static::assertSame('tl_test', $sql->_table);
    }

    public function testCreateMethod(): void
    {
        $sql = Sql::create('tl_test');

        static::assertInstanceOf(Sql::class, $sql);
    }

    public function testInvokeMethod(): void
    {
        $sql = new Sql('tl_test');

        $sql(static function (Sql $innerSql, string $table) use ($sql): void {
            static::assertSame($sql, $innerSql);
            static::assertSame('tl_test', $table);
        });
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testEngineProperty(?string $value): void
    {
        $sql = new Sql('tl_test');
        $sql->engine = $value;

        static::assertSame($value, $sql->engine);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testEngineMethod(?string $value): void
    {
        $sql = new Sql('tl_test');
        $returned = $sql->engine($value);

        static::assertSame($sql, $returned);
        static::assertSame($value, $sql->engine);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['engine']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testCharsetProperty(?string $value): void
    {
        $sql = new Sql('tl_test');
        $sql->charset = $value;

        static::assertSame($value, $sql->charset);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testCharsetMethod(?string $value): void
    {
        $sql = new Sql('tl_test');
        $returned = $sql->charset($value);

        static::assertSame($sql, $returned);
        static::assertSame($value, $sql->charset);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);
    }

    public function testKeysPropertyIsAlwaysClass(): void
    {
        $sql = new Sql('tl_test');

        static::assertInstanceOf(Keys::class, $sql->keys);
    }

    public function testKeysPropertyWithArray(): void
    {
        $sql = new Sql('tl_test');

        $value = ['id' => 'primary', 'id,pid' => 'index'];

        $sql->keys = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']);
    }

    public function testKeysPropertyWithClosure(): void
    {
        $sql = new Sql('tl_test');

        $value = ['id' => 'primary', 'id,pid' => 'index'];

        $sql->keys = static function (Keys $keys): void {
            $keys->id = 'primary';
            $keys->{'id,pid'} = 'index';
        };

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']);
    }

    public function testKeysPropertyWithNull(): void
    {
        $sql = new Sql('tl_test');

        $sql->keys->id = 'primary';

        static::assertSame('primary', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']['id']);

        $sql->keys = null;

        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['sql']['keys']);
    }
}
