<?php

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ListCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;
use Tastaturberuf\ContaoDataContainerAccessor\Field;
use Tastaturberuf\ContaoDataContainerAccessor\Listing;

#[RunTestsInSeparateProcesses]
class DataContainerTest extends TestCase
{

    public function testCanInstantiate(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        static::assertInstanceOf(DataContainerAccessor::class, $dca);
        static::assertInstanceOf(Config::class, $dca->config);
        static::assertInstanceOf(Listing::class, $dca->list);
    }

    public function testDynamicProperties(): void
    {
        $dca = new DataContainerAccessor('tl_test');
        $dca->newProperty = 'test';

        static::assertSame('test', $dca->newProperty);
        static::assertSame('test', $GLOBALS['TL_DCA']['tl_test']['newProperty']);
    }

    public function testConfigSyntaxLongVersion(): void
    {
        $dca = new DataContainerAccessor('tl_test');
        $dca->config->ptable = 'tl_parent';

        static::assertSame('tl_parent', $dca->config->ptable);
    }

    public function testConfigSyntaxClosure(): void
    {
        $dca = new DataContainerAccessor('tl_test');
        $dca->config(static function (Config $config): void {
            $config->ptable = 'tl_parent';
        });

        static::assertSame('tl_parent', $dca->config->ptable);
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

    public function _testSyntax(): void
    {
        $dc = new DataContainerAccessor('tl_test');

        $dc->config->callbacks->create[] = fn() => true;


        d($GLOBALS['TL_DCA']['tl_test']);
    }

    public function _testArticleDataContainer(): void
    {
        $dc = new DataContainerAccessor('tl_article');

        $dc->config->dataContainer = '\Contao\DC_Table::class';
        $dc->config->ptable = 'tl_page';
        $dc->config->ctable = ['tl_content'];
        $dc->config->switchToEdit = true;
        $dc->config->enableVersioning = true;
        $dc->config->markAsCopy = 'title';
        $dc->config->mycustom_callback[] = fn() => true;
        $dc->addCallback(ConfigCallback::Create, fn() => true);
        $dc->addCallback(ConfigCallback::Create, fn() => true);
        $dc->addCallback(ConfigCallback::Copy, fn() => true);
        $dc->addCallback(ListCallback::Header, fn() => true);
        $dc->addCallback(LabelCallback::Label, static fn() => true);
        $dc->config->sql->keys = [
            'id' => 'primary',
            'tstamp' => 'index',
            'alias' => 'index',
            'pid,published,inColumn,start,stop' => 'index'
        ];
        $dc->list->sorting->mode = 6;
        $dc->list->sorting->panelLayout = 'filter;search';
        $dc->list->sorting->defaultSearchField = 'title';
        $dc->list->label->fields = ['title', 'inColumn'];
        $dc->list->label->format = '%s <span class="label-info">[%s]</span>';
        $dc->addCallback(LabelCallback::Label, static fn() => true);
        $dc->select = [
            'buttons_callback' => fn() => true
        ];

        d($GLOBALS['TL_DCA']['tl_article']);
    }

    public function _testObjectToArray(): void
    {
        $dca = new DataContainerAccessor('tl_test');

        $dca->list->globalOperations = fn() => true;

        $dca->config->callbacks->load[] = fn() => true;
        $dca->config->oncreate_callback[] = fn() => true;

        $dca->addField(function (Field $field) {

        });

        $field = $dca->getField();

        $dca->field['test_name'] = static function (Field $field) {
            $field->reference = 'test';
            $field->inputType = 'text';
            $field->eval['tl_class'] = 'test';
        };

        d($dca->list->globalOperations);

        d(json_decode(json_encode($dca), true));

        d(get_object_vars($dca));
    }

}
