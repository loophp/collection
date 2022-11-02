<?php

declare(strict_types=1);

namespace tests\loophp\collection\Traits;

use ArrayObject;
use Closure;
use Doctrine\Common\Collections\Criteria;
use Generator;
use IteratorAggregate;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Operation\AbstractOperation;
use stdClass;

use const PHP_EOL;
use const PHP_INT_MAX;
use const PHP_INT_MIN;
use const PHP_VERSION_ID;

/**
 * @internal
 */
trait GenericCollectionProviders
{
    public function allOperationProvider()
    {
        $operation = 'all';

        $generator = static function (): Generator {
            yield 0 => '1';

            yield 1 => '2';

            yield 2 => '3';

            yield 0 => '5';

            yield 1 => '6';
        };

        yield [
            $operation,
            [],
            $generator(),
            ['1', '2', '3', '5', '6'],
        ];

        yield [
            $operation,
            [false],
            $generator(),
            ['5', '6', '3'],
        ];
    }

    public function appendOperationProvider()
    {
        $operation = 'append';

        $generator = static function (): Generator {
            yield 0 => '1';

            yield 1 => '2';

            yield 2 => '3';

            yield 0 => '5';

            yield 1 => '6';
        };

        yield [
            $operation,
            ['5', '6'],
            ['1', '2', '3'],
            $generator(),
        ];
    }

    public function applyOperationProvider()
    {
        $operation = 'apply';

        yield [
            $operation,
            [],
            range('a', 'd'),
            range('a', 'd'),
        ];
    }

    public function associateOperationProvider()
    {
        $operation = 'associate';

        $input = range(1, 10);

        yield [
            $operation,
            [],
            $input,
            $input,
        ];

        yield [
            $operation,
            [
                static function (int $key, int $value): int {
                    return $key * 2;
                },
                static function (int $value, int $key): int {
                    return $value * 2;
                },
            ],
            $input,
            [
                0 => 2,
                2 => 4,
                4 => 6,
                6 => 8,
                8 => 10,
                10 => 12,
                12 => 14,
                14 => 16,
                16 => 18,
                18 => 20,
            ],
        ];
    }

    public function asyncMapNOperationProvider()
    {
        $operation = 'asyncMapN';
        $input = ['c' => 2, 'b' => 1, 'a' => 0];
        $output = ['a' => 0, 'b' => 2, 'c' => 4];

        yield [
            $operation,
            [
                static function (int $v): int {
                    sleep($v);

                    return $v;
                },
                static fn (int $v): int => $v * 2,
            ],
            $input,
            $output,
        ];
    }

    public function asyncMapOperationProvider()
    {
        $operation = 'asyncMap';
        $input = ['c' => 2, 'b' => 1, 'a' => 0];
        $output = ['a' => 0, 'b' => 2, 'c' => 4];

        yield [
            $operation,
            [
                static function (int $v): int {
                    sleep($v);

                    return $v * 2;
                },
            ],
            $input,
            $output,
        ];
    }

    public function averagesOperationProvider()
    {
        $operation = 'averages';
        $input = array_combine(range('a', 'f'), range(0, 5));

        yield [
            $operation,
            [],
            $input,
            [(int) 0, (float) .5, (float) 1.0, (float) 1.5, (float) 2.0, (float) 2.5],
        ];

        yield [
            $operation,
            [],
            [],
            [],
        ];
    }

    public function cacheOperationProvider()
    {
        $operation = 'cache';
        $input = range('A', 'E');

        yield [
            $operation,
            [],
            $input,
            $input,
        ];
    }

    public function chunkOperationProvider()
    {
        $operation = 'chunk';
        $input = range('A', 'F');
        $output = [[0 => 'A', 1 => 'B'], [0 => 'C', 1 => 'D'], [0 => 'E', 1 => 'F']];

        yield [
            $operation,
            [2],
            $input,
            $output,
        ];

        yield [
            $operation,
            [0],
            $input,
            [],
        ];

        yield [
            $operation,
            [1],
            $input,
            [[0 => 'A'], [0 => 'B'], [0 => 'C'], [0 => 'D'], [0 => 'E'], [0 => 'F']],
        ];

        yield [
            $operation,
            [2, 3],
            $input,
            [[0 => 'A', 1 => 'B'], [0 => 'C', 1 => 'D', 2 => 'E'], [0 => 'F']],
        ];
    }

    public function coalesceOperationProvider()
    {
        $operation = 'coalesce';
        $input = range('a', 'e');
        $output = [0 => 'a'];

        yield [
            $operation,
            [],
            $input,
            $output,
        ];

        $input = ['', null, 'foo', false, ...range('a', 'e')];

        yield [
            $operation,
            [],
            $input,
            [2 => 'foo'],
        ];
    }

    public function collapseOperationProvider()
    {
        $operation = 'collapse';
        $input = [
            ['A', 'B', 'foo' => 'C'],
            'D',
            ['E', 'F'],
            'G',
        ];
        $output = static function () {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 'foo' => 'C';

            yield 0 => 'E';

            yield 1 => 'F';
        };

        yield [
            $operation,
            [],
            $input,
            $output(),
        ];

        yield [
            $operation,
            [],
            range('A', 'E'),
            [],
        ];
    }

    public function columnOperationProvider()
    {
        $operation = 'column';

        $input = [
            [
                'id' => 2135,
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            [
                'id' => 3245,
                'first_name' => 'Sally',
                'last_name' => 'Smith',
            ],
            [
                'id' => 5342,
                'first_name' => 'Jane',
                'last_name' => 'Jones',
            ],
            [
                'id' => 5623,
                'first_name' => 'Peter',
                'last_name' => 'Doe',
            ],
        ];

        yield [
            $operation,
            ['first_name'],
            $input,
            [0 => 'John', 1 => 'Sally', 2 => 'Jane', 3 => 'Peter'],
        ];

        yield [
            $operation,
            ['middle_name'],
            $input,
            [],
        ];

        yield [
            $operation,
            [['id']],
            [
                (static fn () => yield ['id'] => 1234)(),
                (static fn () => yield ['id'] => 4567)(),
            ],
            [0 => 1234, 1 => 4567],
        ];
    }

    public function combinateOperationProvider()
    {
        $operation = 'combinate';
        $parameters = [0];
        $input = range('a', 'c');
        $output = [
            [
                0 => 'a',
                1 => 'b',
                2 => 'c',
            ],
        ];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $parameters = [1];
        $output = [
            [
                'a',
            ],
            [
                'b',
            ],
            [
                'c',
            ],
        ];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $output = static function () {
            yield 0 => [
                0 => 'a',
            ];

            yield 1 => [
                0 => 'b',
            ];

            yield 2 => [
                0 => 'c',
            ];

            yield 0 => [
                0 => 'a',
                1 => 'b',
            ];

            yield 1 => [
                0 => 'a',
                1 => 'c',
            ];

            yield 2 => [
                0 => 'b',
                1 => 'c',
            ];

            yield 0 => [
                0 => 'a',
                1 => 'b',
                2 => 'c',
            ];
        };

        yield [
            $operation,
            [],
            $input,
            $output(),
        ];
    }

    public function combineOperationProvider()
    {
        $operation = 'combine';
        $parameters = [...range('e', 'a')];
        $input = range('A', 'E');
        $output = ['e' => 'A', 'd' => 'B', 'c' => 'C', 'b' => 'D', 'a' => 'E'];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $input = range('a', 'e');
        $parameters = [...range('a', 'c')];
        $output = static function () {
            yield 'a' => 'a';

            yield 'b' => 'b';

            yield 'c' => 'c';

            yield null => 'd';

            yield null => 'e';
        };

        yield [
            $operation,
            $parameters,
            $input,
            $output(),
        ];

        $input = range('a', 'c');
        $parameters = [...range('a', 'e')];
        $output = static function () {
            yield 'a' => 'a';

            yield 'b' => 'b';

            yield 'c' => 'c';

            yield 'd' => null;

            yield 'e' => null;
        };

        yield [
            $operation,
            $parameters,
            $input,
            $output(),
        ];
    }

    public function compactOperationProvider()
    {
        $operation = 'compact';
        $parameters = [];
        $input = ['a', 1 => 'b', null, false, 0, 'c', ''];
        $output = ['a', 1 => 'b', 5 => 'c'];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $output = ['a', 1 => 'b', 3 => false, 5 => 'c', ''];
        $parameters = [null, 0];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];
    }

    /**
     * @return iterable<array{0: string, 1: array, 2: iterable, 3: iterable}>
     */
    public function compareOperationProvider(): iterable
    {
        $operation = 'compare';

        $callback = static fn (int $left, int $right): int => $left < $right ? $left : $right;

        yield [
            $operation,
            [$callback],
            [1, 2, 3, 4, 5],
            1,
        ];

        yield [
            $operation,
            [$callback, -42],
            [],
            -42,
        ];

        $callback = static fn (int $left, int $right): int => $left > $right ? $left : $right;

        yield [
            $operation,
            [$callback],
            [1, 2, 3, 4, 5],
            5,
        ];

        $callback = static fn (string $left, string $right): string => min($left, $right);

        yield [
            $operation,
            [$callback],
            ['foo' => 'f', 'bar' => 'b', 'tar' => 't'],
            'b',
        ];

        $callback = static fn (stdClass $carry, stdClass $current): stdClass => $current->age < $carry->age
            ? $current
            : $carry;

        $expected = (object) ['id' => 2, 'age' => 3];

        yield [
            $operation,
            [$callback],
            [(object) ['id' => 1, 'age' => 5], $expected, (object) ['id' => 3, 'age' => 12]],
            $expected,
        ];
    }

    public function containsOperationProvider()
    {
        $operation = 'contains';

        $input = range('A', 'C');
        $parameters = ['A'];
        $output = true;

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $parameters = ['unknown'];
        $output = false;

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $parameters = ['C', 'A'];
        $output = true;

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $parameters = ['C', 'unknown', 'A'];
        $output = true;

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $input = ['a' => 'b', 'c' => 'd'];
        $parameters = ['d'];
        $output = true;

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];
    }

    public function countOperationProvider()
    {
        $operation = 'count';

        yield [
            $operation,
            [],
            range('A', 'C'),
            3,
        ];
    }

    public function currentOperationProvider()
    {
        $input = array_combine(range('A', 'E'), range('A', 'E'));

        $operation = 'current';

        yield [
            $operation,
            [],
            $input,
            'A',
        ];

        yield [
            $operation,
            [1],
            $input,
            'B',
        ];

        yield [
            $operation,
            [10],
            $input,
            null,
        ];
    }

    public function cycleOperationProvider()
    {
        $operation = 'cycle';
        $output = static function () {
            yield 0 => 'a';

            yield 1 => 'b';

            yield 2 => 'c';

            yield 0 => 'a';

            yield 1 => 'b';

            yield 2 => 'c';
        };

        yield [
            $operation,
            [],
            range('a', 'c'),
            $output(),
            6,
        ];
    }

    public function diffKeysOperationProvider()
    {
        $operation = 'diffKeys';
        $input = array_combine(range('a', 'e'), range(1, 5));

        $parameters = ['b', 'd'];

        yield [
            $operation,
            $parameters,
            $input,
            ['a' => 1, 'c' => 3, 'e' => 5],
        ];

        yield [
            $operation,
            [],
            $input,
            $input,
        ];
    }

    public function diffOperationProvider()
    {
        $operation = 'diff';
        $parameters = [1, 2, 3, 9];
        $input = range(1, 5);

        yield [
            $operation,
            $parameters,
            $input,
            [3 => 4, 4 => 5],
        ];

        yield [
            $operation,
            [],
            $input,
            $input,
        ];

        yield [
            $operation,
            [...Collection::fromIterable(range(2, 5))],
            $input,
            [0 => 1],
        ];

        yield [
            $operation,
            [...Collection::fromIterable(['f'])],
            ['foo' => 'f', 'bar' => 'b'],
            ['bar' => 'b'],
        ];

        yield [
            $operation,
            ['F', 'b'],
            ['foo' => 'f', 'bar' => 'b'],
            ['foo' => 'f'],
        ];

        if (PHP_VERSION_ID >= 80_000) {
            yield [
                $operation,
                ['foo' => 'f'],
                ['foo' => 'f', 'bar' => 'b'],
                ['bar' => 'b'],
            ];

            yield [
                $operation,
                array_values(['foo' => 'F', 'bar' => 'b']),
                ['foo' => 'f', 'bar' => 'b'],
                ['foo' => 'f'],
            ];
        }
    }

    public function distinctOperationProvider()
    {
        $operation = 'distinct';

        $stdclass = new stdClass();

        $parameters = [];
        $input = [1, 1, 2, 2, 3, 3, $stdclass, $stdclass];
        $output = [0 => 1, 2 => 2, 4 => 3, 6 => $stdclass];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $input = ['foo' => 'f', 'bar' => 'b', 'baz' => 'f'];
        $output = ['foo' => 'f', 'bar' => 'b'];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        $cat = static fn (string $name) => new class($name) {
            private string $name;

            public function __construct(string $name)
            {
                $this->name = $name;
            }

            public function name(): string
            {
                return $this->name;
            }
        };

        $cats = [
            $cat1 = $cat('izumi'),
            $cat2 = $cat('nakano'),
            $cat3 = $cat('booba'),
            $cat3,
        ];

        $input = $cats;
        $output = [$cat1, $cat2, $cat3];

        yield [
            $operation,
            $parameters,
            $input,
            $output,
        ];

        yield [
            $operation,
            [
                static fn (object $left) => static fn (object $right) => $left->name() === $right->name(),
            ],
            $input,
            $output,
        ];

        yield [
            $operation,
            [
                static fn (string $left) => static fn (string $right) => $left === $right,
                static fn (object $cat): string => $cat->name(),
            ],
            $input,
            $output,
        ];

        yield [
            $operation,
            [
                null,
                static fn (object $cat): string => $cat->name(),
            ],
            $input,
            $output,
        ];
    }

    public function dropOperationProvider()
    {
        $operation = 'drop';
        $input = range('A', 'F');

        yield [
            $operation,
            [3],
            $input,
            [3 => 'D', 4 => 'E', 5 => 'F'],
        ];

        yield [
            $operation,
            [6],
            $input,
            [],
        ];
    }

    public function dropWhileOperationProvider()
    {
        $operation = 'dropWhile';
        $input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3];

        yield [
            $operation,
            [
                static function (int $value): bool {
                    return 3 > $value;
                },
                static function (int $value): bool {
                    return 5 > $value;
                },
            ],
            $input,
            [
                4 => 5,
                5 => 6,
                6 => 7,
                7 => 8,
                8 => 9,
                9 => 1,
                10 => 2,
                11 => 3,
            ],
        ];

        yield [
            $operation,
            [
                static function (int $value): bool {
                    return 3 > $value;
                },
            ],
            $input,
            [
                2 => 3,
                3 => 4,
                4 => 5,
                5 => 6,
                6 => 7,
                7 => 8,
                8 => 9,
                9 => 1,
                10 => 2,
                11 => 3,
            ],
        ];
    }

    public function dumpOperationProvider()
    {
        $operation = 'dump';
        $input = range('A', 'E');

        yield [
            $operation,
            [],
            $input,
            $input,
        ];
    }

    public function duplicateOperationProvider()
    {
        $operation = 'duplicate';

        yield [
            $operation,
            [],
            ['a', 'b', 'c', 'a', 'c'],
            [3 => 'a', 4 => 'c'],
        ];

        $cat = static fn (string $name) => new class($name) {
            private string $name;

            public function __construct(string $name)
            {
                $this->name = $name;
            }

            public function name(): string
            {
                return $this->name;
            }
        };

        $cats = [
            $cat1 = $cat('booba'),
            $cat2 = $cat('lola'),
            $cat3 = $cat('lalee'),
            $cat3,
        ];

        yield [
            $operation,
            [],
            $cats,
            [3 => $cat3],
        ];

        yield [
            $operation,
            [
                static fn (object $left) => static fn (object $right) => $left->name() === $right->name(),
            ],
            $cats,
            [3 => $cat3],
        ];

        yield [
            $operation,
            [
                static fn (string $left) => static fn (string $right) => $left === $right,
                static fn (object $cat): string => $cat->name(),
            ],
            $cats,
            [3 => $cat3],
        ];

        yield [
            $operation,
            [
                null,
                static fn (object $cat): string => $cat->name(),
            ],
            $cats,
            [3 => $cat3],
        ];
    }

    public function equalsOperationProvider()
    {
        $operation = 'equals';

        $a = (object) ['id' => 'a'];
        $a2 = (object) ['id' => 'a'];
        $b = (object) ['id' => 'b'];

        // empty variations
        yield [
            $operation,
            [
                Collection::empty(),
            ],
            [],
            true,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable([1]),
            ],
            [],
            false,
        ];

        yield [
            $operation,
            [
                Collection::empty(),
            ],
            [1],
            false,
        ];

        // same elements, same order
        yield [
            $operation,
            [
                Collection::fromIterable([1, 2, 3]),
            ],
            [1, 2, 3],
            true,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable([$a, $b]),
            ],
            [$a, $b],
            true,
        ];

        // same elements, different order
        yield [
            $operation,
            [
                Collection::fromIterable([3, 1, 2]),
            ],
            [1, 2, 3],
            true,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable([$b, $a]),
            ],
            [$a, $b],
            true,
        ];

        // same lengths, with one element different
        yield [
            $operation,
            [
                Collection::fromIterable([1, 2, 4]),
            ],
            [1, 2, 3],
            false,
        ];

        // different lengths, extra elements in first
        yield [
            $operation,
            [
                Collection::fromIterable([1, 2, 3]),
            ],
            [1, 2, 3, 4],
            false,
        ];

        // different lengths, extra elements in second
        yield [
            $operation,
            [
                Collection::fromIterable([1, 2, 3, 4]),
            ],
            [1, 2, 3],
            false,
        ];

        // objects, different instances and contents
        yield [
            $operation,
            [
                Collection::fromIterable([$b]),
            ],
            [$a],
            false,
        ];

        // objects, different instances but same contents
        yield [
            $operation,
            [
                Collection::fromIterable([$a2]),
            ],
            [$a],
            false,
        ];

        // "maps" with string keys and values
        yield [
            $operation,
            [
                Collection::fromIterable(['foo' => 'f', 'bar' => 'b']),
            ],
            ['foo' => 'f', 'bar' => 'b'],
            true,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable(['bar' => 'b', 'foo' => 'f']),
            ],
            ['foo' => 'f', 'bar' => 'b'],
            true,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable(['bar' => 'f']),
            ],
            ['foo' => 'f'],
            true,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable(['bar' => 'b']),
            ],
            ['foo' => 'f', 'bar' => 'b'],
            false,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable(['bar' => 'b']),
            ],
            ['foo' => 'f'],
            false,
        ];

        yield [
            $operation,
            [
                Collection::fromIterable(['foo' => 'f', 'bar' => 'b']),
            ],
            ['foo' => 'f'],
            false,
        ];
    }

    public function everyOperationProvider()
    {
        $operation = 'every';
        $input = range(0, 10);
        $callback = static fn ($value): bool => 20 > $value;

        yield [$operation, [$callback], $input, true];

        yield [$operation, [$callback], [], true];

        yield [
            $operation,
            [
                static fn ($value, $key): bool => is_numeric($key),
            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn ($value, $key, iterable $iterable): bool => $iterable instanceof IteratorAggregate,
            ],
            $input,
            true,
        ];

        $callback1 = static fn ($value, $key): bool => 20 > $value;

        yield [
            $operation,
            [
                $callback1,
            ],
            $input,
            true,
        ];

        $callback2 = static fn ($value, $key): bool => 50 < $value;

        yield [
            $operation,
            [
                $callback2,
            ],
            $input,
            false,
        ];

        yield [
            $operation,
            [
                $callback2,
                $callback1,
            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn (string $value): bool => is_numeric($value),
            ],
            explode('-', '2021-04-09xxx'),
            false,
        ];
    }

    public function explodeOperationProvider()
    {
        $operation = 'explode';
        $input = str_split('I am just a random piece of text.');
        $output = [
            0 => [
                0 => 'I',
                1 => ' ',
                2 => 'a',
                3 => 'm',
                4 => ' ',
                5 => 'j',
                6 => 'u',
                7 => 's',
                8 => 't',
                9 => ' ',
                10 => 'a',
                11 => ' ',
                12 => 'r',
                13 => 'a',
                14 => 'n',
                15 => 'd',
            ],
            1 => [
                0 => 'm',
                1 => ' ',
                2 => 'p',
                3 => 'i',
                4 => 'e',
                5 => 'c',
                6 => 'e',
                7 => ' ',
            ],
            2 => [
                0 => 'f',
                1 => ' ',
                2 => 't',
                3 => 'e',
                4 => 'x',
                5 => 't',
                6 => '.',
            ],
        ];

        yield [
            $operation,
            ['o'],
            $input,
            $output,
        ];
    }

    public function falsyOperationProvider()
    {
        $operation = 'falsy';

        yield [
            $operation,
            [],
            [false, false, false],
            true,
        ];

        yield [
            $operation,
            [],
            [false, true, false],
            false,
        ];

        yield [
            $operation,
            [],
            [1, 2, null],
            false,
        ];

        yield [
            $operation,
            [],
            [0, [], ''],
            true,
        ];
    }

    public function filterOperationProvider()
    {
        $operation = 'filter';
        $input = range(0, 10);

        yield [
            $operation,
            [
                static function ($value) {
                    return $value % 2;
                },
            ],
            $input,
            [1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9],
        ];

        yield [
            $operation,
            [
                static fn (int $value, int $key): bool => $value % 2 === 0 && 4 < $key,
            ],
            $input,
            [6 => 6, 8 => 8, 10 => 10],
        ];

        yield [
            $operation,
            [
                static fn (string $value): bool => 'a' === $value,
                static fn (string $value): bool => 'd' === $value,
            ],
            ['a', 'b', 'c', 'd'],
            [0 => 'a', 3 => 'd'],
        ];

        yield [
            $operation,
            [],
            [true, false, 0, '', null],
            [true],
        ];
    }

    public function findOperationProvider()
    {
        $operation = 'find';

        yield [
            $operation,
            [
                'missing',
                static fn ($value): bool => 'b' === $value,
            ],
            ['foo' => 'a', 'bar' => 'b'],
            'b',
        ];

        yield [
            $operation,
            [
                'missing',
                static fn ($value): bool => 'd' === $value,            ],
            ['foo' => 'a', 'bar' => 'b'],
            'missing',
        ];

        yield [
            $operation,
            [
                null, static fn ($value): bool => $value % 2 === 0,
            ],
            [1, 3, 5],
            null,
        ];

        yield [
            $operation,
            [
                -1, static fn ($value): bool => $value % 2 === 0,
            ],
            [1, 3, 5],
            -1,
        ];

        yield [
            $operation,
            [
                null,
                static fn ($value): bool => $value % 2 !== 0,
            ],
            [1, 3, 5],
            1,
        ];
    }

    public function firstOperationProvider()
    {
        $operation = 'first';

        yield [
            $operation,
            [],
            range(1, 10),
            1,
        ];

        yield [
            $operation,
            [],
            [],
            null,
        ];

        yield [
            $operation,
            [],
            ['foo' => 'bar', 'baz' => 'bar'],
            'bar',
        ];
    }

    public function flatMapOperationProvider()
    {
        $operation = 'flatMap';
        $input = range(1, 3);

        yield [
            $operation,
            [
                static fn (int $item, int $key): array => [$key => $item * $item],
            ],
            $input,
            [1, 4, 9],
        ];

        $gen = static function (): Generator {
            yield 0 => 1;

            yield 0 => 4;

            yield 0 => 9;
        };

        yield [
            $operation,
            [
                static fn (int $item): array => [$item * $item],
            ],
            $input,
            $gen(),
        ];

        $output = static function () {
            yield 0 => 2;

            yield 1 => 1;

            yield 0 => 4;

            yield 1 => 4;

            yield 0 => 6;

            yield 1 => 9;
        };

        yield [
            $operation,
            [
                static fn (int $item): Collection => Collection::fromIterable([$item + $item, $item * $item]),
            ],
            $input,
            $output(),
        ];

        $output = static function () {
            yield 0 => [2];

            yield 1 => [1];

            yield 0 => [4];

            yield 1 => [4];

            yield 0 => [6];

            yield 1 => [9];
        };

        yield [
            $operation,
            [
                static fn (int $item): array => [[$item + $item], [$item * $item]],
            ],
            $input,
            $output(),
        ];

        yield [
            $operation,
            [
                static fn (string $item, string $key): array => [$item => $key],
            ],
            ['foo' => 'f', 'bar' => 'b'],
            ['f' => 'foo', 'b' => 'bar'],
        ];

        $barGen = static function (): Generator {
            yield 0 => 'fbar';

            yield 0 => 'bbar';
        };

        yield [
            $operation,
            [
                static fn (string $item): array => [$item . 'bar'],
            ],
            ['foo' => 'f', 'bar' => 'b'],
            $barGen(),
        ];

        $gen = static function (): Generator {
            yield 0 => ['f' => 'foo'];

            yield 1 => ['FOO' => 'F'];

            yield 0 => ['b' => 'bar'];

            yield 1 => ['BAR' => 'B'];
        };

        yield [
            $operation,
            [
                static fn (string $item, string $key): array => [[$item => $key], [strtoupper($key) => strtoupper($item)]],
            ],
            ['foo' => 'f', 'bar' => 'b'],
            $gen(),
        ];
    }

    public function flattenOperationProvider()
    {
        $operation = 'flatten';
        $input = [
            ['a', 'b', 'c'],
            'd',
            ['d', ['e', 'f']],
        ];
        $output = static function (): Generator {
            yield 0 => 'a';

            yield 1 => 'b';

            yield 2 => 'c';

            yield 1 => 'd';

            yield 0 => 'd';

            yield 0 => 'e';

            yield 1 => 'f';
        };

        yield [
            $operation,
            [],
            $input,
            $output(),
        ];

        $output = static function (): Generator {
            yield 0 => 'a';

            yield 1 => 'b';

            yield 2 => 'c';

            yield 1 => 'd';

            yield 0 => 'd';

            yield 1 => ['e', 'f'];
        };

        yield [
            $operation,
            [1],
            $input,
            $output(),
        ];

        $output = static function (): Generator {
            yield 0 => 1;

            yield 0 => 2;

            yield 1 => 3;

            yield 2 => 4;
        };

        yield [
            $operation,
            [],
            [1, [2, 3], 4],
            $output(),
        ];
    }

    public function flipOperationProvider()
    {
        $operation = 'flip';
        $input = range('A', 'E');
        $output = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4];

        yield [
            $operation,
            [],
            $input,
            $output,
        ];

        $input = static function () {
            yield 'a' => 0;

            yield 'a' => 0;

            yield 'b' => 1;

            yield 'b' => 1;
        };

        $output = static function () {
            yield 0 => 'a';

            yield 0 => 'a';

            yield 1 => 'b';

            yield 1 => 'b';
        };

        yield [
            $operation,
            [],
            $input(),
            $output(),
        ];
    }

    public function foldLeft1OperationProvider()
    {
        $operation = 'foldLeft1';

        $callback = static function ($carry, $value) {
            return $carry / $value;
        };

        yield [
            $operation,
            [
                $callback,
            ],
            [64, 4, 2, 8],
            1,
        ];

        yield [
            $operation,
            [
                $callback,
            ],
            [12],
            12,
        ];
    }

    public function foldLeftOperationProvider()
    {
        $operation = 'foldLeft';

        yield [
            $operation,
            [
                static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string), 'foo',
                null
            ],
            [],
            'foo',
        ];

        yield [
            $operation,
            [
                static function (string $carry, string $item): string {
                    $carry .= $item;

                    return $carry;
                },
                '',
            ],
            range('A', 'C'),
            'ABC',
        ];

        yield [
            $operation,
            [
                static function (string $carry, string $item): string {
                    $carry .= $item;

                    return $carry;
                },
                null
            ],
            [],
            null,
        ];

        yield [
            $operation,
            [
                static function (string $carry, string $item): string {
                    $carry .= $item;

                    return $carry;
                },
                'foo',
            ],
            [],
            'foo',
        ];
    }

    public function foldRight1OperationProvider()
    {
        $operation = 'foldRight1';

        $callback = static function ($carry, $value) {
            return $value / $carry;
        };

        yield [
            $operation,
            [
                $callback,
            ],
            [8, 12, 24, 4],
            4,
        ];

        yield [
            $operation,
            [
                $callback,
            ],
            [12],
            12,
        ];
    }

    public function foldRightOperationProvider()
    {
        $operation = 'foldRight';

        yield [
            $operation,
            [
                static function (string $carry, string $item): string {
                    $carry .= $item;

                    return $carry;
                },
                '',
            ],
            range('A', 'C'),
            'CBA',
        ];
    }

    public function forgetOperationProvider()
    {
        yield [
            'forget',
            [0, 4],
            range('A', 'E'),
            [1 => 'B', 2 => 'C', 3 => 'D'],
        ];
    }

    public function frequencyOperationProvider()
    {
        $object = new StdClass();
        $input = ['1', '2', '3', null, '4', '2', null, '6', $object, $object];
        $output = static function () use ($object): Generator {
            yield 1 => '1';

            yield 2 => '2';

            yield 1 => '3';

            yield 2 => null;

            yield 1 => '4';

            yield 1 => '6';

            yield 2 => $object;
        };

        yield [
            'frequency',
            [],
            $input,
            $output(),
        ];
    }

    public function getOperationProvider()
    {
        $operation = 'get';
        $input = range('A', 'E');

        yield [
            $operation,
            [4],
            $input,
            'E',
        ];

        yield [
            $operation,
            ['unexistent key', 'default'],
            $input,
            'default',
        ];
    }

    public function groupByOperationProvider()
    {
        $operation = 'groupBy';

        $input = static function () {
            yield 1 => 'a';

            yield 1 => 'b';

            yield 1 => 'c';

            yield 2 => 'd';

            yield 2 => 'e';

            yield 3 => 'f';

            yield 4 => 'g';

            yield 10 => 'h';
        };

        yield [
            $operation,
            [
                static fn (string $value, int $key): int => $key,
            ],
            $input(),
            [
                1 => [
                    'a',
                    'b',
                    'c',
                ],
                2 => [
                    'd',
                    'e',
                ],
                3 => ['f'],
                4 => ['g'],
                10 => ['h'],
            ],
        ];

        yield [
            $operation,
            [
                static function (int $value, int $key) {
                    return 0 === ($value % 2) ? 'even' : 'odd';
                },
            ],
            range(0, 20),
            [
                'even' => [
                    0,
                    2,
                    4,
                    6,
                    8,
                    10,
                    12,
                    14,
                    16,
                    18,
                    20,
                ],
                'odd' => [
                    1,
                    3,
                    5,
                    7,
                    9,
                    11,
                    13,
                    15,
                    17,
                    19,
                ],
            ],
        ];
    }

    public function groupOperationProvider()
    {
        $operation = 'group';

        $input = str_split('Mississippi');
        $output = [
            0 => [0 => 'M'],
            1 => [0 => 'i'],
            2 => [0 => 's', 1 => 's'],
            3 => [0 => 'i'],
            4 => [0 => 's', 1 => 's'],
            5 => [0 => 'i'],
            6 => [0 => 'p', 1 => 'p'],
            7 => [0 => 'i'],
        ];

        yield [
            $operation,
            [],
            $input,
            $output,
        ];

        yield [
            $operation,
            [],
            str_split('aabbcc'),
            [
                0 => [0 => 'a', 1 => 'a'],
                1 => [0 => 'b', 1 => 'b'],
                2 => [0 => 'c', 1 => 'c'],
            ],
        ];

        yield [
            $operation,
            [],
            [],
            [],
        ];
    }

    public function hasOperationProvider()
    {
        $operation = 'has';
        $input = range('A', 'C');

        yield [
            $operation,
            [
                static fn () => 'A',
            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn () => 'Z',
            ],
            $input,
            false,
        ];

        $input = ['b', 1, 'foo', 'bar'];

        yield [
            $operation,
            [
                static fn () => 'foo',
            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn () => 'unknown',
            ],
            $input,
            false,
        ];

        yield [
            $operation,
            [
                static fn ($v) => $v,
            ],
            [],
            false,
        ];

        yield [
            $operation,
            [
                static fn () => 1,
                static fn () => 'bar',            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn () => 'coin',
                static fn () => 'bar',
            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn ($value, $key) => 5 < $key ? 'bar' : 'coin',
            ],
            $input,
            false,
        ];
    }

    public function headOperationProvider()
    {
        $operation = 'head';

        yield [
            $operation,
            [],
            range(1, 10),
            1,
        ];

        yield [
            $operation,
            [],
            [],
            null,
        ];

        yield [
            $operation,
            [],
            ['foo' => 'bar', 'baz' => 'bar'],
            'bar',
        ];
    }

    public function ifThenElseOperationProvider()
    {
        $operation = 'ifThenElse';
        $input = range(1, 5);

        $condition = static function ($value) {
            return 0 === $value % 2;
        };

        $then = static function ($value) {
            return $value * $value;
        };

        $else = static function ($value) {
            return $value + 2;
        };

        yield [
            $operation,
            [$condition, $then],
            $input,
            [
                1, 4, 3, 16, 5,
            ],
        ];

        yield [
            $operation,
            [$condition, $then, $else],
            $input,
            [
                3, 4, 5, 16, 7,
            ],
        ];
    }

    public function implodeOperationProvider()
    {
        $operation = 'implode';
        $input = range('A', 'C');

        yield [
            $operation,
            ['-'],
            $input,
            'A-B-C',
        ];

        yield [
            $operation,
            [],
            $input,
            'ABC',
        ];

        yield [
            $operation,
            [],
            [],
            '',
        ];
    }

    public function initOperationProvider()
    {
        $operation = 'init';

        yield [
            $operation,
            [],
            range(0, 4),
            range(0, 3),
        ];

        yield [
            $operation,
            [],
            [
                ['a'],
                ['b', 'a'],
                ['c', 'b', 'a'],
                ['d', 'c', 'b', 'a'],
            ],
            [
                ['a'],
                ['b', 'a'],
                ['c', 'b', 'a'],
            ],
        ];
    }

    public function initsOperationProvider()
    {
        $operation = 'inits';

        yield [
            $operation,
            [],
            range('a', 'c'),
            [
                [],
                [[0, 'a']],
                [[0, 'a'], [1, 'b']],
                [[0, 'a'], [1, 'b'], [2, 'c']],
            ],
        ];

        $gen = static function (): Generator {
            yield true => 'true';

            yield false => 'false';

            yield [] => 'array';
        };

        yield [
            $operation,
            [],
            $gen(),
            [
                [],
                [[true, 'true']],
                [[true, 'true'], [false, 'false']],
                [[true, 'true'], [false, 'false'], [[], 'array']],
            ],
        ];
    }

    public function intersectKeysOperationProvider()
    {
        $operation = 'intersectKeys';
        $input = array_combine(range('a', 'e'), range(1, 5));

        yield [
            $operation,
            ['b', 'd'],
            $input,
            ['b' => 2, 'd' => 4],
        ];

        yield [
            $operation,
            [],
            $input,
            [],
        ];

        yield [
            $operation,
            [0, 1, 3],
            range('A', 'E'),
            [0 => 'A', 1 => 'B', 3 => 'D'],
        ];
    }

    public function intersectOperationProvider()
    {
        $operation = 'intersect';

        yield [
            $operation,
            [1, 2, 3, 9],
            range(1, 5),
            range(1, 3),
        ];

        yield [
            $operation,
            [],
            range(1, 5),
            [],
        ];
    }

    public function intersperseOperationProvider()
    {
        $operation = 'intersperse';
        $output = static function () {
            yield 0 => 'foo';

            yield 0 => 'A';

            yield 1 => 'foo';

            yield 1 => 'B';

            yield 2 => 'foo';

            yield 2 => 'C';
        };

        yield [
            $operation,
            ['foo'],
            range('A', 'C'),
            $output(),
        ];

        $output = static function () {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'foo';

            yield 2 => 'C';
        };

        yield [
            $operation,
            ['foo', 1, 2],
            range('A', 'C'),
            $output(),
        ];

        $output = static function () {
            yield 0 => 'foo';

            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'foo';

            yield 2 => 'C';

            yield 3 => 'D';

            yield 4 => 'foo';

            yield 4 => 'E';
        };

        yield [
            $operation,
            ['foo', 2, 0],
            range('A', 'E'),
            $output(),
        ];

        $output = static function () {
            yield 0 => 'A';

            yield 1 => 'foo';

            yield 1 => 'B';

            yield 2 => 'C';

            yield 3 => 'foo';

            yield 3 => 'D';

            yield 4 => 'E';
        };

        yield [
            $operation,
            ['foo', 2, 1],
            range('A', 'E'),
            $output(),
        ];

        $output = static function () {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'foo';

            yield 2 => 'C';

            yield 3 => 'D';

            yield 4 => 'foo';

            yield 4 => 'E';
        };

        yield [
            $operation,
            ['foo', 2, 2],
            range('A', 'E'),
            $output(),
        ];

        // TODO: Handle exceptions
        /*
        $this::fromIterable(range('A', 'F'))
                ->intersperse('foo', -1, 1)
                ->shouldThrow(Exception::class)
                ->during('all');

            $this::fromIterable(range('A', 'F'))
                ->intersperse('foo', 1, -1)
                ->shouldThrow(Exception::class)
                ->during('all');
         */
    }

    public function isEmptyOperationProvider()
    {
        $operation = 'isEmpty';
        $gen = static fn (): Generator => yield from [];

        yield [
            $operation,
            [],
            [],
            true,
        ];

        yield [
            $operation,
            [],
            $gen(),
            true,
        ];

        yield [
            $operation,
            [],
            [null],
            false,
        ];

        yield [
            $operation,
            [],
            [[]],
            false,
        ];

        yield [
            $operation,
            [],
            [1, 2, 3],
            false,
        ];

        $withValues = Collection::fromIterable([1, 2, 3]);

        foreach ($withValues as $value);
        // iterating once through it

        yield [
            $operation,
            [],
            $withValues,
            false,
        ];

        $withoutValues = Collection::fromIterable([]);

        foreach ($withoutValues as $value);
        // iterating once through it

        yield [
            $operation,
            [],
            $withoutValues,
            true,
        ];
    }

    public function jsonSerializeOperationProvider()
    {
        $input = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        yield [
            'jsonSerialize',
            [],
            $input,
            $input,
        ];
    }

    public function keyOperationProvider()
    {
        $operation = 'key';
        $input = array_combine(range('A', 'E'), range('A', 'E'));

        yield [
            $operation,
            [],
            $input,
            'A',
        ];

        yield [
            $operation,
            [1],
            $input,
            'B',
        ];

        yield [
            $operation,
            [10],
            $input,
            null,
        ];
    }

    public function keysOperationProvider()
    {
        yield [
            'keys',
            [],
            range('A', 'E'),
            range(0, 4),
        ];
    }

    public function lastOperationProvider()
    {
        $operation = 'last';

        yield [
            $operation,
            [],
            range('A', 'F'),
            'F',
        ];

        yield [
            $operation,
            [],
            ['A'],
            'A',
        ];

        yield [
            $operation,
            [],
            [],
            null,
        ];

        yield [
            $operation,
            [],
            ['foo' => 'bar', 'baz' => 'bar'],
            'bar',
        ];

        $input = [
            ['a'],
            ['b', 'a'],
            ['c', 'b', 'a'],
            ['d', 'c', 'b', 'a'],
        ];

        yield [
            $operation,
            [],
            $input,
            ['d', 'c', 'b', 'a'],
        ];
    }

    public function limitOperationProvider()
    {
        $operation = 'limit';
        $input = range('A', 'E');

        yield [
            $operation,
            [3],
            $input,
            range('A', 'C'),
        ];

        // TODO: Handle exception
        /*
            $this::fromIterable($input)
                ->limit(0)
                ->shouldThrow(OutOfBoundsException::class)
                ->during('all');
         */
    }

    public function linesOperationProvider()
    {
        $string = <<<'EOF'
            The quick brow fox jumps over the lazy dog.

            This is another sentence.
            EOF;

        $output = [
            'The quick brow fox jumps over the lazy dog.',
            '',
            'This is another sentence.',
        ];

        yield [
            'lines',
            [],
            str_split($string),
            $output,
        ];
    }

    public function mapNOperationProvider()
    {
        $operation = 'mapN';

        yield [
            $operation,
            [
                static fn (string $item): string => $item . $item,
            ],
            array_combine(range('A', 'C'), range('A', 'C')),
            ['A' => 'AA', 'B' => 'BB', 'C' => 'CC'],
        ];

        $square = static fn (int $a): int => $a ** 2;
        $toString = static fn (int $a): string => (string) $a;

        yield [
            $operation,
            [
                $square,
                $toString,
            ],
            range(1, 3),
            ['1', '4', '9'],
        ];
    }

    public function mapOperationProvider()
    {
        $operation = 'map';

        yield [
            $operation,
            [
                static fn (string $item): string => $item . $item,
            ],
            array_combine(range('A', 'C'), range('A', 'C')),
            ['A' => 'AA', 'B' => 'BB', 'C' => 'CC'],
        ];

        $input = static function (): Generator {
            yield ['a'] => 1;

            yield ['b'] => 2;

            yield ['a'] => 3;
        };

        $output = static function (): Generator {
            yield ['a'] => 1;

            yield ['b'] => 4;

            yield ['a'] => 9;
        };

        yield [
            $operation,
            [
                static fn (int $value): int => $value ** 2,
            ],
            $input(),
            $output(),
        ];
    }

    public function matchingOperationProvider()
    {
        $operation = 'matching';
        $input = [
            [
                'name' => 'Pol',
                'age' => 39,
                'is_admin' => true,
            ],
            [
                'name' => 'Sandra',
                'age' => 38,
                'is_admin' => false,
            ],
            [
                'name' => 'Izumi',
                'age' => 7,
                'is_admin' => true,
            ],
            [
                'name' => 'Nakano',
                'age' => 4,
                'is_admin' => false,
            ],
        ];

        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('is_admin', true))
            ->orderBy(['age' => 'ASC'])
            ->setMaxResults(1);

        yield [
            $operation,
            [$criteria],
            $input,
            [
                2 => [
                    'name' => 'Izumi',
                    'age' => 7,
                    'is_admin' => true,
                ],
            ],
        ];
    }

    public function matchOperationProvider()
    {
        $operation = 'match';
        $input = range(1, 10);

        yield [
            $operation,
            [
                static fn (int $value): bool => 7 === $value,
            ],
            $input,
            true,
        ];

        yield [
            $operation,
            [
                static fn (int $value): bool => 17 === $value,
            ],
            $input,
            false,
        ];

        yield [
            $operation,
            [
                static fn (int $value): bool => 5 !== $value,
                static fn (): bool => false,
            ],
            $input,
            true,
        ];
    }

    /**
     * @return iterable<array{0: string, 1: array, 2: iterable, 3: iterable}>
     */
    public function maxOperationProvider(): iterable
    {
        $operation = 'max';

        yield [
            $operation,
            [],
            [1, 2, 3, 4, 5],
            5,
        ];

        yield [
            $operation,
            [PHP_INT_MAX],
            [],
            PHP_INT_MAX,
        ];

        yield [
            $operation,
            [],
            [-1, 200, -100, -3, -500],
            200,
        ];

        yield [
            $operation,
            [],
            ['foo' => 'f', 'bar' => 'b', 'tar' => 't'],
            't',
        ];
    }

    public function mergeOperationProvider()
    {
        $parameter = static function () {
            yield from range('D', 'F');
        };

        $generator = static function (): Generator {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'C';

            yield 0 => 'D';

            yield 1 => 'E';

            yield 2 => 'F';
        };

        yield [
            'merge',
            [
                $parameter(),
            ],
            range('A', 'C'),
            $generator(),
        ];
    }

    /**
     * @return iterable<array{0: string, 1: array, 2: iterable, 3: iterable}>
     */
    public function minOperationProvider(): iterable
    {
        $operation = 'min';

        yield [
            $operation,
            [],
            [1, 2, 3, 4, 5],
            1,
        ];

        yield [
            $operation,
            [PHP_INT_MIN],
            [],
            PHP_INT_MIN,
        ];

        yield [
            $operation,
            [],
            [1, 2, -100, 4, 5],
            -100,
        ];

        yield [
            $operation,
            [],
            ['foo' => 'f', 'bar' => 'b', 'tar' => 't'],
            'b',
        ];
    }

    public function normalizeOperationProvider()
    {
        $operation = 'normalize';

        yield [
            $operation,
            [],
            ['a' => 10, 'b' => 100, 'c' => 1000],
            [0 => 10, 1 => 100, 2 => 1000],
        ];

        $generator = static function (): Generator {
            yield 1 => 'a';

            yield 2 => 'b';

            yield 1 => 'c';

            yield 3 => 'd';
        };

        yield [
            $operation,
            [],
            $generator(),
            [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd'],
        ];

        yield [
            $operation,
            [],
            [1 => 2, 3 => 4],
            [0 => 2, 1 => 4],
        ];
    }

    public function nthOperationProvider()
    {
        $operation = 'nth';
        $input = range(0, 70);

        yield [
            $operation,
            [7],
            $input,
            [0 => 0, 7 => 7, 14 => 14, 21 => 21, 28 => 28, 35 => 35, 42 => 42, 49 => 49, 56 => 56, 63 => 63, 70 => 70],
        ];

        yield [
            $operation,
            [7, 3],
            $input,
            [3 => 3, 10 => 10, 17 => 17, 24 => 24, 31 => 31, 38 => 38, 45 => 45, 52 => 52, 59 => 59, 66 => 66],
        ];
    }

    public function nullsyOperationProvider()
    {
        $operation = 'nullsy';

        yield [
            $operation,
            [],
            [null, null, null],
            true,
        ];

        yield [
            $operation,
            [],
            [null, 0, null],
            true,
        ];

        yield [
            $operation,
            [],
            [null, [], 0, false, ''],
            true,
        ];

        yield [
            $operation,
            [],
            [null, [], 0, false, '', 'foo'],
            false,
        ];
    }

    public function packOperationProvider()
    {
        yield [
            'pack',
            [],
            array_combine(range('A', 'C'), range('a', 'c')),
            [
                ['A', 'a'],
                ['B', 'b'],
                ['C', 'c'],
            ],
        ];
    }

    public function padOperationProvider()
    {
        yield [
            'pad',
            [6, 'foo'],
            array_combine(range('A', 'C'), range('a', 'c')),
            ['A' => 'a', 'B' => 'b', 'C' => 'c', 0 => 'foo', 1 => 'foo', 2 => 'foo'],
        ];
    }

    public function pairOperationProvider()
    {
        $operation = 'pair';

        $input = static function () {
            yield 'key' => 'k1';

            yield 'value' => 'v1';

            yield 'key' => 'k2';

            yield 'value' => 'v2';

            yield 'key' => 'k3';

            yield 'value' => 'v3';

            yield 'key' => 'k4';

            yield 'value' => 'v4';

            yield 'key' => 'k4';

            yield 'value' => 'v5';
        };

        $output = static function () {
            yield 'k1' => 'v1';

            yield 'k2' => 'v2';

            yield 'k3' => 'v3';

            yield 'k4' => 'v4';

            yield 'k4' => 'v5';
        };

        yield [
            $operation,
            [],
            $input(),
            $output(),
        ];

        $input = ['a', 'b', 'c'];
        $output = static function () {
            yield 'a' => 'b';

            yield 'c' => null;
        };

        yield [
            $operation,
            [],
            $input,
            $output(),
        ];
    }

    public function permutateOperationProvider()
    {
        yield [
            'permutate',
            [],
            range('a', 'c'),
            [
                [
                    0 => 'a',
                    1 => 'b',
                    2 => 'c',
                ],
                [
                    0 => 'a',
                    1 => 'c',
                    2 => 'b',
                ],
                [
                    0 => 'b',
                    1 => 'a',
                    2 => 'c',
                ],
                [
                    0 => 'b',
                    1 => 'c',
                    2 => 'a',
                ],
                [
                    0 => 'c',
                    1 => 'a',
                    2 => 'b',
                ],
                [
                    0 => 'c',
                    1 => 'b',
                    2 => 'a',
                ],
            ],
        ];
    }

    public function pipeOperationProvider()
    {
        $square = new class() extends AbstractOperation implements Operation {
            public function __invoke(): Closure
            {
                return static function ($collection): Generator {
                    foreach ($collection as $item) {
                        yield $item ** 2;
                    }
                };
            }
        };

        $sqrt = new class() extends AbstractOperation implements Operation {
            public function __invoke(): Closure
            {
                return static function ($collection) {
                    foreach ($collection as $item) {
                        yield $item ** .5;
                    }
                };
            }
        };

        $castToInt = new class() extends AbstractOperation implements Operation {
            public function __invoke(): Closure
            {
                return static function ($collection) {
                    foreach ($collection as $item) {
                        yield (int) $item;
                    }
                };
            }
        };

        yield [
            'pipe',
            [$square(), $sqrt(), $castToInt()],
            range(1, 5),
            range(1, 5),
        ];
    }

    public function pluckOperationProvider()
    {
        $operation = 'pluck';

        $six = new class() {
            public $foo = [
                'bar' => 5,
            ];
        };

        $input = [
            [
                0 => 'A',
                'foo' => [
                    'bar' => 0,
                ],
            ],
            [
                0 => 'B',
                'foo' => [
                    'bar' => 1,
                ],
            ],
            [
                0 => 'C',
                'foo' => [
                    'bar' => 2,
                ],
            ],
            Collection::fromIterable(
                [
                    'foo' => [
                        'bar' => 3,
                    ],
                ]
            ),
            new ArrayObject([
                'foo' => [
                    'bar' => 4,
                ],
            ]),
            new class() {
                public $foo = [
                    'bar' => 5,
                ];
            },
            [
                0 => 'D',
                'foo' => [
                    'bar' => $six,
                ],
            ],
        ];

        yield [
            $operation,
            ['foo'],
            $input,
            [0 => ['bar' => 0], 1 => ['bar' => 1], 2 => ['bar' => 2], 3 => ['bar' => 3], 4 => ['bar' => 4], 5 => ['bar' => 5], 6 => ['bar' => $six]],
        ];

        yield [
            $operation,
            ['foo.*'],
            $input,
            [0 => [0 => 0], 1 => [0 => 1], 2 => [0 => 2], 3 => [0 => 3], 4 => [0 => 4], 5 => [0 => 5], 6 => [0 => $six]],
        ];

        yield [
            $operation,
            ['.foo.bar.'],
            $input,
            [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => $six],
        ];

        yield [
            $operation,
            ['foo.bar.*', 'taz'],
            $input,
            [0 => 'taz', 1 => 'taz', 2 => 'taz', 3 => 'taz', 4 => 'taz', 5 => 'taz', 6 => 'taz'],
        ];

        yield [
            $operation,
            ['azerty', 'taz'],
            $input,
            [0 => 'taz', 1 => 'taz', 2 => 'taz', 3 => 'taz', 4 => 'taz', 5 => 'taz', 6 => 'taz'],
        ];

        yield [
            $operation,
            [0],
            $input,
            [0 => 'A', 1 => 'B', 2 => 'C', null, null, null, 6 => 'D'],
        ];
    }

    public function prependOperationProvider()
    {
        $output = static function (): Generator {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'C';

            yield 0 => 'D';

            yield 1 => 'E';

            yield 2 => 'F';
        };

        yield [
            'prepend',
            range('A', 'C'),
            range('D', 'F'),
            $output(),
        ];
    }

    public function productOperationProvider()
    {
        $operation = 'product';

        yield [
            $operation,
            [],
            range('A', 'C'),
            [0 => ['A'], 1 => ['B'], 2 => ['C']],
        ];

        yield [
            $operation,
            [[1, 2], [3, 4]],
            range('A', 'C'),
            [
                ['A', 1, 3],
                ['A', 1, 4],
                ['A', 2, 3],
                ['A', 2, 4],
                ['B', 1, 3],
                ['B', 1, 4],
                ['B', 2, 3],
                ['B', 2, 4],
                ['C', 1, 3],
                ['C', 1, 4],
                ['C', 2, 3],
                ['C', 2, 4],
            ],
        ];
    }

    public function reduceOperationProvider()
    {
        $operation = 'reduce';

        yield [
            $operation,
            [
                static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string),
                'foo',
            ],
            [],
            null,
        ];

        yield [
            $operation,
            [
                static fn (int $carry, int $item): int => $carry + $item,
                0,
            ],
            range(1, 5),
            15,
        ];

        yield [
            $operation,
            [
                static fn (string $carry, string $letter, string $index): string => sprintf('%s[%s:%s]', $carry, $index, $letter),
                '=> ',
            ],
            array_combine(range('x', 'z'), range('a', 'c')),
            '=> [x:a][y:b][z:c]',
        ];
    }

    public function reductionOperationProvider()
    {
        yield [
            'reduction',
            [
                static function ($carry, $item) {
                    return $carry + $item;
                },
                0,
            ],
            range(1, 5),
            [1, 3, 6, 10, 15],
        ];
    }

    public function rejectOperationProvider()
    {
        $operation = 'reject';
        $input = array_merge([0, false], range(1, 10));

        $callable = static function ($value) {
            return $value % 2;
        };

        $callableWithKey = static fn (int $value, int $key): bool => $value % 2 === 0 && 4 < $key;

        yield [
            $operation,
            [$callable],
            $input,
            [0, false, 3 => 2, 5 => 4, 7 => 6, 9 => 8, 11 => 10],
        ];

        yield [
            $operation,
            [$callableWithKey],
            range(0, 10),
            [0, 1, 2, 3, 4, 5, 7 => 7, 9 => 9],
        ];

        yield [
            $operation,
            [
                static fn (string $value): bool => 'a' === $value,
                static fn (string $value): bool => 'd' === $value,
            ],
            range('a', 'd'),
            [1 => 'b', 2 => 'c'],
        ];

        yield [
            $operation,
            [],
            [true, false, 0, '', null],
            [1 => false, 2 => 0, 3 => '', 4 => null],
        ];
    }

    public function reverseOperationProvider()
    {
        $operation = 'reverse';

        yield [
            $operation,
            [],
            [],
            [],
        ];

        yield [
            $operation,
            [],
            range('A', 'C'),
            [2 => 'C', 1 => 'B', 0 => 'A'],
        ];
    }

    public function sameOperationProvider()
    {
        $operation = 'same';

        $a = (object) ['id' => 'a'];
        $a2 = (object) ['id' => 'a'];
        $b = (object) ['id' => 'b'];

        // empty variations
        yield [
            $operation,
            [Collection::empty()],
            [],
            true,
        ];

        yield [
            $operation,
            [Collection::fromIterable([1])],
            [],
            false,
        ];

        yield [
            $operation,
            [Collection::empty()],
            [1],
            false,
        ];

        // same elements, same order (same keys)
        yield [
            $operation,
            [Collection::fromIterable([1, 2, 3])],
            [1, 2, 3],
            true,
        ];

        yield [
            $operation,
            [Collection::fromIterable([$a, $b])],
            [$a, $b],
            true,
        ];

        // same elements, different order (different keys)
        yield [
            $operation,
            [Collection::fromIterable([1, 2, 3])],
            [3, 1, 2],
            false,
        ];

        yield [
            $operation,
            [Collection::fromIterable([$b, $a])],
            [$a, $b],
            false,
        ];

        // same lengths, with one element different
        yield [
            $operation,
            [Collection::fromIterable([1, 2, 4])],
            [1, 2, 3],
            false,
        ];

        // different lengths, extra elements in first
        yield [
            $operation,
            [Collection::fromIterable([1, 2, 3])],
            [1, 2, 3, 4],
            false,
        ];

        // different lengths, extra elements in second
        yield [
            $operation,
            [Collection::fromIterable([1, 2, 3, 4])],
            [1, 2, 3],
            false,
        ];

        // objects, different instances and contents
        yield [
            $operation,
            [Collection::fromIterable([$b])],
            [$a],
            false,
        ];

        // objects, different instances but same contents
        yield [
            $operation,
            [Collection::fromIterable([$a2])],
            [$a],
            false,
        ];

        // "maps" with string keys and values
        yield [
            $operation,
            [Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])],
            ['foo' => 'f', 'bar' => 'b'],
            true,
        ];

        yield [
            $operation,
            [Collection::fromIterable(['bar' => 'f'])],
            ['foo' => 'f'],
            false,
        ];

        yield [
            $operation,
            [Collection::fromIterable(['bar' => 'b', 'foo' => 'f'])],
            ['foo' => 'f', 'bar' => 'b'],
            false,
        ];

        yield [
            $operation,
            [Collection::fromIterable(['bar' => 'b'])],
            ['foo' => 'f', 'bar' => 'b'],
            false,
        ];

        yield [
            $operation,
            [Collection::fromIterable(['bar' => 'b'])],
            ['foo' => 'f'],
            false,
        ];

        yield [
            $operation,
            [Collection::fromIterable(['foo' => 'f'])],
            ['FOO' => 'f'],
            false,
        ];

        yield [
            $operation,
            [Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])],
            ['foo' => 'f'],
            false,
        ];

        // custom comparators
        $comparator = static fn ($left) => static fn ($right): bool => (int) $left === (int) $right;

        yield [
            $operation,
            [Collection::fromIterable(['1', '2', '3']), $comparator],
            [1, 2, 3],
            true,
        ];

        $comparator = static fn ($left) => static fn ($right): bool => $left === $right;

        yield [
            $operation,
            [Collection::fromIterable(['bar' => 'f']), $comparator],
            ['foo' => 'f'],
            true,
        ];

        $comparator = static fn ($left, $leftKey) => static fn ($right, $rightKey): bool => $left === $right
            && mb_strtolower($leftKey) === mb_strtolower($rightKey);

        yield [
            $operation,
            [Collection::fromIterable(['FOO' => 'f']), $comparator],
            ['foo' => 'f'],
            true,
        ];

        $comparator = static fn (stdClass $left) => static fn (stdClass $right): bool => $left->id === $right->id;

        yield [
            $operation,
            [Collection::fromIterable([$a2]), $comparator],
            [$a],
            true,
        ];
    }

    public function scaleOperationProvider()
    {
        $operation = 'scale';
        $input = [0, 2, 4, 6, 8, 10];

        yield [
            $operation,
            [0, 10],
            $input,
            [0.0, 0.2, 0.4, 0.6, 0.8, 1.0],
        ];
    }

    public function scanLeft1OperationProvider()
    {
        $operation = 'scanLeft1';
        $callback = static fn ($carry, $value) => $carry / $value;

        yield [
            $operation,
            [
                $callback,
            ],
            [64, 4, 2, 8],
            [64, 16, 8, 1],
        ];

        yield [
            $operation,
            [
                $callback,
            ],
            [12],
            [12],
        ];

        yield [
            $operation,
            [
                $callback,
            ],
            [],
            [],
        ];
    }

    public function scanLeftOperationProvider()
    {
        $operation = 'scanLeft';
        $callback = static fn ($carry, $value) => $carry / $value;
        $output = static function () {
            yield 0 => 64;

            yield 0 => 16;

            yield 1 => 8;

            yield 2 => 2;
        };

        yield [
            $operation,
            [
                $callback,
                64,
            ],
            [4, 2, 4],
            $output(),
        ];

        yield [
            $operation,
            [
                $callback,
                3,
            ],
            [],
            [0 => 3],
        ];
    }

    public function scanRight1OperationProvider()
    {
        $operation = 'scanRight1';
        $callback = static fn ($carry, $value) => $value / $carry;
        $output = static function () {
            yield 0 => 8;

            yield 1 => 1;

            yield 2 => 12;

            yield 0 => 2;
        };

        yield [
            $operation,
            [
                $callback,
            ],
            [8, 12, 24, 2],
            $output(),
        ];

        yield [
            $operation,
            [
                $callback,
            ],
            [12],
            [12],
        ];
    }

    public function scanRightOperationProvider()
    {
        $operation = 'scanRight';
        $callback = static fn ($carry, $value) => $value / $carry;

        $output = static function () {
            yield 0 => 8;

            yield 1 => 1;

            yield 2 => 12;

            yield 3 => 2;

            yield 0 => 2;
        };

        yield [
            $operation,
            [
                $callback,
                2,
            ],
            [8, 12, 24, 4],
            $output(),
        ];

        yield [
            $operation,
            [
                $callback,
                3,
            ],
            [],
            [3],
        ];
    }

    public function shuffleOperationProvider()
    {
        $operation = 'shuffle';
        $input = range('a', 'e');

        yield [
            $operation,
            [123],
            $input,
            [
                2 => 'c',
                1 => 'b',
                3 => 'd',
                4 => 'e',
                0 => 'a',
            ],
        ];
    }

    public function sinceOperationProvider()
    {
        $operation = 'since';
        $input = range('a', 'z');

        yield [
            $operation,
            [
                static fn (string $letter): bool => 'x' === $letter,
            ],
            $input,
            [23 => 'x', 24 => 'y', 25 => 'z'],
        ];

        yield [
            $operation,
            [
                static fn (string $letter): bool => 'x' === $letter,
                static fn (string $letter): bool => 1 === mb_strlen($letter),
            ],
            $input,
            $input,
        ];

        yield [
            $operation,
            [
                static fn (string $letter): bool => 'foo' === $letter,
                static fn (string $letter): bool => 'x' === $letter,
            ],
            $input,
            [23 => 'x', 24 => 'y', 25 => 'z'],
        ];

        $isGreaterThanThree = static fn (int $value): bool => 3 < $value;
        $isGreaterThanFive = static fn (int $value): bool => 5 < $value;

        $input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3];

        yield [
            $operation,
            [
                $isGreaterThanThree,
                $isGreaterThanFive,
            ],
            $input,
            [
                3 => 4,
                4 => 5,
                5 => 6,
                6 => 7,
                7 => 8,
                8 => 9,
                9 => 1,
                10 => 2,
                11 => 3,
            ],
        ];
    }

    public function sliceOperationProvider()
    {
        $operation = 'slice';
        $input = range(0, 10);

        yield [
            $operation,
            [5],
            $input,
            [5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10],
        ];

        yield [
            $operation,
            [5, 2],
            $input,
            [5 => 5, 6 => 6],
        ];

        yield [
            $operation,
            [5, 1000],
            $input,
            [5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10],
        ];
    }

    public function sortOperationProvider()
    {
        $operation = 'sort';
        $input = array_combine(range('A', 'E'), range('E', 'A'));

        yield [
            $operation,
            [],
            $input,
            array_combine(range('E', 'A'), range('A', 'E')),
        ];

        yield [
            $operation,
            [
                Operation\Sortable::BY_VALUES,
            ],
            $input,
            array_combine(range('E', 'A'), range('A', 'E')),
        ];

        yield [
            $operation,
            [
                Operation\Sortable::BY_KEYS,
            ],
            $input,
            array_combine(range('A', 'E'), range('E', 'A')),
        ];

        yield [
            $operation,
            [
                Operation\Sortable::BY_VALUES,
                static fn ($left, $right): int => $right <=> $left,
            ],
            $input,
            array_combine(range('A', 'E'), range('E', 'A')),
        ];

        $inputGen = static function () {
            yield 'k1' => 'v1';

            yield 'k2' => 'v2';

            yield 'k3' => 'v3';

            yield 'k4' => 'v4';

            yield 'k1' => 'v1';

            yield 'k2' => 'v2';

            yield 'k3' => 'v3';

            yield 'k4' => 'v4';

            yield 'a' => 'z';
        };

        $output = static function () {
            yield 'a' => 'z';

            yield 'k1' => 'v1';

            yield 'k1' => 'v1';

            yield 'k2' => 'v2';

            yield 'k2' => 'v2';

            yield 'k3' => 'v3';

            yield 'k3' => 'v3';

            yield 'k4' => 'v4';

            yield 'k4' => 'v4';
        };

        yield [
            $operation,
            [
                Operation\Sortable::BY_KEYS,
            ],
            $inputGen(),
            $output(),
        ];
    }

    public function splitOperationProvider()
    {
        $operation = 'split';
        $input = range(0, 10);
        $splitter = static fn (int $value): bool => 0 === $value % 3;

        yield [
            $operation,
            [
                Operation\Splitable::BEFORE,
                $splitter,
            ],
            $input,
            [[0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10]],
        ];

        yield [
            $operation,
            [
                Operation\Splitable::REMOVE,
                $splitter,
            ],
            $input,
            [[], [1, 2], [4, 5], [7, 8], [10]],
        ];

        yield [
            $operation,
            [
                Operation\Splitable::AFTER,
                $splitter,
            ],
            $input,
            [[0], [1, 2, 3], [4, 5, 6], [7, 8, 9], [10]],
        ];
    }

    public function squashOperationProvider()
    {
        $operation = 'squash';
        $input = range('A', 'E');

        yield [
            $operation,
            [],
            $input,
            $input,
        ];
    }

    public function strictOperationProvider()
    {
        yield [
            'strict',
            [],
            range('A', 'C'),
            range('A', 'C'),
        ];
    }

    public function tailOperationProvider()
    {
        $operation = 'tail';
        $input = range('A', 'F');

        yield [
            $operation,
            [],
            $input,
            [1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E', 5 => 'F'],
        ];
    }

    public function tailsOperationProvider()
    {
        $operation = 'tails';
        $input = range('A', 'E');

        yield [
            $operation,
            [],
            $input,
            [
                ['A', 'B', 'C', 'D', 'E'],
                [0 => 'B', 1 => 'C', 2 => 'D', 3 => 'E'],
                [0 => 'C', 1 => 'D', 2 => 'E'],
                [0 => 'D', 1 => 'E'],
                [0 => 'E'],
                [],
            ],
        ];
    }

    public function takeWhileOperationProvider()
    {
        $operation = 'takeWhile';
        $isSmallerThan = static fn (int $bound): Closure => static fn (int $value): bool => $bound > $value;
        $input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3];

        yield [
            $operation,
            [
                $isSmallerThan(5),
            ],
            $input,
            [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
            ],
        ];

        yield [
            $operation,
            [
                $isSmallerThan(3),
                $isSmallerThan(5),
            ],
            $input,
            [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
            ],
        ];

        yield [
            $operation,
            [
                $isSmallerThan(5),
                $isSmallerThan(3),
            ],
            $input,
            [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
            ],
        ];
    }

    public function transposeOperationProvider()
    {
        $operation = 'transpose';
        $input = [
            [
                'id' => 2135,
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            [
                'id' => 3245,
                'first_name' => 'Sally',
                'last_name' => 'Smith',
            ],
            [
                'id' => 5342,
                'first_name' => 'Jane',
                'last_name' => 'Jones',
            ],
            [
                'id' => 5623,
                'first_name' => 'Peter',
                'last_name' => 'Doe',
            ],
        ];

        yield [
            $operation,
            [],
            $input,
            [
                'id' => [
                    0 => 2135,
                    1 => 3245,
                    2 => 5342,
                    3 => 5623,
                ],
                'first_name' => [
                    0 => 'John',
                    1 => 'Sally',
                    2 => 'Jane',
                    3 => 'Peter',
                ],
                'last_name' => [
                    0 => 'Doe',
                    1 => 'Smith',
                    2 => 'Jones',
                    3 => 'Doe',
                ],
            ],
        ];
    }

    public function truthyOperationProvider()
    {
        $operation = 'truthy';

        yield [
            $operation,
            [],
            [true, true, true],
            true,
        ];

        yield [
            $operation,
            [],
            [true, false, true],
            false,
        ];

        yield [
            $operation,
            [],
            range(1, 3),
            true,
        ];

        yield [
            $operation,
            [],
            [1, 2, 3, 0],
            false,
        ];
    }

    public function unlinesOperationProvider()
    {
        yield [
            'unlines',
            [],
            [
                'The quick brow fox jumps over the lazy dog.',
                'This is another sentence.',
            ],
            sprintf(
                '%s%s%s',
                'The quick brow fox jumps over the lazy dog.',
                PHP_EOL,
                'This is another sentence.'
            ),
        ];
    }

    public function unpackOperationProvider()
    {
        $operation = 'unpack';

        $input = [
            ['A', 'a'],
            ['B', 'b'],
            ['C', 'c'],
            ['D', 'd'],
            ['E', 'e'],
        ];

        yield [
            $operation,
            [],
            $input,
            [
                'A' => 'a',
                'B' => 'b',
                'C' => 'c',
                'D' => 'd',
                'E' => 'e',
            ],
        ];
    }

    public function unpairOperationProvider()
    {
        yield [
            'unpair',
            [],
            [
                'k1' => 'v1',
                'k2' => 'v2',
                'k3' => 'v3',
                'k4' => 'v4',
            ],
            [
                'k1', 'v1',
                'k2', 'v2',
                'k3', 'v3',
                'k4', 'v4',
            ],
        ];
    }

    public function untilOperationProvider()
    {
        $operation = 'until';
        $collatz = static function (int $initial = 1): int {
            return 0 === $initial % 2 ?
                $initial / 2 :
                $initial * 3 + 1;
        };

        $input = static function (int $from) use ($collatz) {
            while (true) {
                yield $from = $collatz($from);
            }
        };

        yield [
            $operation,
            [
                static fn (int $number): bool => 1 === $number,
            ],
            $input(10),
            [
                5,
                16,
                8,
                4,
                2,
                1,
            ],
        ];

        yield [
            $operation,
            [
                static fn (int $number): bool => 8 < $number,
                static fn (int $number): bool => 3 < $number,
            ],
            range(1, 10),
            range(1, 4),
        ];
    }

    public function unwindowOperationProvider()
    {
        yield [
            'unwindow',
            [],
            [
                0 => [
                    0 => 'a',
                ],
                1 => [
                    0 => 'a',
                    1 => 'b',
                ],
                2 => [
                    0 => 'a',
                    1 => 'b',
                    2 => 'c',
                ],
                3 => [
                    0 => 'b',
                    1 => 'c',
                    2 => 'd',
                ],
                4 => [
                    0 => 'c',
                    1 => 'd',
                    2 => 'e',
                ],
                5 => [
                    0 => 'd',
                    1 => 'e',
                    2 => 'f',
                ],
            ],
            range('a', 'f'),
        ];
    }

    public function unwordsOperationProvider()
    {
        $operation = 'unwords';
        $output = <<<'EOF'
            The quick brow fox jumps over the lazy dog.

            This is another sentence.
            EOF;

        $input = [
            'The',
            'quick',
            'brow',
            'fox',
            'jumps',
            'over',
            'the',
            'lazy',
            "dog.\n\nThis",
            'is',
            'another',
            'sentence.',
        ];

        yield [
            $operation,
            [],
            $input,
            $output,
        ];
    }

    public function unwrapOperationProvider()
    {
        $operation = 'unwrap';

        yield [
            $operation,
            [],
            [['a' => 'A'], ['b' => 'B'], ['c' => 'C']],
            [
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
            ],
        ];

        yield [
            $operation,
            [],
            ['foo' => ['a' => 'A'], 'bar' => ['b' => 'B'], 'foobar' => ['c' => 'C', 'd' => 'D']],
            [
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
                'd' => 'D',
            ],
        ];

        $inner = static fn (): Generator => yield from [2, 3];

        $output = static function () {
            yield 0 => 1;

            yield 0 => 2;

            yield 1 => 3;

            yield 2 => 4;

            yield 3 => 5;
        };

        yield [
            $operation,
            [],
            [1, $inner(), 4, 5],
            $output(),
        ];
    }

    public function unzipOperationProvider()
    {
        $operation = 'unzip';

        $input = static function () {
            yield 0 => ['A', 'D', 1];

            yield 1 => ['B', 'E', 2];

            yield 2 => ['C', 'F', 3];

            yield 3 => [null, 'G', 4];

            yield 4 => [null, null, 5];
        };

        yield [
            $operation,
            [],
            $input(),
            [
                [
                    'A', 'B', 'C', null, null,
                ],
                [
                    'D', 'E', 'F', 'G', null,
                ],
                [
                    1, 2, 3, 4, 5,
                ],
            ],
        ];
    }

    public function whenOperationProvider()
    {
        $operation = 'when';
        $input = range('a', 'c');

        yield [
            $operation,
            [
                static fn (): bool => true,
                static fn (iterable $iterable) => range('c', 'a'),
            ],
            $input,
            [0 => 'c', 1 => 'b', 2 => 'a'],
        ];

        yield [
            $operation,
            [
                static fn (): bool => false,
                static fn (iterable $iterable) => range('c', 'a'),
            ],
            $input,
            [0 => 'a', 1 => 'b', 2 => 'c'],
        ];
    }

    public function windowOperationProvider()
    {
        $operation = 'window';

        yield [
            $operation,
            [0],
            ['a' => 'A', 'b' => 'B', 'c' => 'C'],
            [
                'a' => ['A'],
                'b' => ['B'],
                'c' => ['C'],
            ],
        ];

        yield [
            $operation,
            [2],
            range('a', 'e'),
            [
                ['a'],
                ['a', 'b'],
                ['a', 'b', 'c'],
                ['b', 'c', 'd'],
                ['c', 'd', 'e'],
            ],
        ];

        yield [
            $operation,
            [-1],
            range('a', 'e'),
            [
                ['a'],
                ['a', 'b'],
                ['a', 'b', 'c'],
                ['a', 'b', 'c', 'd'],
                ['a', 'b', 'c', 'd', 'e'],
            ],
        ];

        // Unsupported - but tested.
        yield [
            $operation,
            [-2],
            range('a', 'e'),
            [
                [], [], [], [], [],
            ],
        ];
    }

    public function wordsOperationProvider()
    {
        $input = <<<'EOF'
            The quick brow fox jumps over the lazy dog.

            This is another sentence.
            EOF;

        yield [
            'words',
            [],
            str_split($input),
            [
                0 => 'The',
                1 => 'quick',
                2 => 'brow',
                3 => 'fox',
                4 => 'jumps',
                5 => 'over',
                6 => 'the',
                7 => 'lazy',
                8 => 'dog.',
                10 => 'This',
                11 => 'is',
                12 => 'another',
                13 => 'sentence.',
            ],
        ];
    }

    public function wrapOperationProvider()
    {
        $operation = 'wrap';

        yield [
            $operation,
            [],
            ['a' => 'A', 'b' => 'B', 'c' => 'C'],
            [['a' => 'A'], ['b' => 'B'], ['c' => 'C']],
        ];

        yield [
            $operation,
            [],
            range('a', 'c'),
            [[0 => 'a'], [1 => 'b'], [2 => 'c']],
        ];
    }

    public function zipOperationProvider()
    {
        $operation = 'zip';
        $output = static function () {
            yield [0, 0] => ['A', 'D'];

            yield [1, 1] => ['B', 'E'];

            yield [2, 2] => ['C', 'F'];
        };

        yield [
            $operation,
            [range('D', 'F')],
            range('A', 'C'),
            $output(),
        ];

        $output = static function () {
            yield [0, 0] => ['A', 'D'];

            yield [1, 1] => ['B', 'E'];

            yield [2, 2] => ['C', 'F'];

            yield [null, 3] => [null, 'G'];
        };

        yield [
            $operation,
            [range('D', 'G')],
            range('A', 'C'),
            $output(),
        ];
    }
}
