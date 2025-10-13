<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use PHPUnit\Metadata\Covers;
use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\ConfigSql;

#[RunTestsInSeparateProcesses]
class ConfigTest extends TestCase
{
    use AssertPropertyHooksAndMethods;

    public function testCanInstantiate(): void
    {
        $class = new Config('tl_test');

        static::assertInstanceOf(Config::class, $class);
    }

    public function testLabel(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('label', $config);
        $this->assertObjectPropertyHookAcceptString('label', $config);

        $this->assertObjectMethodAcceptNull('label', $config);
        $this->assertObjectMethodAcceptString('label', $config);
    }

    public function testPtable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('ptable', $config);
        $this->assertObjectPropertyHookAcceptString('ptable', $config);

        $this->assertObjectMethodAcceptNull('ptable', $config);
        $this->assertObjectMethodAcceptString('ptable', $config);
    }

    public function testDynamicPtable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('dynamicPtable', $config);
        $this->assertObjectPropertyHookAcceptBool('dynamicPtable', $config);

        $this->assertObjectMethodAcceptBool('dynamicPtable', $config);
        $this->assertObjectMethodDeclineNull('dynamicPtable', $config);
    }

    public function testCtable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('ctable', $config);
        $this->assertObjectPropertyHookAcceptArray('ctable', $config);

        $this->assertObjectMethodAcceptNull('ctable', $config);
        $this->assertObjectMethodAcceptArray('ctable', $config);
    }

    public function testDataContainer(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('dataContainer', $config);
        $this->assertObjectPropertyHookAcceptString('dataContainer', $config);

        $this->assertObjectMethodAcceptNull('dataContainer', $config);
        $this->assertObjectMethodAcceptString('dataContainer', $config);
    }

    public function testMarkAsCopy(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('markAsCopy', $config);
        $this->assertObjectPropertyHookAcceptString('markAsCopy', $config);

        $this->assertObjectMethodAcceptNull('markAsCopy', $config);
        $this->assertObjectMethodAcceptString('markAsCopy', $config);
    }

    public function testUploadPath(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('uploadPath', $config);
        $this->assertObjectPropertyHookAcceptString('uploadPath', $config);

        $this->assertObjectMethodAcceptNull('uploadPath', $config);
        $this->assertObjectMethodAcceptString('uploadPath', $config);
    }

    public function testValidFileTypes(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('validFileTypes', $config);
        $this->assertObjectPropertyHookAcceptString('validFileTypes', $config);
    }

    public function testEditableFileTypes(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('editableFileTypes', $config);
        $this->assertObjectPropertyHookAcceptString('editableFileTypes', $config);

        $this->assertObjectMethodAcceptNull('editableFileTypes', $config);
        $this->assertObjectMethodAcceptString('editableFileTypes', $config);
    }

    public function testDatabaseAssisted(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('databaseAssisted', $config);
        $this->assertObjectPropertyHookAcceptBool('databaseAssisted', $config);

        $this->assertObjectMethodAcceptBool('databaseAssisted', $config);
        $this->assertObjectMethodDeclineNull('databaseAssisted', $config);
    }

    public function testClosed(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('closed', $config);
        $this->assertObjectPropertyHookAcceptBool('closed', $config);

        $this->assertObjectMethodAcceptBool('closed', $config);
        $this->assertObjectMethodDeclineNull('closed', $config);
    }

    public function testNotEditable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('notEditable', $config);
        $this->assertObjectPropertyHookAcceptBool('notEditable', $config);

        $this->assertObjectMethodAcceptBool('notEditable', $config);
        $this->assertObjectMethodDeclineNull('notEditable', $config);
    }

    public function testNotDeletable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('notDeletable', $config);
        $this->assertObjectPropertyHookAcceptBool('notDeletable', $config);

        $this->assertObjectMethodAcceptBool('notDeletable', $config);
        $this->assertObjectMethodDeclineNull('notDeletable', $config);
    }

    public function testNotSortable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('notSortable', $config);
        $this->assertObjectPropertyHookAcceptBool('notSortable', $config);

        $this->assertObjectMethodAcceptBool('notSortable', $config);
        $this->assertObjectMethodDeclineNull('notSortable', $config);
    }

    public function testNotCopyable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('notCopyable', $config);
        $this->assertObjectPropertyHookAcceptBool('notCopyable', $config);

        $this->assertObjectMethodAcceptBool('notCopyable', $config);
        $this->assertObjectMethodDeclineNull('notCopyable', $config);
    }

    public function testNotCreatable(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('notCreatable', $config);
        $this->assertObjectPropertyHookAcceptBool('notCreatable', $config);

        $this->assertObjectMethodAcceptBool('notCreatable', $config);
        $this->assertObjectMethodDeclineNull('notCreatable', $config);
    }

    public function testSwitchToEdit(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('switchToEdit', $config);
        $this->assertObjectPropertyHookAcceptBool('switchToEdit', $config);

        $this->assertObjectMethodAcceptBool('switchToEdit', $config);
        $this->assertObjectMethodDeclineNull('switchToEdit', $config);
    }

    public function testEnableVersioning(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('enableVersioning', $config);
        $this->assertObjectPropertyHookAcceptBool('enableVersioning', $config);

        $this->assertObjectMethodAcceptBool('enableVersioning', $config);
        $this->assertObjectMethodDeclineNull('enableVersioning', $config);
    }

    public function testDoNotCopyRecords(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('doNotCopyRecords', $config);
        $this->assertObjectPropertyHookAcceptBool('doNotCopyRecords', $config);

        $this->assertObjectMethodAcceptBool('doNotCopyRecords', $config);
        $this->assertObjectMethodDeclineNull('doNotCopyRecords', $config);
    }

    public function testDoNotDeleteRecords(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('doNotDeleteRecords', $config);
        $this->assertObjectPropertyHookAcceptBool('doNotDeleteRecords', $config);

        $this->assertObjectMethodAcceptBool('doNotDeleteRecords', $config);
        $this->assertObjectMethodDeclineNull('doNotDeleteRecords', $config);
    }

    public function testBacklink(): void
    {
        $config = new Config('tl_test');

        $this->assertObjectPropertyHookAcceptNull('backlink', $config);
        $this->assertObjectPropertyHookAcceptString('backlink', $config);

        $this->assertObjectMethodAcceptNull('backlink', $config);
        $this->assertObjectMethodAcceptString('backlink', $config);
    }

    public function testUnset(): void
    {
        $config = new Config('tl_test');
        $config->ptable = 'tl_parent';

        static::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);

        $config->__unset('ptable');

        static::assertArrayNotHasKey('ptable', $GLOBALS['TL_DCA']['tl_test']['config']);
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
        static::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['dynamicProperty']);
        static::assertArrayNotHasKey('dynamicProperty', $GLOBALS['TL_DCA']['tl_test']['config']);

        static::assertObjectNotHasProperty('dynamicProperty', $config);
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
