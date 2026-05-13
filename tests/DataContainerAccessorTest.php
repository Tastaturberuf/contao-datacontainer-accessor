<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Error;
use PHPUnit\Framework\Attributes\DataProvider;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\ConfigInterface;
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;
use Tastaturberuf\ContaoDataContainerAccessor\FieldBag;

/**
 * @mago-expect lint:no-global
 */
final class DataContainerAccessorTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertSame('tl_test', $dca->_table);
    }

    public function testCreateMethod(): void
    {
        $dca = DataContainerAccessor::create('tl_test');

        static::assertInstanceOf(DataContainerAccessor::class, $dca);

        $dca2 = DataContainerAccessor::create('tl_test');

        static::assertSame($dca, $dca2);
    }

    public function testConfigProperty(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertInstanceOf(ConfigInterface::class, $dca->config);
        static::assertInstanceOf(Config::class, $dca->config);

        // make sure it the same reference every time
        static::assertSame($dca->config, $dca->config);

        $oldConfig = $dca->config;
        $dca->config = new Config('tl_example');
        static::assertNotSame($oldConfig, $dca->config);
    }

    public function testConfigPropertyWithClosure(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $dca->config = static function (ConfigInterface $config, string $table) use ($dca): void {
            static::assertSame('tl_test', $table);
            static::assertSame($config, $dca->config);
        };
    }

    public function testConfigPropertyWithNewClass(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $newConfig = new class('tl_test') extends Config {
            public function __construct(string $table)
            {
                parent::__construct($table);
                $this->enableVersioning = true;
            }
        };

        $dca->config = $newConfig;

        static::assertSame($newConfig, $dca->config);
        static::assertTrue($dca->config->enableVersioning);
        static::assertTrue($GLOBALS['TL_DCA']['tl_test']['config']['enableVersioning'] ?? false);
    }

    public function testConfigMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->config(static function (ConfigInterface $config, string $table) use ($dca): void {
            static::assertSame('tl_test', $table);
            static::assertSame($config, $dca->config);
        });

        static::assertSame($dca, $returned);
    }

    public function testFieldsProperty(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertInstanceOf(FieldBag::class, $dca->fields);
        static::assertSame($dca->fields, $dca->fields);
    }

    public function testFieldsMethod(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->fields(static function ($fields, $table): void {
            static::assertInstanceOf(\Generator::class, $fields);
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
        static::assertSame($value, $dca->__get('value'));
        static::assertArrayHasKey('value', $GLOBALS['TL_DCA']['tl_test']);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['value']);
    }

    public function testFieldBagIsImmutable(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $this->expectException(Error::class);
        $dca->fields = new FieldBag('tl_test');
    }

    public function testAddCallback(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $returned = $dca->addCallback(LabelCallback::Group, fn() => true);

        static::assertSame($dca, $returned);
    }
}
