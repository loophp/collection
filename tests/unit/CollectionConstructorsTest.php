<?php

declare(strict_types=1);

namespace tests\loophp\collection;

use Generator;
use InvalidArgumentException;
use loophp\collection\Collection;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;

use const INF;

/**
 *
 * @internal
 *
 * @coversDefaultClass \loophp\collection
 */
final class CollectionConstructorsTest extends TestCase
{
    use IterableAssertions;

    public function testFromCallableConstructor(): void
    {
        $fibonacci = static function ($start, $inc) {
            yield $start;

            while (true) {
                $inc = $start + $inc;
                $start = $inc - $start;

                yield $start;
            }
        };

        self::assertIdenticalIterable(
            [0, 1, 1, 2, 3, 5, 8, 13, 21, 34],
            Collection::fromCallable($fibonacci, [0, 1])->limit(10)
        );

        $test1 = Collection::fromCallable(static fn (int $a, int $b): Generator => yield from range($a, $b), [1, 5]);
        self::assertInstanceOf(Collection::class, $test1);
        self::assertIdenticalIterable(
            range(1, 5),
            $test1
        );

        $test2 = Collection::fromCallable(static fn (int $a, int $b): array => range($a, $b), [1, 5]);
        self::assertInstanceOf(Collection::class, $test2);
        self::assertIdenticalIterable(
            range(1, 5),
            $test2
        );

        $classWithMethod = new class() {
            public function getValues(): Generator
            {
                yield from range(1, 5);
            }
        };
        $test4 = Collection::fromCallable([$classWithMethod, 'getValues']);
        self::assertInstanceOf(Collection::class, $test4);
        self::assertIdenticalIterable(
            range(1, 5),
            $test4
        );

        $classWithStaticMethod = new class() {
            public static function getValues(): Generator
            {
                yield from range(1, 5);
            }
        };
        $test5 = Collection::fromCallable([$classWithStaticMethod, 'getValues']);
        self::assertInstanceOf(Collection::class, $test5);
        self::assertIdenticalIterable(
            range(1, 5),
            $test5
        );

        $invokableClass = new class() {
            public function __invoke(): Generator
            {
                yield from range(1, 5);
            }
        };
        $test6 = Collection::fromCallable($invokableClass);
        self::assertInstanceOf(Collection::class, $test6);
        self::assertIdenticalIterable(
            range(1, 5),
            $test6
        );
    }

    public function testFromEmptyConstructor(): void
    {
        self::assertIdenticalIterable(
            [],
            Collection::empty()
        );
    }

    public function testFromFileConstructor()
    {
        self::assertIdenticalIterable(
            ['a', 'b', 'c'],
            Collection::fromFile(__DIR__ . '/../fixtures/sample.txt')
        );
    }

    public function testFromGeneratorConstructor()
    {
        $generator = static function () {
            yield 'a';

            yield 'b';

            yield 'c';

            yield 'd';

            yield 'e';
        };

        self::assertIdenticalIterable(
            range('a', 'e'),
            Collection::fromGenerator($generator())
        );

        $generator = (static function () {
            yield 'a';

            yield 'b';

            yield 'c';

            yield 'd';

            yield 'e';
        })();

        $generator->next();
        $generator->next();

        self::assertIdenticalIterable(
            [2 => 'c', 3 => 'd', 4 => 'e'],
            Collection::fromGenerator($generator)
        );
    }

    public function testFromIterableConstructor(): void
    {
        self::assertIdenticalIterable(
            ['A', 'B', 'C'],
            Collection::fromIterable(range('A', 'C'))
        );

        $generator = (static function () {
            yield 'a';

            yield 'b';

            yield 'c';

            yield 'd';

            yield 'e';
        })();

        $generator->next();
        $generator->next();

        self::assertIdenticalIterable(
            [2 => 'c', 3 => 'd', 4 => 'e'],
            Collection::fromIterable($generator)
        );
    }

    public function testFromResourceConstructor()
    {
        $string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

        $stream = fopen('data://text/plain,' . $string, 'rb');

        self::assertCount(
            56,
            Collection::fromResource($stream)
        );

        $stream = fopen('data://text/plain,' . $string, 'rb');

        self::assertIdenticalIterable(
            str_split($string),
            Collection::fromResource($stream)
        );

        $this->expectException(InvalidArgumentException::class);

        $stream = imagecreate(100, 100);

        Collection::fromResource($stream)->all();
    }

    public function testFromStringConstructor(): void
    {
        self::assertIdenticalIterable(
            ['i', 'z', 'u', 'm', 'i'],
            Collection::fromString('izumi')
        );

        self::assertIdenticalIterable(
            [0 => 'hello', 1 => ' world'],
            Collection::fromString('hello, world', ',')
        );
    }

    public function testRangeConstructor(): void
    {
        $this::assertIdenticalIterable(
            [(float) 0, (float) 1, (float) 2, (float) 3, (float) 4],
            Collection::range(0, 5),
        );

        $this::assertIdenticalIterable(
            [(float) 1, (float) 3, (float) 5, (float) 7, (float) 9],
            Collection::range(1, 10, 2),
        );

        $this::assertIdenticalIterable(
            [0 => (float) -5, 1 => (float) -3, 2 => (float) -1, 3 => (float) 1, 4 => (float) 3],
            Collection::range(-5, 5, 2),
        );

        $this::assertIdenticalIterable(
            [0 => (float) 0, 1 => (float) 1, 2 => (float) 2, 3 => (float) 3, 4 => (float) 4, 5 => (float) 5, 6 => (float) 6, 7 => (float) 7, 8 => (float) 8, 9 => (float) 9],
            Collection::range()->limit(10)
        );

        $this::assertIdenticalIterable(
            array_pad([], 10, (float) 0),
            Collection::range(0, INF, 0)->limit(10)
        );

        $this::assertIdenticalIterable(
            [(float) 1, (float) 2, (float) 3, (float) 4],
            Collection::range(1, 5)
        );

        $this::assertIdenticalIterable(
            array_pad([], 5, (float) 1),
            Collection::range(1, 5, 0)->limit(5)
        );

        $this::assertIdenticalIterable(
            [(float) 0],
            Collection::range(0, 1)
        );

        $this::assertIdenticalIterable(
            [(float) 0, (float) 1, (float) 2, (float) 3, (float) 4],
            Collection::range()->limit(5)
        );
    }

    public function testTimesConstructor(): void
    {
        $a = [[1, 2, 3, 4, 5], [1, 2, 3, 4, 5]];

        $this::assertIdenticalIterable(
            $a,
            Collection::times(2, static fn (): array => range(1, 5)),
        );

        $this::assertIdenticalIterable(
            [],
            Collection::times(-1, 'count'),
        );

        $this::assertIdenticalIterable(
            range(1, 10),
            Collection::times(10),
        );

        $this::assertIdenticalIterable(
            [],
            Collection::times(-5),
        );

        $this::assertIdenticalIterable(
            [1],
            Collection::times(1),
        );

        $this::assertIdenticalIterable(
            [],
            Collection::times(0),
        );

        $this::assertIdenticalIterable(
            [],
            Collection::times(),
        );
    }

    public function testUnfoldConstructor(): void
    {
        $this::assertIdenticalIterable(
            [[0], [2], [4], [6], [8]],
            Collection::unfold(static fn (int $n): array => [$n + 2], [-2])->limit(5)
        );
    }
}
