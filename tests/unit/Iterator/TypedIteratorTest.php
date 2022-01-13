<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection\Iterator;

use ArrayIterator;
use Countable;
use Generator;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use loophp\collection\Iterator\TypedIterator;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;

use function gettype;

/**
 * @internal
 * @coversDefaultClass \loophp\collection\Iterator
 */
final class TypedIteratorTest extends TestCase
{
    use IterableAssertions;

    private const LIST_DATA = [1, 2, 3];

    private const MAP_DATA = ['foo' => 1, 'bar' => 2];

    public function testAllowsArrayOfAnyType(): void
    {
        $data = [self::MAP_DATA, self::LIST_DATA];

        $iterator = new TypedIterator(new ArrayIterator($data));

        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsCustomGettypeCallback(): void
    {
        $callback = static fn ($variable) => gettype($variable);

        $obj1 = new class() {
            public function sayHello(): string
            {
                return 'Hello';
            }
        };
        $obj2 = new stdClass();

        $data = [new $obj1(), new $obj2()];

        $iterator = new TypedIterator(new ArrayIterator($data), $callback);
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsDifferentClassesWithMultipleInterfaces(): void
    {
        $obj1 = new class() implements Countable, JsonSerializable {
            public function count(): int
            {
                return 0;
            }

            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $obj2 = new class() implements Countable, JsonSerializable {
            public function count(): int
            {
                return 0;
            }

            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $data = [new $obj1(), new $obj2()];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsDifferentClassesWithSameInterface(): void
    {
        $obj1 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $obj2 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $data = [new $obj1(), new $obj2()];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsDifferentClassesWithSameInterfaceButInDifferentOrder(): void
    {
        $obj1 = new class() implements IteratorAggregate, Countable {
            public function count(): int
            {
                return 0;
            }

            public function getIterator(): Traversable
            {
                yield 0;
            }
        };

        $obj2 = new class() implements Countable, IteratorAggregate {
            public function count(): int
            {
                return 0;
            }

            public function getIterator(): Traversable
            {
                yield 0;
            }
        };

        $data = [new $obj1(), new $obj2()];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsNullType(): void
    {
        $data = [1, null, 3];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsSameClassWithInterface(): void
    {
        $obj = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $data = [new $obj(), new $obj()];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsSameClassWithMultipleInterfaces(): void
    {
        $obj = new class() implements Countable, JsonSerializable {
            public function count(): int
            {
                return 0;
            }

            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $data = [new $obj(), new $obj()];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testAllowsSameClassWithoutInterface(): void
    {
        $obj1 = new stdClass();
        $obj1->id = 1;

        $obj2 = new stdClass();
        $obj2->id = 2;

        $data = [$obj1, $obj2];

        $iterator = new TypedIterator(new ArrayIterator($data));
        self::assertIdenticalIterable(
            $data,
            $iterator
        );
    }

    public function testDisallowsBoolMixed(): void
    {
        $iterator = new TypedIterator(new ArrayIterator([true, false, 'bar']));
        $iterator->next();

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsDifferentClasses(): void
    {
        $obj1 = new class() {
            public function sayHello(): string
            {
                return 'Hello';
            }
        };

        $obj2 = new stdClass();

        $iterator = new TypedIterator(new ArrayIterator([new $obj1(), new $obj2()]));

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsFloatMixed(): void
    {
        $iterator = new TypedIterator(new ArrayIterator([2.3, 5.6, 1]));
        $iterator->next();
        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsIntMixed(): void
    {
        $iterator = new TypedIterator(new ArrayIterator([1, 2, 'foo']));

        $iterator->next();

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsMixedAtBeginning(): void
    {
        $iterator = new TypedIterator(new ArrayIterator([1, 'bar', 'foo']));

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsMixedInMiddle(): void
    {
        $iterator = new TypedIterator(new ArrayIterator([1, 'bar', 2]));

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsMixOfClassesWithAndWithoutInterfaces(): void
    {
        $obj1 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $obj2 = new class() {
            public function count(): int
            {
                return 0;
            }
        };

        $iterator = new TypedIterator(new ArrayIterator([new $obj1(), new $obj2()]));

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsMixOfClassesWithDifferentInterfaces(): void
    {
        $obj1 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $obj2 = new class() implements JsonSerializable {
            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $iterator = new TypedIterator(new ArrayIterator([new $obj1(), new $obj2()]));

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsResourceMixedOpenClosed(): void
    {
        $openResource = fopen('data://text/plain,ABCD', 'rb');
        $closedResource = fopen('data://text/plain,XYZ', 'rb');
        fclose($closedResource);

        $iterator = new TypedIterator(new ArrayIterator([$openResource, $closedResource]));

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testDisallowsStringMixed(): void
    {
        $iterator = new TypedIterator(new ArrayIterator(['foo', 'bar', 3]));

        $iterator->next();

        $this->expectException(InvalidArgumentException::class);

        $iterator->next();
    }

    public function testIsInitializableFromArray(): void
    {
        $iterator = new TypedIterator(new ArrayIterator(self::LIST_DATA));

        self::assertTrue($iterator->valid());

        self::assertIdenticalIterable(
            self::LIST_DATA,
            $iterator
        );
    }

    public function testIsInitializableFromGenerator(): void
    {
        $gen = static fn (): Generator => yield from self::MAP_DATA;

        $iterator = new TypedIterator($gen());

        self::assertTrue($iterator->valid());
        self::assertIdenticalIterable(
            self::MAP_DATA,
            $iterator
        );
    }

    public function testIsInitializableFromIterator(): void
    {
        $iterator = new TypedIterator(new ArrayIterator(self::LIST_DATA));

        self::assertTrue($iterator->valid());
        self::assertIdenticalIterable(
            self::LIST_DATA,
            $iterator
        );
    }

    public function testReturnAnIntKey(): void
    {
        $iterator = new TypedIterator(new ArrayIterator(self::LIST_DATA));

        self::assertSame(0, $iterator->key());
        $iterator->next();
        self::assertSame(1, $iterator->key());
    }

    public function testReturnAStringKey(): void
    {
        $iterator = new TypedIterator(new ArrayIterator(self::MAP_DATA));

        self::assertSame('foo', $iterator->key());
        $iterator->next();
        self::assertSame('bar', $iterator->key());
    }

    public function testRewind(): void
    {
        $iterator = new TypedIterator(new ArrayIterator(['foo']));

        self::assertSame('foo', $iterator->current());

        $iterator->next();
        self::assertFalse($iterator->valid());
        self::assertNull($iterator->current());

        $iterator->rewind();
        self::assertTrue($iterator->valid());
        self::assertSame('foo', $iterator->current());
    }
}
