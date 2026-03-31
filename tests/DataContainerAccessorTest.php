<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Config;
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;
use Tastaturberuf\ContaoDataContainerAccessor\FieldBag;
use Tastaturberuf\ContaoDataContainerAccessor\Listing;
use TypeError;

final class DataContainerAccessorTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertInstanceOf(DataContainerAccessor::class, $dca);
        static::assertInstanceOf(Config::class, $dca->config);
        static::assertInstanceOf(Listing::class, $dca->list);
    }

    public function testConfigProperty(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertInstanceOf(Config::class, $dca->config);

        // make sure it the same reference every time
        static::assertSame($dca->config, $dca->config);

        $this->expectException(TypeError::class);
        $dca->config = new Config('tl_test_2');
    }

    public function testConfigMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->config(static function (Config $config, string $table) use ($dca): void {
            static::assertInstanceOf(Config::class, $config);
            static::assertSame('tl_test', $table);
            static::assertSame($config, $dca->config);
        });

        static::assertSame($dca, $returned);
    }

    public function testListMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->listing(static function ($listing, $table): void {
            static::assertInstanceOf(Listing::class, $listing);
            static::assertSame('tl_test', $table);
        });

        static::assertSame($dca, $returned);
    }

    public function testFieldMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->field(static function ($fields, $table): void {
            static::assertInstanceOf(FieldBag::class, $fields);
            static::assertSame('tl_test', $table);
        });

        static::assertSame($dca, $returned);
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

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    #[DataProvider('dataProviderInt')]
    #[DataProvider('dataProviderString')]
    public function testDynamicCall(mixed $value): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->value($value);

        static::assertSame($dca, $returned);
        static::assertSame($value, $dca->get('value'));
        static::assertArrayHasKey('value', $GLOBALS['TL_DCA']['tl_test']);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['value']);
    }

    public function testFieldBagIsImmutable(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $this->expectException(\Error::class);
        $dca->fields = new FieldBag('tl_test');
    }
}
