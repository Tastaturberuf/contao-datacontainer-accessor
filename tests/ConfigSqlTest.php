<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoDataContainerAccessor\ConfigSql;

#[RunTestsInSeparateProcesses]
class ConfigSqlTest extends TestCase
{

    public function testCanInstantiateClass(): void
    {
        static::assertInstanceOf(ConfigSql::class, new ConfigSql('tl_test'));
    }

    public function testtestThis(): void
    {
        $sql = new ConfigSql('tl_test');

        static::assertSame('tl_test', $sql->test->test);
    }

}
