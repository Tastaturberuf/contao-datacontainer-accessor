<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Tests;

use Closure;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tastaturberuf\ContaoDataContainerAccessor\AbstractAccessor;
use Tastaturberuf\ContaoDataContainerAccessor\Exception\AccessorTypeError;
use TypeError;

final class AbstractAccessorTest extends TestCase
{
    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderString')]
    public function testGetNullableStringReturnsNullOrString(?string $value): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        static::assertSame($value, $accessor->readNullableString('foo'));
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderInt')]
    public function testGetNullableIntReturnsNullOrInt(?int $value): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        static::assertSame($value, $accessor->readNullableInt('foo'));
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderBool')]
    public function testGetNullableBoolReturnsNullOrBool(?bool $value): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        static::assertSame($value, $accessor->readNullableBool('foo'));
    }

    #[DataProvider('dataProviderNull')]
    #[DataProvider('dataProviderArray')]
    public function testGetNullableArrayReturnsNullOrArray(?array $value): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        static::assertSame($value, $accessor->readNullableArray('foo'));
    }

    #[DataProvider('dataProviderInvalidNullableStringValue')]
    public function testGetNullableStringThrowsTypeErrorForInvalidTypes(mixed $value, string $actualType): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        try {
            $accessor->readNullableString('foo');
            static::fail('Expected TypeError was not thrown.');
        } catch (TypeError $error) {
            fwrite(STDERR, $error->getMessage());
            static::assertInstanceOf(AccessorTypeError::class, $error);
            static::assertSame('TL_DCA.tl_test.test_path', $error->path);
            static::assertSame('?string', $error->expected);
            static::assertSame($actualType, $error->actualType);
        }
    }

    #[DataProvider('dataProviderInvalidNullableIntValue')]
    public function testGetNullableIntThrowsTypeErrorForInvalidTypes(mixed $value, string $actualType): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        try {
            $accessor->readNullableInt('foo');
            static::fail('Expected TypeError was not thrown.');
        } catch (TypeError $error) {
            static::assertInstanceOf(AccessorTypeError::class, $error);
            static::assertSame('TL_DCA.tl_test.test_path', $error->path);
            static::assertSame('?int', $error->expected);
            static::assertSame($actualType, $error->actualType);
        }
    }

    #[DataProvider('dataProviderInvalidNullableBoolValue')]
    public function testGetNullableBoolThrowsTypeErrorForInvalidTypes(mixed $value, string $actualType): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        try {
            $accessor->readNullableBool('foo');
            static::fail('Expected TypeError was not thrown.');
        } catch (TypeError $error) {
            static::assertInstanceOf(AccessorTypeError::class, $error);
            static::assertSame('TL_DCA.tl_test.test_path', $error->path);
            static::assertSame('?bool', $error->expected);
            static::assertSame($actualType, $error->actualType);
        }
    }

    #[DataProvider('dataProviderInvalidNullableArrayValue')]
    public function testGetNullableArrayThrowsTypeErrorForInvalidTypes(mixed $value, string $actualType): void
    {
        $accessor = new TestAbstractAccessor('tl_test');
        $accessor->__set('foo', $value);

        try {
            $accessor->readNullableArray('foo');
            static::fail('Expected TypeError was not thrown.');
        } catch (TypeError $error) {
            static::assertInstanceOf(AccessorTypeError::class, $error);
            static::assertSame('TL_DCA.tl_test.test_path', $error->path);
            static::assertSame('?array', $error->expected);
            static::assertSame($actualType, $error->actualType);
        }
    }

    public static function dataProviderInvalidNullableStringValue(): iterable
    {
        yield 'int' => [123, 'int'];
        yield 'float' => [12.3, 'float'];
        yield 'bool' => [true, 'bool'];
        yield 'array' => [[], 'array'];
        yield 'object' => [new stdClass(), 'stdClass'];
    }

    public static function dataProviderInvalidNullableIntValue(): iterable
    {
        yield 'string' => ['123', 'string'];
        yield 'float' => [12.3, 'float'];
        yield 'bool' => [true, 'bool'];
        yield 'array' => [[], 'array'];
        yield 'object' => [new stdClass(), 'stdClass'];
    }

    public static function dataProviderInvalidNullableBoolValue(): iterable
    {
        yield 'string' => ['1', 'string'];
        yield 'int' => [1, 'int'];
        yield 'float' => [12.3, 'float'];
        yield 'array' => [[], 'array'];
        yield 'object' => [new stdClass(), 'stdClass'];
    }

    public static function dataProviderInvalidNullableArrayValue(): iterable
    {
        yield 'string' => ['value', 'string'];
        yield 'int' => [1, 'int'];
        yield 'float' => [12.3, 'float'];
        yield 'bool' => [true, 'bool'];
        yield 'object' => [new stdClass(), 'stdClass'];
    }
}

/** @mago-ignore lint:single-class-per-file */
final class TestAbstractAccessor extends AbstractAccessor
{
    public readonly string $_table;
    public readonly array $_path;

    /**
     * @var array<string, mixed>
     */
    private array $values = [];

    public function __construct(string $table)
    {
        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'test_path'];
    }

    public function __get(string $name): mixed
    {
        return $this->values[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->values[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->values[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->values[$name]);
    }

    public function __invoke(Closure $callable): void
    {
        $callable();
    }

    public function readNullableString(string $name): ?string
    {
        return $this->getNullableString($name);
    }

    public function readNullableInt(string $name): ?int
    {
        return $this->getNullableInt($name);
    }

    public function readNullableBool(string $name): ?bool
    {
        return $this->getNullableBool($name);
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function readNullableArray(string $name): ?array
    {
        return $this->getNullableArray($name);
    }
}
