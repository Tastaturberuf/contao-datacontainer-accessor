<?php

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\ConfigSql;

#[RunTestsInSeparateProcesses]
class ConfigTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        static::assertInstanceOf(Config::class, new Config('tl_test'));
    }

    public function testStandaloneSyntax(): void
    {
        $config = new Config('tl_test');
        $config->ptable = 'tl_parent';

        static::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    public function testForSyntax(): void
    {
        Config::for('tl_test')->ptable = 'tl_parent';

        static::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    public function testUnset(): void
    {
        $config = new Config('tl_test');
        $config->ptable = 'tl_parent';

        static::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);

        $config->__unset('ptable');

        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    public function testDefaultValues(): void
    {
        $arr = [];

        static::assertEquals([
            'label' => null,
            'ptable' => null,
            'dynamicPtable' => false,
            'ctable' => null,
            'dataContainer' => '',
            'markAsCopy' => null,
            'uploadPath' => null,
            'validFileTypes' => null,
            'editableFileTypes' => null,
            'databaseAssisted' => false,
            'closed' => false,
            'notEditable' => false,
            'notDeletable' => false,
            'notSortable' => false,
            'notCopyable' => false,
            'notCreatable' => false,
            'switchToEdit' => false,
            'enableVersioning' => false,
            'doNotCopyRecords' => false,
            'doNotDeleteRecords' => false,
            'backlink' => null,
            'oncreate_callback' => new CallbackBag($arr),
            'onload_callback' => new CallbackBag($arr),
            'onbeforesubmit_callback' => new CallbackBag($arr),
            'onsubmit_callback' => new CallbackBag($arr),
            'ondelete_callback' => new CallbackBag($arr),
            'oncut_callback' => new CallbackBag($arr),
            'oncopy_callback' => new CallbackBag($arr),
            'onundo_callback' => new CallbackBag($arr),
            'onversion_callback' => new CallbackBag($arr),
            'onrestore_callback' => new CallbackBag($arr),
            'onrestore_version_callback' => new CallbackBag($arr),
            'sql' => new ConfigSql('tl_test')
        ], get_object_vars(new Config('tl_test')));
    }

    public function testCallbacks(): void
    {
        $callback = static fn() => true;

        $config = new Config('tl_test');
        $config->onrestore_callback[] = $callback;

        static::assertSame($callback, $config->onrestore_callback[0]);
    }

    public function testDynamicProperties(): void
    {
        $config = new Config('tl_test');

        $config->dynamicProperty = 'value';

        static::assertSame('value', $config->dynamicProperty);
        static::assertSame('value', $GLOBALS['TL_DCA']['tl_test']['config']['dynamicProperty']);

        // make sure this is only a "virtual" property and not set on the object directly
        static::assertObjectNotHasProperty('dynamicProperty', $config);
    }

    public function testUnsetDynamicProperty(): void
    {
        $config = new Config('tl_test');

        $config->dynamicProperty = 'value';

        static::assertSame('value', $config->dynamicProperty);

        unset($config->dynamicProperty);

        static::assertNull($config->dynamicProperty);
        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['dynamicProperty'] ?? null);
    }

    public function testUnsetVirtualPropertyHooks(): void
    {
        $config = new Config('tl_test');
        $config->ptable = 'tl_parent';

        static::assertSame('tl_parent', $config->ptable);
        static::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);

        $config->unset('ptable');

        static::assertNull($config->ptable);
        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['ptable'] ?? null);
    }

}
