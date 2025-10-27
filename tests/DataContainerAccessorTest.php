<?php

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;
use Tastaturberuf\ContaoDataContainerAccessor\FieldBag;
use Tastaturberuf\ContaoDataContainerAccessor\Listing;

class DataContainerAccessorTest extends TestCase
{

    public function testCanInstantiate(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertInstanceOf(DataContainerAccessor::class, $dca);
        static::assertInstanceOf(Config::class, $dca->config);
        static::assertInstanceOf(Listing::class, $dca->list);
    }

    public function testConfigMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->config(static function ($config, $table): void {
            self::assertInstanceOf(Config::class, $config);
            self::assertSame('tl_test', $table);
        });

        self::assertSame($dca, $returned);
    }

    public function testListMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->listing(static function ($listing, $table): void {
            self::assertInstanceOf(Listing::class, $listing);
            self::assertSame('tl_test', $table);
        });

        self::assertSame($dca, $returned);
    }

    public function testFieldsMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->fields(static function ($fields, $table): void {
            self::assertInstanceOf(FieldBag::class, $fields);
            self::assertSame('tl_test', $table);
        });

        self::assertSame($dca, $returned);
    }

    public function testDynamicProperties(): void
    {
        $dca = new DataContainerAccessor('tl_test');
        $dca->newProperty = 'test';

        static::assertSame('test', $dca->newProperty);
        static::assertSame('test', $GLOBALS['TL_DCA']['tl_test']['newProperty']);
    }

    public function testConfigSyntaxCallback(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        function myCallback(Config $config): void
        {
            $config->ptable = 'tl_parent';
        }

        $dca->config(myCallback(...));

        static::assertSame('tl_parent', $dca->config->ptable);
    }

}
