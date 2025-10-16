<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\ConfigCallbacks;
use Tastaturberuf\ContaoDataContainerAccessor\ConfigSql;

class ConfigTest extends TestCase
{

    protected function setUp(): void
    {
        unset($GLOBALS['TL_DCA']['tl_test']['config']);
    }

    public function testCanInstantiate(): void
    {
        $class = new Config('tl_test');

        self::assertInstanceOf(Config::class, $class);
    }

    public static function dataProviderNull(): array
    {
        return [
            'null' => [null],
        ];
    }

    public static function dataProviderBool(): array
    {
        return [
            'true' => [true],
            'false' => [false],
        ];
    }

    public static function dataProviderInt(): array
    {
        return [
            'integer 0' => [0],
            'positive integer' => [1],
            'negative integer' => [-1],
            'max integer' => [PHP_INT_MAX],
            'min integer' => [PHP_INT_MIN],
        ];
    }

    public static function dataProviderString(): array
    {
        return [
            'empty string' => [''],
            'string' => ['string'],
        ];
    }

    public static function dataProviderArray(): array
    {
        return [
            'empty array' => [[]],
            'single list array' => [['value']],
            'list array' => [['value1', 'value2']],
            'single associative array' => [['key' => 'value']],
            'associative array' => [['key1' => 'value1', 'key2' => 'value2']],
            'multidimensional array' => [['key' => ['value']]],
        ];
    }

    public static function dataProviderObject(): array
    {
        return [
            'object stdClass' => [new \stdClass()],
            'object DateTime' => [new \DateTime()],
        ];
    }

    public static function dataProviderResource(): array
    {
        return [
            'resource' => [fopen('php://memory', 'rb')],
        ];
    }

    public static function dataProviderCallable(): array
    {
        return [
            'closure' => [fn() => true],
            'static closure' => [static fn() => true],
            'instance callable' => [new class {
                public function __invoke(): bool
                {
                    return true;
                }
            }],
        ];
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testLabelProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->label = $value;

        self::assertSame($value, $config->label);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['label']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testLabelMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->label($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->label);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['label']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testPtableProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->ptable = $value;

        self::assertSame($value, $config->ptable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testPtableMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->ptable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->ptable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testDynamicPtableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        $config->dynamicPtable = $value;

        self::assertSame($value, $config->dynamicPtable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicPtable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDynamicPtableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->dynamicPtable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->dynamicPtable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicPtable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderArray')]
    public function testCtableProperty(?array $value): void
    {
        $config = new Config('tl_test');

        $config->ctable = $value;

        self::assertSame($value, $config->ctable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ctable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderArray')]
    public function testCtableMethod(?array $value): void
    {
        $config = new Config('tl_test');

        $retuned = $config->ctable($value);

        self::assertSame($config, $retuned);
        self::assertSame($value, $config->ctable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['ctable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testDataContainerProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->dataContainer = $value;

        self::assertSame($value, $config->dataContainer);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dataContainer']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testDataContainerMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $retuned = $config->dataContainer($value);

        self::assertSame($config, $retuned);
        self::assertSame($value, $config->dataContainer);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dataContainer']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testMarkAsCopyProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->markAsCopy = $value;

        self::assertSame($value, $config->markAsCopy);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['markAsCopy']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testMarkAsCopyMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->markAsCopy($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->markAsCopy);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['markAsCopy']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testUploadPathProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->uploadPath = $value;

        self::assertSame($value, $config->uploadPath);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['uploadPath']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testUploadPathMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->uploadPath($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->uploadPath);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['uploadPath']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testValidFileTypesProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->validFileTypes = $value;

        self::assertSame($value, $config->validFileTypes);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['validFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testValidFileTypesMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->validFileTypes($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->validFileTypes);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['validFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testEditableFileTypesProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->editableFileTypes = $value;

        self::assertSame($value, $config->editableFileTypes);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['editableFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testEditableFileTypesMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->editableFileTypes($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->editableFileTypes);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['editableFileTypes']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testDatabaseAssistedProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        $config->databaseAssisted = $value;

        self::assertSame($value, $config->databaseAssisted);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['databaseAssisted']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDatabaseAssistedMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->databaseAssisted($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->databaseAssisted);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['databaseAssisted']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testClosedProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        $config->closed = $value;

        self::assertSame($value, $config->closed);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['closed']);
    }

    #[DataProvider('dataProviderBool')]
    public function testClosedMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->closed($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->closed);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['closed']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testNotEditableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        $config->notEditable = $value;

        self::assertSame($value, $config->notEditable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notEditable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotEditableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notEditable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->notEditable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notEditable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testNotDeletableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        $config->notDeletable = $value;

        self::assertSame($value, $config->notDeletable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notDeletable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotDeletableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notDeletable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->notDeletable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notDeletable']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testNotSortableProperty(?bool $value): void
    {
        $config = new Config('tl_test');

        $config->notSortable = $value;

        self::assertSame($value, $config->notSortable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notSortable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotSortableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notSortable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->notSortable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notSortable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCopyableProperty(bool $value): void
    {
        $config = new Config('tl_test');

        $config->notCopyable = $value;

        self::assertSame($value, $config->notCopyable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCopyable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCopyableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notCopyable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->notCopyable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCopyable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCreatableProperty(bool $value): void
    {
        $config = new Config('tl_test');

        $config->notCreatable = $value;

        self::assertSame($value, $config->notCreatable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCreatable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testNotCreatableMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->notCreatable($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->notCreatable);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['notCreatable']);
    }

    #[DataProvider('dataProviderBool')]
    public function testSwitchToEditProperty(bool $value): void
    {
        $config = new Config('tl_test');

        $config->switchToEdit = $value;

        self::assertSame($value, $config->switchToEdit);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['switchToEdit']);
    }

    #[DataProvider('dataProviderBool')]
    public function testSwitchToEditMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->switchToEdit($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->switchToEdit);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['switchToEdit']);
    }

    #[DataProvider('dataProviderBool')]
    public function testEnableVersioningProperty(bool $value): void
    {
        $config = new Config('tl_test');

        $config->enableVersioning = $value;

        self::assertSame($value, $config->enableVersioning);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['enableVersioning']);
    }

    #[DataProvider('dataProviderBool')]
    public function testEnableVersioningMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->enableVersioning($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->enableVersioning);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['enableVersioning']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotCopyRecordsProperty(bool $value): void
    {
        $config = new Config('tl_test');

        $config->doNotCopyRecords = $value;

        self::assertSame($value, $config->doNotCopyRecords);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotCopyRecords']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotCopyRecordsMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->doNotCopyRecords($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->doNotCopyRecords);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotCopyRecords']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotDeleteRecordsProperty(bool $value): void
    {
        $config = new Config('tl_test');

        $config->doNotDeleteRecords = $value;

        self::assertSame($value, $config->doNotDeleteRecords);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotDeleteRecords']);
    }

    #[DataProvider('dataProviderBool')]
    public function testDoNotDeleteRecordsMethod(bool $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->doNotDeleteRecords($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->doNotDeleteRecords);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['doNotDeleteRecords']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testBacklinkProperty(?string $value): void
    {
        $config = new Config('tl_test');

        $config->backlink = $value;

        self::assertSame($value, $config->backlink);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['backlink']);
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testBacklinkMethod(?string $value): void
    {
        $config = new Config('tl_test');

        $returned = $config->backlink($value);

        self::assertSame($config, $returned);
        self::assertSame($value, $config->backlink);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['backlink']);
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
        self::assertObjectNotHasProperty('dynamicProperty', $config);

        $config->dynamicProperty = $value;

        self::assertSame($value, $config->dynamicProperty);
        self::assertSame($value, $GLOBALS['TL_DCA']['tl_test']['config']['dynamicProperty']);

        if (is_null($value)) {
            self::assertFalse($config->isset('dynamicProperty'));
        } else {
            self::assertTrue($config->isset('dynamicProperty'));
        }

        $config->unset('dynamicProperty');

        self::assertFalse($config->isset('dynamicProperty'));
        self::assertNull($config->dynamicProperty);

        self::assertArrayNotHasKey('dynamicProperty', $GLOBALS['TL_DCA']['tl_test']['config']);
    }

    public function testUnsetVirtualPropertyHooks(): void
    {
        $config = new Config('tl_test');
        $config->ptable = 'tl_parent';

        self::assertSame('tl_parent', $config->ptable);
        self::assertSame('tl_parent', $GLOBALS['TL_DCA']['tl_test']['config']['ptable']);

        $config->unset('ptable');

        self::assertNull($config->ptable);
        self::assertNull($GLOBALS['TL_DCA']['tl_test']['config']['ptable'] ?? null);
    }

    public function testCallbacks(): void
    {
        $config = new Config('tl_test');

        self::assertInstanceOf(ConfigCallbacks::class, $config->callbacks);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->create);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->beforeSubmit);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->copy);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->cut);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->delete);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->load);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->palette);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->restore);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->restoreVersion);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->submit);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->undo);
        self::assertInstanceOf(CallbackBag::class, $config->callbacks->version);
    }

    public function testSql(): void
    {
        $config = new Config('tl_test');

        self::assertInstanceOf(ConfigSql::class, $config->sql);;
    }

}
