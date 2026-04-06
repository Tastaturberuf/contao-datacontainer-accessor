<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use InvalidArgumentException;
use RuntimeException;
use Tastaturberuf\ContaoDataContainerAccessor\DcaPathAccessor;

final class DcaPathAccessorTest extends TestCase
{
    public function testGetReturnsNullWhenRootIsMissing(): void
    {
        static::assertNull(DcaPathAccessor::get('tl_test', 'config'));
    }

    public function testGetReturnsNullWhenPathIsMissing(): void
    {
        $GLOBALS['TL_DCA']['tl_test']['config'] = [];

        static::assertNull(DcaPathAccessor::get('tl_test', 'config', 'missing'));
    }

    public function testSetAndGetRoundTrip(): void
    {
        DcaPathAccessor::set(true, 'tl_test', 'config', 'closed');

        static::assertTrue(DcaPathAccessor::get('tl_test', 'config', 'closed'));
        static::assertTrue($GLOBALS['TL_DCA']['tl_test']['config']['closed']);
    }

    public function testSetThrowsForEmptyPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('path must not be empty');

        DcaPathAccessor::set('value');
    }

    public function testSetThrowsIfIntermediateSegmentIsNotArray(): void
    {
        $GLOBALS['TL_DCA']['tl_test']['config'] = false;

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("segment 'config' is bool");

        DcaPathAccessor::set('value', 'tl_test', 'config', 'closed');
    }
}
