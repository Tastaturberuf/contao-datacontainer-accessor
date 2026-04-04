<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests\Config;

use PHPUnit\Framework\Attributes\DataProvider;
use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\Config\ConfigCallbacks;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Sql;
use Tastaturberuf\ContaoDataContainerAccessor\Tests\TestCase;

/**
 * @mago-expect analysis:mixed-array-access
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

    public function testInvoke(): void
    {
        $config = new Config('tl_test');

        $config(static function (Config $innerConfig, string $table) use ($config): void {
            static::assertSame($config, $innerConfig);
            static::assertSame('tl_test', $table);
        });
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

        $config->label = $value;

        static::assertSame($value, $config->label);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['label']);
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

    public function testLabelPropertySupportsArrowFunctionReference(): void
    {
        $config = new Config('tl_test');
        /** @mago-expect analysis:mixed-array-assignment */
        $GLOBALS['TL_LANG']['tl_test']['label'] = 'foo';

        $config->label = static fn&() => $GLOBALS['TL_LANG']['tl_test']['label'];

        /** @mago-expect analysis:mixed-array-assignment */
        $GLOBALS['TL_LANG']['tl_test']['label'] = 'bar';

        static::assertSame('bar', $GLOBALS['TL_DCA']['tl_test']['config']['label']);
        static::assertSame('bar', $config->label);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testPtableProperty(?string $value): void
    {
        $config = new Config('tl_test');

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
     * @param array<string> $value
     */
    #[DataProvider('dataProviderArray')]
    public function testCtableProperty(array $value): void
    {
        $config = new Config('tl_test');

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

        if ($value === null) {
            $this->expectException(\InvalidArgumentException::class);
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

        // make sure this is only a virtual property
        static::assertObjectNotHasProperty('dynamicProperty', $config);

        /** @mago-expect analysis:non-documented-property */
        $config->dynamicProperty = $value;

        static::assertSame($value, $config->dynamicProperty);
        static::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicProperty']);

        if (is_null($value)) {
            static::assertFalse($config->isset('dynamicProperty'));
        } else {
            static::assertTrue($config->isset('dynamicProperty'));
        }

        $config->unset('dynamicProperty');

        static::assertFalse($config->isset('dynamicProperty'));
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

        $config->unset('ptable');

        /** @mago-expect analysis:impossible-type-comparison */
        static::assertNull($config->ptable);
        /** @mago-expect analysis:mixed-argument */
        static::assertArrayNotHasKey('ptable', $GLOBALS['TL_DCA']['tl_test']['config']);
    }

    public function testCallbacks(): void
    {
        $config = new Config('tl_test');

        static::assertInstanceOf(ConfigCallbacks::class, $config->callbacks);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->create);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->beforeSubmit);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->copy);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->cut);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->delete);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->load);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->palette);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->restore);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->restoreVersion);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->submit);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->undo);
        static::assertInstanceOf(CallbackBag::class, $config->callbacks->version);
    }

    public function testGetSqlProperty(): void
    {
        $config = new Config('tl_test');

        static::assertInstanceOf(Sql::class, $config->sql);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderArray')]
    public function testSetSqlProperty(?array $value): void
    {
        $config = new Config('tl_test');

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

    public function testPath(): void
    {
        $config = new Config('tl_test');

        /** @mago-ignore analysis:all */
        $path = invade($config)->_path('test');

        self::assertSame("\$GLOBALS['TL_DCA']['tl_test']['config']['test']", $path);
    }
}
