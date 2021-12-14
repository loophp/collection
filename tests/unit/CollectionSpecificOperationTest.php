<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection;

use ArrayIterator;
use Closure;
use Exception;
use Generator;
use InvalidArgumentException;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\Coalesce;
use loophp\collection\Operation\Current;
use loophp\collection\Operation\Limit;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use stdClass;
use tests\loophp\collection\Traits\GenericCollectionProviders;
use function gettype;

/**
 * @internal
 * @coversDefaultClass \loophp\collection
 */
final class CollectionSpecificOperationTest extends TestCase
{
    use GenericCollectionProviders;
    use IterableAssertions;

    public function testApplyOperation(): void
    {
        $input = range('a', 'e');
        $stack = [];

        $this::assertIdenticalIterable(
            $input,
            Collection::fromIterable($input)
                ->apply(
                    static function ($item) use (&$stack): bool {
                        $stack += [$item => []];
                        $stack[$item][] = 'fn1';

                        return true;
                    }
                )
        );

        $expected = [
            'a' => ['fn1'],
            'b' => ['fn1'],
            'c' => ['fn1'],
            'd' => ['fn1'],
            'e' => ['fn1'],
        ];

        self::assertEquals($expected, $stack);

        $stack = [];

        $this::assertIdenticalIterable(
            $input,
            Collection::fromIterable($input)
                ->apply(
                    static function ($item) use (&$stack): bool {
                        $stack += [$item => []];
                        $stack[$item][] = 'fn1';

                        return false;
                    }
                )
        );

        $expected = [
            'a' => ['fn1'],
        ];

        self::assertEquals($expected, $stack);

        $stack = [];

        $this::assertIdenticalIterable(
            $input,
            Collection::fromIterable($input)
                ->apply(
                    static function ($item) use (&$stack): bool {
                        $stack += [$item => []];
                        $stack[$item][] = 'fn1';

                        return true;
                    },
                    static function ($item) use (&$stack): bool {
                        $stack += [$item => []];
                        $stack[$item][] = 'fn2';

                        return true;
                    }
                )
        );

        $expected = [
            'a' => ['fn1', 'fn2'],
            'b' => ['fn1', 'fn2'],
            'c' => ['fn1', 'fn2'],
            'd' => ['fn1', 'fn2'],
            'e' => ['fn1', 'fn2'],
        ];

        self::assertEquals($expected, $stack);

        $stack = [];

        $this::assertIdenticalIterable(
            $input,
            Collection::fromIterable($input)
                ->apply(
                    static function ($item) use (&$stack): bool {
                        $stack += [$item => []];
                        $stack[$item][] = 'fn1';

                        if ('c' === $item) {
                            return false;
                        }

                        return true;
                    },
                    static function ($item) use (&$stack): bool {
                        $stack += [$item => []];
                        $stack[$item][] = 'fn2';

                        if ('b' === $item) {
                            return false;
                        }

                        return true;
                    }
                )
        );

        $expected = [
            'a' => ['fn1', 'fn2'],
            'b' => ['fn1', 'fn2'],
            'c' => ['fn1'],
        ];

        self::assertEquals($expected, $stack);
    }

    public function testCoalesceOperation(): void
    {
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        $coalesce = new Coalesce();

        self::assertCount(1, $coalesce->__invoke()($iterator));

        self::assertIdenticalIterable(
            [
                0 => 'a',
            ],
            $coalesce->__invoke()($iterator)
        );

        $input = ['', null, 'foo', false, ...range('a', 'e')];

        $iterator = new ArrayIterator($input);

        self::assertCount(1, $coalesce->__invoke()($iterator));

        self::assertIdenticalIterable(
            [
                2 => 'foo',
            ],
            $coalesce->__invoke()($iterator)
        );
    }

    public function testCurrentOperation(): void
    {
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        $current = new Current();

        self::assertIdenticalIterable(
            ['a'],
            $current->__invoke()(0)(null)($iterator)
        );

        self::assertCount(1, $current->__invoke()(0)(null)($iterator));

        self::assertIdenticalIterable(
            ['unavailable'],
            $current->__invoke()(10)('unavailable')($iterator)
        );
    }

    public function testCycleOperation(): void
    {
        $generator = static function (): Generator {
            yield 0 => 1;

            yield 1 => 2;

            yield 2 => 3;

            yield 0 => 1;

            yield 1 => 2;

            yield 2 => 3;

            yield 0 => 1;
        };

        $this::assertIdenticalIterable(
            $generator(),
            Collection::fromIterable(range(1, 3))->cycle()->limit(7),
        );
    }

    public function testDumpOperation(): void
    {
        $count = 0;
        $input = range('a', 'e');

        $callback = static function (string $name, $key, $value) use (&$count) {
            ++$count;
        };

        $test1 = Collection::fromIterable($input)
            ->dump('here', 0, $callback);

        self::assertIdenticalIterable(
            $input,
            $test1
        );

        self::assertEquals(5, $count);

        $count = 0;

        $callback = static function (string $name, $key, $value) use (&$count) {
            ++$count;
        };

        $test2 = Collection::fromIterable($input)->dump('here', -1, $callback);

        self::assertIdenticalIterable(
            $input,
            $test2
        );

        self::assertEquals(0, $count);

        $callback = static function (string $name, $key, $value) use (&$count) {
            ++$count;
        };

        $test3 = Collection::fromIterable($input)
            ->dump('here', 2, $callback);

        self::assertIdenticalIterable(
            $input,
            $test3
        );

        self::assertEquals(2, $count);

        $expectedOutput = <<<'EOF'
            array(3) {
              ["name"]=>
              string(5) "debug"
              ["key"]=>
              int(0)
              ["value"]=>
              string(1) "a"
            }
            array(3) {
              ["name"]=>
              string(5) "debug"
              ["key"]=>
              int(1)
              ["value"]=>
              string(1) "b"
            }

            EOF;

        $test4 = Collection::fromIterable($input)->dump('debug', 2);
        $this->expectOutputString($expectedOutput);
        self::assertIdenticalIterable($input, $test4);
    }

    public function testLimitOperation(): void
    {
        $limit = new Limit();
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        self::assertCount(1, $limit()(1)(0)($iterator));

        self::assertCount(2, $limit()(2)(0)($iterator));

        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        self::assertIdenticalIterable(
            [2 => 'c'],
            $limit()(1)(2)($iterator)
        );

        self::assertCount(2, $limit()(2)(2)($iterator));

        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        self::assertIdenticalIterable(
            ['a', 'b', 'c', 'd', 'e'],
            $limit()()()($iterator)
        );
    }

    public function testPartitionOperation(): void
    {
        $isGreaterThan = static fn (int $left): Closure => static fn (int $right): bool => $left < $right;
        $input = array_combine(range('a', 'l'), [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3]);

        // Using `first` and `last`, single callback
        $subject = Collection::fromIterable($input)->partition($isGreaterThan(5));
        self::assertCount(2, $subject);

        $first = $subject->first()->current();
        $last = $subject->last()->current();

        self::assertInstanceOf(CollectionInterface::class, $first);
        self::assertInstanceOf(CollectionInterface::class, $last);

        self::assertCount(4, $first);
        self::assertCount(8, $last);

        self::assertIdenticalIterable(
            ['f' => 6, 'g' => 7, 'h' => 8, 'i' => 9],
            $first
        );
        self::assertIdenticalIterable(
            ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'j' => 1, 'k' => 2, 'l' => 3],
            $last
        );

        // Using `all` and array destructuring, single callback

        [$passed, $rejected] = Collection::fromIterable($input)->partition($isGreaterThan(5))->all();
        self::assertInstanceOf(CollectionInterface::class, $passed);
        self::assertInstanceOf(CollectionInterface::class, $rejected);

        self::assertCount(4, $passed);
        self::assertCount(8, $rejected);

        self::assertIdenticalIterable(
            ['f' => 6, 'g' => 7, 'h' => 8, 'i' => 9],
            $passed
        );
        self::assertIdenticalIterable(
            ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'j' => 1, 'k' => 2, 'l' => 3],
            $rejected
        );

        // Using multiple callbacks
        self::assertIdenticalIterable(
            ['d' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8, 'i' => 9],
            Collection::fromIterable($input)
                ->partition($isGreaterThan(5), $isGreaterThan(3))
                ->first()
                ->current()
        );

        self::assertIdenticalIterable(
            ['a' => 1, 'b' => 2, 'c' => 3, 'j' => 1, 'k' => 2, 'l' => 3],
            Collection::fromIterable($input)
                ->partition($isGreaterThan(5), $isGreaterThan(3))
                ->last()
                ->current()
        );
    }

    public function testRandomOperation(): void
    {
        $input = range('a', 'z');

        self::assertCount(
            1,
            Collection::fromIterable($input)->random()
        );

        self::assertCount(
            26,
            Collection::fromIterable($input)->random(100)
        );

        // TODO: Implements assertNotIdenticalIterable in PHPunit
        /*
        $this::fromIterable($input)
            ->random(26)
            ->shouldNotIterateAs($generator($input));
         */

        self::assertIdenticalIterable(
            ['a'],
            Collection::fromIterable(['a'])->random()
        );

        $this->expectException(OutOfBoundsException::class);

        Collection::fromIterable($input)->random(0)->all();
    }

    public function testRsampleOperation(): void
    {
        self::assertCount(
            10,
            Collection::fromIterable(range(1, 10))->rsample(1)
        );

        self::assertNotCount(
            10,
            Collection::fromIterable(range(1, 10))->rsample(.5)
        );
    }

    public function testSpanOperation(): void
    {
        $input = range(1, 10);

        $callbacks = [
            static fn (int $x): bool => 4 > $x,
        ];

        $subject = Collection::fromIterable($input)->span(...$callbacks);
        self::assertCount(2, $subject);
        self::assertInstanceOf(
            CollectionInterface::class,
            $subject->first()
        );
        self::assertInstanceOf(
            CollectionInterface::class,
            $subject->last()
        );
        self::assertIdenticalIterable(
            [1, 2, 3],
            $subject->first()->current()
        );
        self::assertIdenticalIterable(
            [3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10],
            $subject->last()->current()
        );

        $callbacks = [
            static fn (int $x): bool => 4 > $x,
            static fn (int $x): bool => $x % 2 === 0,
        ];
        $subject = Collection::fromIterable($input)->span(...$callbacks);
        self::assertCount(2, $subject);
        self::assertInstanceOf(
            CollectionInterface::class,
            $subject->first()
        );
        self::assertInstanceOf(
            CollectionInterface::class,
            $subject->last()
        );
        self::assertIdenticalIterable(
            [1, 2, 3, 4],
            $subject->first()->current()
        );
        self::assertIdenticalIterable(
            [4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10],
            $subject->last()->current()
        );
    }

    public function testSquashOperation(): void
    {
        $this->expectException(Exception::class);

        Collection::fromIterable([16, 4, -9, 9])
            ->map(
                static function (int $value): int {
                    if (0 > $value) {
                        throw new Exception('This should error');
                    }

                    return (int) sqrt($value);
                }
            )
            ->squash();

        self::assertIdenticalIterable(
            [4, 2, 3, 3],
            Collection::fromIterable([16, 4, 9, 9])
                ->map(
                    static function (int $value): int {
                        if (-100 > $value) {
                            throw new Exception('This should not error');
                        }

                        return (int) sqrt($value);
                    }
                )
                ->squash()
        );
    }

    public function testStrictOperation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Collection::fromIterable([1, 'foo', 2])->strict()->all();

        $obj1 = new stdClass();
        $obj2 = new class() {
            public function count(): int
            {
                return 0;
            }
        };

        $collection = Collection::fromIterable([$obj1, $obj2]);

        $callback = static fn ($value): string => gettype($value);

        self::assertIdenticalIterable(
            [$obj1, $obj2],
            $collection->strict($callback)->all()
        );
    }
}
