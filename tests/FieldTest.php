<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Tastaturberuf\ContaoDataContainerAccessor\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{

    public function testInstantiation(): void
    {
        $field = new Field('tl_test', 'test_field');
        $this->assertInstanceOf(Field::class, $field);

        $field->test = 'test';

        d($GLOBALS['TL_DCA']['tl_test']['fields']['test_field']);
    }

}
