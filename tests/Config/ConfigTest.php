<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests\Config;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Sql;
use Tastaturberuf\ContaoDataContainerAccessor\Tests\TestCase;
use TypeError;
use function Tastaturberuf\ContaoDataContainerAccessor\ref;

/**
 * @mago-expect analysis:mixed-array-access
 * @mago-expect analysis:mixed-array-assignment
 * @mago-expect analysis:mixed-argument
 * @mago-expect lint:no-global
 */
final class ConfigTest extends TestCase
{
    public function testConstructor(): void
    {
        $config = new Config(table: 'tl_test');

        static::assertSame('tl_test', $config->_table);
    }

    public function testCreateMethod(): void
    {
        $config = Config::create('tl_test');

        static::assertInstanceOf(Config::class, $config);
    }

    public function testInvokeMethod(): void
    {
        $config = new Config('tl_test');

        $config(static function (Config $innerConfig, string $table) use ($config): void {
            static::assertSame($config, $innerConfig);
            static::assertSame('tl_test', $table);
        });
    }

    public function testInvalidSetterMethod(): void
    {
        $GLOBALS['TL_DCA']['tl_test']['config'] = new StdClass();

        $this->expectException(TypeError::class);
        $config = new Config('tl_test');
    }

    public function testOneLineSetWithCreate(): void
    {
        Config::create('tl_test')->enableVersioning = false;

        static::assertFalse($GLOBALS['TL_DCA']['tl_test']['config']['enableVersioning']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testLabelProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertPropertyIsVirtual($config, 'label');

        // test default value
        static::assertNull($config->label);
        // test the key was not initialized
        static::assertArrayNotHasKey('label', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->label = $value;

        static::assertSame($value, $config->label);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['label']);
    }

    public function testLabelPropertyWithRefHelper(): void
    {
        $config = new Config('tl_test');

        $GLOBALS['TL_LANG']['tl_test']['config']['label'] = 'initial';
        $config->label = ref($GLOBALS['TL_LANG']['tl_test']['config']['label']);

        static::assertSame('initial', $GLOBALS['TL_DCA']['tl_test']['config']['label']);

        $GLOBALS['TL_LANG']['tl_test']['config']['label'] = 'changed';

        /** @mago-expect analysis:impossible-type-comparison */
        static::assertSame('changed', $GLOBALS['TL_DCA']['tl_test']['config']['label']);
        static::assertSame('changed', $config->label);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testLabelMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->label(label: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->label);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['label']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testPtableProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->ptable);
        static::assertArrayNotHasKey('ptable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->ptable = $value;

        static::assertSame($value, $config->ptable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testPtableMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->ptable(table: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->ptable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testDynamicPtableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->dynamicPtable);
        static::assertArrayNotHasKey('dynamicPtable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->dynamicPtable = $value;

        static::assertSame($value, $config->dynamicPtable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicPtable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDynamicPtableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->dynamicPtable(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->dynamicPtable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicPtable']);
    }

    /**
     * @param null|array<string> $value
     */
    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderArray')]
    public function testCtableProperty(?array $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->ctable);
        static::assertArrayNotHasKey('ctable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->ctable = $value;

        static::assertSame($value, $config->ctable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ctable']);
    }

    public function testCtablePropertyMerge(): void
    {
        $config = new Config('tl_test');

        $config->ctable = ['tl_foo', 'tl_bar'];

        static::assertSame(['tl_foo', 'tl_bar'], $config->ctable);

        $config->ctable = array_merge($config->ctable, ['tl_baz']);

        static::assertSame(['tl_foo', 'tl_bar', 'tl_baz'], $config->ctable);

        $config->ctable = [...$config->ctable, 'tl_bam'];

        static::assertSame(['tl_foo', 'tl_bar', 'tl_baz', 'tl_bam'], $config->ctable);
    }

    public function testCtablePropertyWithString(): void
    {
        $config = new Config('tl_test');

        $config->ctable = 'string';

        /** @mago-expect analysis:impossible-type-comparison because we cast string to array in the property hook */
        static::assertSame(['string'], $config->ctable);
        static::assertSame(['string'], $GLOBALS['TL_DCA']['tl_test']['config']['ctable']);
    }

    public function testCtableMethod(): void
    {
        $config = new Config('tl_test');

        $value = ['tl_foo', 'tl_bar', 'tl_baz'];

        $retuned = $config->ctable(table: $value);

        static::assertSame($config, $retuned);
        static::assertSame($value, $config->ctable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ctable']);

        $config->ctable();

        static::assertEmpty($config->ctable);
    }

    public function testCtableMethodMerge(): void
    {
        $config = new Config('tl_test');

        $config->ctable = ['tl_foo'];

        $config->ctable(...array_merge($config->ctable, ['tl_content']));

        static::assertSame(['tl_foo', 'tl_content'], $config->ctable);

        $config->ctable('tl_first', ...$config->ctable);

        static::assertSame(['tl_first', 'tl_foo', 'tl_content'], $config->ctable);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testDataContainerProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->dataContainer);
        static::assertArrayNotHasKey('dataContainer', $GLOBALS['TL_DCA']['tl_test']['config']);

        if ($value === null) {
            $this->expectException(InvalidArgumentException::class);
        }

        $config->dataContainer = $value;

        static::assertSame($value, $config->dataContainer);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dataContainer']);
    }

    #[DataProvider('dataProviderString')]
    public function testDataContainerMethod(string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->dataContainer(class: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->dataContainer);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dataContainer']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testMarkAsCopyProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->markAsCopy);
        static::assertArrayNotHasKey('markAsCopy', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->markAsCopy = $value;

        static::assertSame($value, $config->markAsCopy);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['markAsCopy']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testMarkAsCopyMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->markAsCopy(field: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->markAsCopy);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['markAsCopy']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testUploadPathProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->uploadPath);
        static::assertArrayNotHasKey('uploadPath', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->uploadPath = $value;

        static::assertSame($value, $config->uploadPath);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['uploadPath']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testUploadPathMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->uploadPath(path: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->uploadPath);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['uploadPath']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testValidFileTypesProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->validFileTypes);
        static::assertArrayNotHasKey('validFileTypes', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->validFileTypes = $value;

        static::assertSame($value, $config->validFileTypes);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['validFileTypes']);
    }

    public function testValidFileTypesPropertyCastArrayToString(): void
    {
        $config = new Config('tl_test');

        $config->validFileTypes = ['png', 'gif'];

        /** @mago-expect analysis:impossible-type-comparison */
        static::assertSame('png,gif', $config->validFileTypes);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testValidFileTypesMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->validFileTypes(extensions: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->validFileTypes);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['validFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testEditableFileTypesProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->editableFileTypes);
        static::assertArrayNotHasKey('editableFileTypes', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->editableFileTypes = $value;

        static::assertSame($value, $config->editableFileTypes);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['editableFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testEditableFileTypesMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->editableFileTypes(extensions: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->editableFileTypes);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['editableFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testDatabaseAssistedProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->databaseAssisted);
        static::assertArrayNotHasKey('databaseAssisted', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->databaseAssisted = $value;

        static::assertSame($value, $config->databaseAssisted);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['databaseAssisted']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDatabaseAssistedMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->databaseAssisted(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->databaseAssisted);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['databaseAssisted']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testClosedProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->closed);
        static::assertArrayNotHasKey('closed', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->closed = $value;

        static::assertSame($value, $config->closed);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['closed']);
    }

    #[DataProvider('dataProviderBool')]
    public function testClosedMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->closed(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->closed);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['closed']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testNotEditableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->notEditable);
        static::assertArrayNotHasKey('notEditable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->notEditable = $value;

        static::assertSame($value, $config->notEditable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notEditable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotEditableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notEditable(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->notEditable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notEditable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testNotDeletableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->notDeletable);
        static::assertArrayNotHasKey('notDeletable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->notDeletable = $value;

        static::assertSame($value, $config->notDeletable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notDeletable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotDeletableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notDeletable(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->notDeletable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notDeletable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testNotSortableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->notSortable);
        static::assertArrayNotHasKey('notSortable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->notSortable = $value;

        static::assertSame($value, $config->notSortable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notSortable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotSortableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notSortable(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->notSortable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notSortable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCopyableProperty(bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->notCopyable);
        static::assertArrayNotHasKey('notCopyable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->notCopyable = $value;

        static::assertSame($value, $config->notCopyable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCopyable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCopyableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notCopyable(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->notCopyable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCopyable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCreatableProperty(bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->notCreatable);
        static::assertArrayNotHasKey('notCreatable', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->notCreatable = $value;

        static::assertSame($value, $config->notCreatable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCreatable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCreatableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notCreatable(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->notCreatable);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCreatable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testSwitchToEditProperty(bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->switchToEdit);
        static::assertArrayNotHasKey('switchToEdit', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->switchToEdit = $value;

        static::assertSame($value, $config->switchToEdit);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['switchToEdit']);
    }

    #[DataProvider('dataProviderBool')]
    public function testSwitchToEditMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->switchToEdit(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->switchToEdit);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['switchToEdit']);
    }

    #[DataProvider('dataProviderBool')]
    public function testEnableVersioningProperty(bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->enableVersioning);
        static::assertArrayNotHasKey('enableVersioning', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->enableVersioning = $value;

        static::assertSame($value, $config->enableVersioning);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['enableVersioning']);
    }

    #[DataProvider('dataProviderBool')]
    public function testEnableVersioningMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->enableVersioning(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->enableVersioning);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['enableVersioning']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testHideVersionMenuProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->hideVersionMenu);
        static::assertArrayNotHasKey('hideVersionMenu', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->hideVersionMenu = $value;

        static::assertSame($value, $config->hideVersionMenu);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['hideVersionMenu']);
    }

    #[DataProvider('dataProviderBool')]
    public function testHideVersionMenuMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->hideVersionMenu(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['hideVersionMenu']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotCopyRecordsProperty(bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->doNotCopyRecords);
        static::assertArrayNotHasKey('doNotCopyRecords', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->doNotCopyRecords = $value;

        static::assertSame($value, $config->doNotCopyRecords);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotCopyRecords']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotCopyRecordsMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->doNotCopyRecords(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->doNotCopyRecords);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotCopyRecords']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotDeleteRecordsProperty(bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->doNotDeleteRecords);
        static::assertArrayNotHasKey('doNotDeleteRecords', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->doNotDeleteRecords = $value;

        static::assertSame($value, $config->doNotDeleteRecords);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotDeleteRecords']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotDeleteRecordsMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->doNotDeleteRecords(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->doNotDeleteRecords);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotDeleteRecords']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testBacklinkProperty(?string $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->backlink);
        static::assertArrayNotHasKey('backlink', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->backlink = $value;

        static::assertSame($value, $config->backlink);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['backlink']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testBacklinkMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->backlink(query: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->backlink);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['backlink']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testBackendSearchIgnoreProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        static::assertNull($config->backendSearchIgnore);
        static::assertArrayNotHasKey('backendSearchIgnore', $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->backendSearchIgnore = $value;

        static::assertSame($value, $config->backendSearchIgnore);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['backendSearchIgnore']);
    }

    #[DataProvider('dataProviderBool')]
    public function testBackendSearchIgnoreMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->backendSearchIgnore(enabled: $value);

        static::assertSame($config, $returned);
        static::assertSame($value, $config->backendSearchIgnore);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['backendSearchIgnore']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    #[DataProvider('dataProviderInt')]
    #[DataProvider('dataProviderString')]
    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderCallable')]
    #[DataProvider('dataProviderResource')]
    #[DataProvider('dataProviderObject')]
    public function testDynamicProperties(mixed $value): void
    {
        $config = new Config('tl_test');

        // make sure this is only a dynamic property
        static::assertObjectNotHasProperty('dynamicProperty', $config);

        static::assertNull($config->dynamicProperty);
        static::assertArrayNotHasKey('dynamicProperty', $GLOBALS['TL_DCA']['tl_test']['config']);

        /** @mago-expect analysis:non-documented-property */
        $config->dynamicProperty = $value;

        static::assertSame($value, $config->dynamicProperty);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicProperty']);

        if (is_null($value)) {
            static::assertFalse($config->__isset('dynamicProperty'));
        } else {
            static::assertTrue($config->__isset('dynamicProperty'));
        }

        $config->__unset('dynamicProperty');

        static::assertFalse($config->__isset('dynamicProperty'));
        static::assertNull($config->dynamicProperty);

        /** @mago-expect analysis:mixed-argument */
        static::assertArrayNotHasKey('dynamicProperty', $GLOBALS['TL_DCA']['tl_test']['config']);
    }

    public function testUnsetVirtualPropertyHooks(): void
    {
        $config = new Config('tl_test');
        $config->ptable = 'tl_parent';

        static::assertSame('tl_parent', $config->ptable);
        static::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);

        $config->__unset('ptable');

        /** @mago-expect analysis:impossible-type-comparison */
        static::assertNull($config->ptable);
        /** @mago-expect analysis:mixed-argument */
        static::assertArrayNotHasKey('ptable', $GLOBALS['TL_DCA']['tl_test']['config']);
    }

    public function testGetSqlProperty(): void
    {
        $config = new Config('tl_test');

        static::assertInstanceOf(Sql::class, $config->sql);
    }

    #[DataProvider('dataProviderArray')]
    public function testSetSqlProperty(array $value): void
    {
        $config = new Config('tl_test');

        static::assertInstanceOf(Sql::class, $config->sql);
        static::assertArrayHasKey('sql', $GLOBALS['TL_DCA']['tl_test']['config']);
        static::assertEmpty($GLOBALS['TL_DCA']['tl_test']['config']['sql']);

        $config->sql = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderArray')]
    public function testSqlMethod(?array $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->sql($value);

        static::assertSame($config, $returned);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['sql']);
    }

    public function testSqlMethodWithCallable(): void
    {
        $config = new Config('tl_test');

        $config->sql(function (Sql $sql, string $table): void {
            static::assertSame('tl_test', $table);
            $sql->charset = 'utf8mb4';
        });

        static::assertSame('utf8mb4', $GLOBALS['TL_DCA']['tl_test']['config']['sql']['charset']);
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testLoadCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->loadCallback);
        static::assertArrayNotHasKey(ConfigCallback::Load->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->loadCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Load->value][0]);
        static::assertSame($config->loadCallback, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Load->value]);
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testCreateCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->createCallback);
        static::assertArrayNotHasKey(ConfigCallback::Create->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->createCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Create->value][0]);
        static::assertSame(
            $config->createCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Create->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testBeforeSubmitCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->beforeSubmitCallback);
        static::assertArrayNotHasKey(ConfigCallback::BeforeSubmit->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->beforeSubmitCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::BeforeSubmit->value][0]);
        static::assertSame(
            $config->beforeSubmitCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::BeforeSubmit->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testSubmitCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->submitCallback);
        static::assertArrayNotHasKey(ConfigCallback::Submit->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->submitCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Submit->value][0]);
        static::assertSame(
            $config->submitCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Submit->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testDeleteCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->deleteCallback);
        static::assertArrayNotHasKey(ConfigCallback::Delete->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->deleteCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Delete->value][0]);
        static::assertSame(
            $config->deleteCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Delete->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testCutCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->cutCallback);
        static::assertArrayNotHasKey(ConfigCallback::Cut->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->cutCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Cut->value][0]);
        static::assertSame($config->cutCallback, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Cut->value]);
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testCopyCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->copyCallback);
        static::assertArrayNotHasKey(ConfigCallback::Copy->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->copyCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Copy->value][0]);
        static::assertSame($config->copyCallback, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Copy->value]);
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testCreateVersionCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->createVersionCallback);
        static::assertArrayNotHasKey(ConfigCallback::CreateVersion->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->createVersionCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::CreateVersion->value][0]);
        static::assertSame(
            $config->createVersionCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::CreateVersion->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testRestoreVersionCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->restoreVersionCallback);
        static::assertArrayNotHasKey(ConfigCallback::RestoreVersion->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->restoreVersionCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::RestoreVersion->value][0]);
        static::assertSame(
            $config->restoreVersionCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::RestoreVersion->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testUndoCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->undoCallback);
        static::assertArrayNotHasKey(ConfigCallback::Undo->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->undoCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Undo->value][0]);
        static::assertSame($config->undoCallback, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Undo->value]);
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testInvalidateCacheTagsCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->invalidateCacheTagsCallback);
        static::assertArrayNotHasKey(
            ConfigCallback::InvalidateCacheTags->value,
            $GLOBALS['TL_DCA']['tl_test']['config'],
        );

        $config->invalidateCacheTagsCallback = $value;

        static::assertSame(
            $value,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::InvalidateCacheTags->value][0],
        );
        static::assertSame(
            $config->invalidateCacheTagsCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::InvalidateCacheTags->value],
        );
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testShowCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->showCallback);
        static::assertArrayNotHasKey(ConfigCallback::Show->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->showCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Show->value][0]);
        static::assertSame($config->showCallback, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Show->value]);
    }

    #[DataProvider('dataProviderArray')]
    #[DataProvider('dataProviderClosure')]
    public function testPaletteCallbackProperty(array|Closure $value): void
    {
        $config = new Config('tl_test');

        static::assertSame([], $config->paletteCallback);
        static::assertArrayNotHasKey(ConfigCallback::Palette->value, $GLOBALS['TL_DCA']['tl_test']['config']);

        $config->paletteCallback = $value;

        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Palette->value][0]);
        static::assertSame(
            $config->paletteCallback,
            $GLOBALS['TL_DCA']['tl_test']['config'][ConfigCallback::Palette->value],
        );
    }
}
