<?php

declare(strict_types=1);

namespace spec\loophp\collection;

use ArrayObject;
use Closure;
use Exception;
use Generator;
use InvalidArgumentException;
use Iterator;
use JsonSerializable;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Operation\AbstractOperation;
use OutOfRangeException;
use PhpSpec\ObjectBehavior;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use stdClass;

class CollectionSpec extends ObjectBehavior
{
    public function it_can_append(): void
    {
        $generator = static function (): Generator {
            yield 0 => '1';

            yield 1 => '2';

            yield 2 => '3';

            yield 0 => '4';
        };

        $this::fromIterable(['1', '2', '3'])
            ->append('4')
            ->shouldIterateAs($generator());

        $generator = static function (): Generator {
            yield 0 => '1';

            yield 1 => '2';

            yield 2 => '3';

            yield 0 => '5';

            yield 1 => '6';
        };

        $this::fromIterable(['1', '2', '3'])
            ->append('5', '6')
            ->shouldIterateAs($generator());
    }

    public function it_can_apply(): void
    {
        $input = array_combine(range('A', 'Z'), range('A', 'Z'));

        $this::fromIterable($input)
            ->apply(static function ($item) {
                // do what you want here.

                return true;
            })
            ->shouldIterateAs($input);

        $this::fromIterable($input)
            ->apply(static function ($item) {
                // do what you want here.

                return false;
            })
            ->shouldIterateAs($input);

        $this::fromIterable($input)
            ->apply(
                static function ($item) {
                    return $item;
                }
            )
            ->shouldIterateAs($input);

        $this::fromIterable($input)
            ->apply(
                static function ($item) {
                    return false;
                }
            )
            ->shouldReturnAnInstanceOf(Collection::class);

        $callback = static function (): void {
            throw new Exception('foo');
        };

        $this::fromIterable($input)
            ->apply($callback)
            ->shouldThrow(Exception::class)
            ->during('all');

        $apply1 = static function ($value) {
            return true === $value % 2;
        };

        $apply2 = static function ($value) {
            return true === $value % 3;
        };

        $this::fromIterable([1, 2, 3, 4, 5, 6])
            ->apply($apply1)
            ->apply($apply2)
            ->shouldIterateAs([1, 2, 3, 4, 5, 6]);
    }

    public function it_can_be_constructed_from_a_stream(): void
    {
        $string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

        $stream = fopen('data://text/plain,' . $string, 'rb');
        $this::fromResource($stream)
            ->count()
            ->shouldReturn(56);

        $stream = fopen('data://text/plain,' . $string, 'rb');
        $this::fromResource($stream)
            ->implode('')
            ->shouldReturn($string);
    }

    public function it_can_be_constructed_from_array(): void
    {
        $this
            ->beConstructedThrough('fromIterable', [range('A', 'E')]);

        $this->shouldImplement(Collection::class);

        $this
            ->shouldIterateAs(['A', 'B', 'C', 'D', 'E']);
    }

    public function it_can_be_constructed_from_empty(): void
    {
        $this
            ->beConstructedThrough('empty');

        $this
            ->shouldIterateAs([]);
    }

    public function it_can_be_constructed_from_nothing(): void
    {
        $this
            ->beConstructedWith(null);

        $this
            ->shouldIterateAs([]);
    }

    public function it_can_be_constructed_with_a_closure(): void
    {
        $this
            ->beConstructedThrough('fromCallable', [static function () {
                yield from range(1, 3);
            }]);

        $this->shouldImplement(Collection::class);
    }

    public function it_can_be_constructed_with_an_arrayObject(): void
    {
        $this
            ->beConstructedThrough('fromIterable', [new ArrayObject([1, 2, 3])]);

        $this->shouldImplement(Collection::class);
    }

    public function it_can_be_instantiated_with_withClosure(): void
    {
        $fibonacci = static function ($start, $inc) {
            yield $start;

            while (true) {
                $inc = $start + $inc;
                $start = $inc - $start;

                yield $start;
            }
        };

        $this::fromCallable($fibonacci, 0, 1)
            ->limit(10)
            ->shouldIterateAs([0, 1, 1, 2, 3, 5, 8, 13, 21, 34]);
    }

    public function it_can_be_json_encoded()
    {
        $input = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        $this->beConstructedThrough('fromIterable', [$input]);

        $this
            ->jsonSerialize()
            ->shouldReturn($this->all());

        $this
            ->shouldImplement(JsonSerializable::class);

        $this
            ->transform(
                new class() implements Transformation {
                    public function __invoke(iterable $collection)
                    {
                        return '{"a":"A","b":"B","c":"C"}';
                    }
                }
            )
            ->shouldReturn(json_encode($this->getWrappedObject()));
    }

    public function it_can_be_returned_as_an_array(): void
    {
        $this::fromIterable(new ArrayObject(['1', '2', '3']))
            ->shouldIterateAs(['1', '2', '3']);
    }

    public function it_can_cache(CacheItemPoolInterface $cache, CacheItemInterface $cacheItemFound0, CacheItemInterface $cacheItemNotFound1, CacheItemInterface $cacheItemNotFound2, CacheItemInterface $cacheItemNotFound3): void
    {
        $fhandle = fopen(__DIR__ . '/../../fixtures/sample.txt', 'rb');

        $cache
            ->getItem('1')
            ->shouldBeCalledOnce();
        $cache
            ->getItem('2')
            ->shouldBeCalledOnce();
        $cache
            ->getItem('3')
            ->shouldBeCalledOnce();

        $cache
            ->getItem('0')
            ->willReturn($cacheItemFound0);

        $cache
            ->getItem('1')
            ->willReturn($cacheItemNotFound1);

        $cache
            ->getItem('2')
            ->willReturn($cacheItemNotFound2);

        $cache
            ->getItem('3')
            ->willReturn($cacheItemNotFound3);

        $cacheItemFound0
            ->isHit()
            ->willReturn(true);

        $cacheItemNotFound1
            ->isHit()
            ->willReturn(false);

        $cacheItemNotFound2
            ->isHit()
            ->willReturn(false);

        $cacheItemNotFound3
            ->isHit()
            ->willReturn(false);

        $cacheItemNotFound1
            ->set([1, 'b'])
            ->shouldBeCalledOnce();

        $cacheItemNotFound2
            ->set([2, 'c'])
            ->shouldBeCalledOnce();

        $cache
            ->save($cacheItemNotFound1)
            ->shouldBeCalledOnce();

        $cacheItemFound0
            ->get()
            ->willReturn([0, 'a']);

        $cache
            ->save($cacheItemNotFound1)
            ->shouldBeCalled();

        $cacheItemNotFound1
            ->get()
            ->willReturn([1, 'b']);

        $cache
            ->save($cacheItemNotFound2)
            ->shouldBeCalled();

        $cacheItemNotFound2
            ->get()
            ->willReturn([2, 'c']);

        $this::fromResource($fhandle)
            ->cache($cache)
            ->shouldIterateAs(['a', 'b', 'c']);

        $fhandle = fopen(__DIR__ . '/../../fixtures/sample.txt', 'rb');

        $this::fromResource($fhandle)
            ->cache()
            ->shouldIterateAs(['a', 'b', 'c']);
    }

    public function it_can_chunk(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->chunk(2)
            ->shouldIterateAs([[0 => 'A', 1 => 'B'], [0 => 'C', 1 => 'D'], [0 => 'E', 1 => 'F']]);

        $this::fromIterable(range('A', 'F'))
            ->chunk(0)
            ->shouldIterateAs([]);

        $this::fromIterable(range('A', 'F'))
            ->chunk(1)
            ->shouldIterateAs([[0 => 'A'], [0 => 'B'], [0 => 'C'], [0 => 'D'], [0 => 'E'], [0 => 'F']]);

        $this::fromIterable(range('A', 'F'))
            ->chunk(2, 3)
            ->shouldIterateAs([[0 => 'A', 1 => 'B'], [0 => 'C', 1 => 'D', 2 => 'E'], [0 => 'F']]);
    }

    public function it_can_collapse(): void
    {
        $generator = static function () {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 'foo' => 'C';

            yield 0 => 'E';

            yield 1 => 'F';
        };

        $this::fromIterable([
            ['A', 'B', 'foo' => 'C'],
            'D',
            ['E', 'F'],
            'G',
        ])
            ->collapse()
            ->shouldIterateAs($generator());

        $this::fromIterable(range('A', 'E'))
            ->collapse()
            ->shouldIterateAs([]);
    }

    public function it_can_column(): void
    {
        $records = [
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

        $this::fromIterable($records)
            ->column('first_name')
            ->shouldIterateAs(
                [
                    0 => 'John',
                    1 => 'Sally',
                    2 => 'Jane',
                    3 => 'Peter',
                ]
            );
    }

    public function it_can_combinate(): void
    {
        $this::fromIterable(range('a', 'c'))
            ->combinate(0)
            ->shouldIterateAs(
                [
                    [
                        0 => 'a',
                        1 => 'b',
                        2 => 'c',
                    ],
                ]
            );

        $this::fromIterable(range('a', 'c'))
            ->combinate(1)
            ->shouldIterateAs(
                [
                    [
                        'a',
                    ],
                    [
                        'b',
                    ],
                    [
                        'c',
                    ],
                ]
            );

        $this::fromIterable(range('a', 'c'))
            ->combinate()
            ->all()
            ->shouldBeEqualTo(
                [
                    0 => [
                        0 => 'a',
                        1 => 'b',
                        2 => 'c',
                    ],
                    1 => [
                        0 => 'a',
                        1 => 'c',
                    ],
                    2 => [
                        0 => 'b',
                        1 => 'c',
                    ],
                ]
            );
    }

    public function it_can_combine(): void
    {
        $this::fromIterable(range('A', 'E'))
            ->combine(...range('e', 'a'))
            ->shouldIterateAs(['e' => 'A', 'd' => 'B', 'c' => 'C', 'b' => 'D', 'a' => 'E']);

        $this::fromIterable(range('A', 'E'))
            ->combine(...range(1, 100))
            ->shouldThrow(Exception::class)
            ->during('all');
    }

    public function it_can_compact(): void
    {
        $input = ['a', 1 => 'b', null, false, 0, 'c'];

        $this::fromIterable($input)
            ->compact()
            ->shouldIterateAs(['a', 1 => 'b', 3 => false, 4 => 0, 5 => 'c']);

        $this::fromIterable($input)
            ->compact(null, 0)
            ->shouldIterateAs(['a', 1 => 'b', 3 => false, 5 => 'c']);
    }

    public function it_can_contains(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->contains('A')
            ->shouldReturn(true);

        $this::fromIterable(range('A', 'C'))
            ->contains('unknown')
            ->shouldReturn(false);
    }

    public function it_can_convert_use_a_string_as_parameter(): void
    {
        $this::fromString('foo')
            ->shouldIterateAs([0 => 'f', 1 => 'o', 2 => 'o']);

        $this::fromString('hello, world', ',')
            ->shouldIterateAs([0 => 'hello', 1 => ' world']);
    }

    public function it_can_count_its_items(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->count()
            ->shouldReturn(3);
    }

    public function it_can_cycle(): void
    {
        $iterable = ['a' => '1', 'b' => '2', 'c' => '3'];

        $this::fromIterable($iterable)
            ->cycle()
            ->shouldIterateAs([]);

        $generator = static function () {
            yield 'a' => '1';

            yield 'b' => '2';

            yield 'c' => '3';
        };

        $this::fromIterable($iterable)
            ->cycle(3)
            ->shouldIterateAs($generator());

        $generator = static function () {
            yield 'a' => '1';

            yield 'b' => '2';

            yield 'c' => '3';

            yield 'a' => '1';

            yield 'b' => '2';

            yield 'c' => '3';
        };

        $this::fromIterable($iterable)
            ->cycle(6)
            ->shouldIterateAs($generator());

        $generator = static function () {
            yield 'a' => '1';

            yield 'b' => '2';

            yield 'c' => '3';

            yield 'a' => '1';

            yield 'b' => '2';

            yield 'c' => '3';

            yield 'a' => '1';
        };

        $this::fromIterable($iterable)
            ->cycle(7)
            ->shouldIterateAs($generator());
    }

    public function it_can_diff(): void
    {
        $this::fromIterable(range(1, 5))
            ->diff(1, 2, 3, 9)
            ->shouldIterateAs([3 => 4, 4 => 5]);

        $this::fromIterable(range(1, 5))
            ->diff()
            ->shouldIterateAs(range(1, 5));
    }

    public function it_can_diffKeys(): void
    {
        $input = array_combine(range('a', 'e'), range(1, 5));

        $this::fromIterable($input)
            ->diffKeys('b', 'd')
            ->shouldIterateAs(['a' => 1, 'c' => 3, 'e' => 5]);

        $this::fromIterable($input)
            ->diffKeys()
            ->shouldIterateAs($input);
    }

    public function it_can_distinct(): void
    {
        $stdclass = new stdClass();

        $this::fromIterable([1, 1, 2, 2, 3, 3, $stdclass, $stdclass])
            ->distinct()
            ->shouldIterateAs([0 => 1, 2 => 2, 4 => 3, 6 => $stdclass]);
    }

    public function it_can_do_the_cartesian_product(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->product()
            ->shouldIterateAs([0 => ['A'], 1 => ['B'], 2 => ['C']]);

        $this::fromIterable(range('A', 'C'))
            ->product([1, 2])
            ->shouldIterateAs([0 => ['A', 1], 1 => ['A', 2], 2 => ['B', 1], 3 => ['B', 2], 4 => ['C', 1], 5 => ['C', 2]]);
    }

    public function it_can_explode(): void
    {
        $string = 'I am just a random piece of text.';

        $this::fromString($string)
            ->explode('o')
            ->shouldIterateAs(
                [
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
                        16 => 'o',
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
                        8 => 'o',
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
                ]
            );
    }

    public function it_can_falsy(): void
    {
        $this::fromIterable([false, false, false])
            ->falsy()
            ->shouldReturn(true);

        $this::fromIterable([false, true, false])
            ->falsy()
            ->shouldReturn(false);

        $this::fromIterable([0, [], ''])
            ->falsy()
            ->shouldReturn(true);
    }

    public function it_can_filter(): void
    {
        $input = array_merge([0, false], range(1, 10));

        $callable = static function ($value, $key, $iterator) {
            return $value % 2;
        };

        $this::fromIterable($input)
            ->filter($callable)
            ->count()
            ->shouldReturn(5);

        $this::fromIterable($input)
            ->filter($callable)
            ->normalize()
            ->shouldIterateAs([1, 3, 5, 7, 9]);

        $this::fromIterable(['afooe', 'fooe', 'allo', 'llo'])
            ->filter(
                static function ($value) {
                    return 0 === mb_strpos($value, 'a');
                },
                static function ($value) {
                    return mb_strlen($value) - 1 === mb_strpos($value, 'o');
                }
            )
            ->shouldIterateAs([2 => 'allo']);

        $this::fromIterable([true, false, 0, '', null])
            ->filter()
            ->shouldIterateAs([true]);
    }

    public function it_can_flatten(): void
    {
        $input = [];

        for ($j = 0; 5 > $j; ++$j) {
            $items = [];

            for ($i = 0; 2 > $i; ++$i) {
                $items[] = $j * 2 + $i;
            }
            $input[] = $items;
        }

        $input = array_pad([], 5, $input);

        $output = [];

        for ($i = 0; 5 > $i; ++$i) {
            $output = array_merge($output, range(0, 9));
        }

        $this::fromIterable($input)
            ->flatten()
            ->shouldIterateAs($output);

        $output = [];

        $j = 0;

        for ($i = 0; 25 > $i; ++$i) {
            $output[] = [
                $j++ % 10,
                $j++ % 10,
            ];
        }

        $this::fromIterable($input)
            ->flatten(1)
            ->shouldIterateAs($output);
    }

    public function it_can_flip(): void
    {
        $this::fromIterable(range('A', 'E'))
            ->flip()
            ->shouldIterateAs(['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4]);

        $input = [3 / 2, 4 / 3, 5 / 4, 6 / 5, 9 / 8];
        $output = [
            '1.5' => 0,
            '1.3333333333333' => 1,
            '1.25' => 2,
            '1.2' => 3,
            '1.125' => 4,
        ];

        $this::fromIterable($input)
            ->flip()
            ->shouldIterateAs($output);

        $this::fromIterable(['a', 'b', 'c', 'd', 'a'])
            ->flip()
            ->flip()
            ->all()
            ->shouldIterateAs(['a', 'b', 'c', 'd', 'a']);
    }

    public function it_can_fold_from_the_left(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->foldLeft(
                static function (string $carry, string $item): string {
                    $carry .= $item;

                    return $carry;
                },
                ''
            )
            ->shouldReturn('ABC');
    }

    public function it_can_fold_from_the_right(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->foldRight(
                static function (string $carry, string $item): string {
                    $carry .= $item;

                    return $carry;
                },
                ''
            )
            ->shouldReturn('CBA');
    }

    public function it_can_forget(): void
    {
        $this::fromIterable(range('A', 'E'))
            ->forget(0, 4)
            ->shouldIterateAs([1 => 'B', 2 => 'C', 3 => 'D']);
    }

    public function it_can_frequency(): void
    {
        $object = new StdClass();

        $input = ['1', '2', '3', null, '4', '2', null, '6', $object, $object];

        $iterateAs = static function () use ($object): Generator {
            yield 1 => '1';

            yield 2 => '2';

            yield 1 => '3';

            yield 2 => null;

            yield 1 => '4';

            yield 1 => '6';

            yield 2 => $object;
        };

        $this::fromIterable($input)
            ->frequency()
            ->shouldIterateAs($iterateAs());
    }

    public function it_can_get(): void
    {
        $this::fromIterable(range('A', 'E'))
            ->get(4)
            ->shouldReturn('E');

        $this::fromIterable(range('A', 'E'))
            ->get('unexistent key', 'default')
            ->shouldReturn('default');
    }

    public function it_can_get_an_iterator(): void
    {
        $collection = Collection::fromIterable(range(1, 5));

        $this::fromIterable($collection)
            ->getIterator()
            ->shouldImplement(Iterator::class);
    }

    public function it_can_get_items_with_only_specific_keys(): void
    {
        $this::fromIterable(range('A', 'E'))
            ->only(0, 1, 3)
            ->shouldIterateAs([0 => 'A', 1 => 'B', 3 => 'D']);

        $this::fromIterable(range('A', 'E'))
            ->only()
            ->shouldIterateAs([0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E']);
    }

    public function it_can_get_its_first_value(): void
    {
        $this::fromIterable(range(1, 10))
            ->first()
            ->shouldReturn(1);

        $this::fromIterable(range(1, 10))
            ->first(
                static function ($value) {
                    return 0 === $value % 5;
                }
            )
            ->shouldReturn(5);

        $this::fromIterable(range(1, 10))
            ->first(
                static function ($value) {
                    return 0 === $value % 11;
                },
                'foo'
            )
            ->shouldReturn('foo');

        $this::fromIterable([])
            ->first()
            ->shouldBe(null);
    }

    public function it_can_get_the_last_item(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->last()
            ->shouldReturn('F');

        $this::fromIterable(['A'])
            ->last()
            ->shouldReturn('A');

        $this::fromIterable([])
            ->last()
            ->shouldReturn(null);
    }

    public function it_can_group()
    {
        $callback = static function () {
            yield 1 => 'a';

            yield 1 => 'b';

            yield 1 => 'c';

            yield 2 => 'd';

            yield 2 => 'e';

            yield 3 => 'f';

            yield 4 => 'g';

            yield 10 => 'h';
        };

        $this::fromCallable($callback)
            ->group()
            ->shouldIterateAs([
                1 => [
                    'a',
                    'b',
                    'c',
                ],
                2 => [
                    'd',
                    'e',
                ],
                3 => 'f',
                4 => 'g',
                10 => 'h',
            ]);

        $callback = static function ($key, $value) {
            return $value % 2;
        };

        $this::fromIterable(range(0, 20))
            ->group($callback)
            ->shouldIterateAs([
                0 => [
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
                1 => [
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
            ]);
    }

    public function it_can_has(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->has(static function ($key, $value) {
                return 'A';
            })
            ->shouldReturn(true);

        $this::fromIterable(range('A', 'C'))
            ->has(static function ($key, $value) {
                return 'Z';
            })
            ->shouldReturn(false);
    }

    public function it_can_implode(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->implode('-')
            ->shouldReturn('A-B-C');

        $this::fromIterable(range('A', 'C'))
            ->implode()
            ->shouldReturn('ABC');
    }

    public function it_can_intersect(): void
    {
        $this::fromIterable(range(1, 5))
            ->intersect(1, 2, 3, 9)
            ->shouldIterateAs([0 => 1, 1 => 2, 2 => 3]);

        $this::fromIterable(range(1, 5))
            ->intersect()
            ->shouldIterateAs([]);
    }

    public function it_can_intersectKeys(): void
    {
        $input = array_combine(range('a', 'e'), range(1, 5));

        $this::fromIterable($input)
            ->intersectKeys('b', 'd')
            ->shouldIterateAs(['b' => 2, 'd' => 4]);

        $this::fromIterable($input)
            ->intersectKeys()
            ->shouldIterateAs([]);
    }

    public function it_can_intersperse(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->intersperse('foo')
            ->shouldIterateAs([
                0 => 'foo',
                1 => 'A',
                2 => 'foo',
                3 => 'B',
                4 => 'foo',
                5 => 'C',
                6 => 'foo',
                7 => 'D',
                8 => 'foo',
                9 => 'E',
                10 => 'foo',
                11 => 'F',
            ]);

        $this::fromIterable(range('A', 'F'))
            ->intersperse('foo', 2, 0)
            ->shouldIterateAs([
                0 => 'foo',
                1 => 'A',
                2 => 'B',
                3 => 'foo',
                4 => 'C',
                5 => 'D',
                6 => 'foo',
                7 => 'E',
                8 => 'F',
            ]);

        $this::fromIterable(range('A', 'F'))
            ->intersperse('foo', 2, 1)
            ->shouldIterateAs([
                0 => 'A',
                1 => 'foo',
                2 => 'B',
                3 => 'C',
                4 => 'foo',
                5 => 'D',
                6 => 'E',
                7 => 'foo',
                8 => 'F',
            ]);

        $this::fromIterable(range('A', 'F'))
            ->intersperse('foo', 2, 2)
            ->shouldIterateAs([
                0 => 'foo',
                1 => 'A',
                2 => 'B',
                3 => 'foo',
                4 => 'C',
                5 => 'D',
                6 => 'foo',
                7 => 'E',
                8 => 'F',
            ]);

        $this::fromIterable(range('A', 'F'))
            ->shouldThrow(Exception::class)
            ->during('intersperse', ['foo', -1, 1]);

        $this::fromIterable(range('A', 'F'))
            ->shouldThrow(Exception::class)
            ->during('intersperse', ['foo', 1, -1]);
    }

    public function it_can_iterate(): void
    {
        $fibonacci = static function ($value1, $value2) {
            return ['previous' => $value2, 'next' => $value1 + $value2];
        };

        $this::iterate($fibonacci, 0, 1)
            ->map(static function ($item) {
                return $item['previous'];
            })
            ->limit(10)
            ->shouldIterateAs([1, 1, 2, 3, 5, 8, 13, 21, 34, 55]);

        $plusOne = static function ($value) {
            return $value + 1;
        };

        $this::iterate($plusOne, 0)
            ->limit(10)
            ->shouldIterateAs([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }

    public function it_can_keys(): void
    {
        $this::fromIterable(range('A', 'E'))
            ->keys()
            ->shouldIterateAs(range(0, 4));
    }

    public function it_can_limit(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->limit(3)
            ->shouldHaveCount(3);

        $this::fromIterable(range('A', 'F'))
            ->limit(3)
            ->shouldIterateAs(['A', 'B', 'C']);
    }

    public function it_can_loop(): void
    {
        $generator = static function (): Generator {
            yield 0 => 1;

            yield 1 => 2;

            yield 2 => 3;

            yield 0 => 1;

            yield 1 => 2;

            yield 2 => 3;
        };

        $this::fromIterable(range(1, 3))
            ->loop()
            ->limit(6)
            ->shouldIterateAs($generator());
    }

    public function it_can_map(): void
    {
        $input = array_combine(range('A', 'E'), range('A', 'E'));

        $this::fromIterable($input)
            ->map(static function (string $item): string {
                return $item . $item;
            })
            ->shouldIterateAs(['A' => 'AA', 'B' => 'BB', 'C' => 'CC', 'D' => 'DD', 'E' => 'EE']);
    }

    public function it_can_merge(): void
    {
        $collection = Collection::fromCallable(static function () {
            yield from range('F', 'J');
        });

        $generator = static function (): Generator {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'C';

            yield 3 => 'D';

            yield 4 => 'E';

            yield 0 => 'F';

            yield 1 => 'G';

            yield 2 => 'H';

            yield 3 => 'I';

            yield 4 => 'J';
        };

        $this::fromIterable(range('A', 'E'))
            ->merge($collection->all())
            ->shouldIterateAs($generator());
    }

    public function it_can_nth(): void
    {
        $this::fromIterable(range(0, 70))
            ->nth(7)
            ->shouldIterateAs([0 => 0, 7 => 7, 14 => 14, 21 => 21, 28 => 28, 35 => 35, 42 => 42, 49 => 49, 56 => 56, 63 => 63, 70 => 70]);

        $this::fromIterable(range(0, 70))
            ->nth(7, 3)
            ->shouldIterateAs([3 => 3, 10 => 10, 17 => 17, 24 => 24, 31 => 31, 38 => 38, 45 => 45, 52 => 52, 59 => 59, 66 => 66]);
    }

    public function it_can_nullsy(): void
    {
        $this::fromIterable([null, null, null])
            ->nullsy()
            ->shouldReturn(true);

        $this::fromIterable([null, 0, null])
            ->nullsy()
            ->shouldReturn(false);
    }

    public function it_can_pad(): void
    {
        $input = array_combine(range('A', 'E'), range('A', 'E'));

        $this::fromIterable($input)
            ->pad(10, 'foo')
            ->shouldIterateAs(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 0 => 'foo', 1 => 'foo', 2 => 'foo', 3 => 'foo', 4 => 'foo']);
    }

    public function it_can_permutate(): void
    {
        $this::fromIterable(range('a', 'c'))
            ->permutate()
            ->shouldIterateAs(
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
                ]
            );
    }

    public function it_can_pluck(): void
    {
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

        $this::fromIterable($input)
            ->pluck('foo')
            ->shouldIterateAs([0 => ['bar' => 0], 1 => ['bar' => 1], 2 => ['bar' => 2], 3 => ['bar' => 3], 4 => ['bar' => 4], 5 => ['bar' => 5], 6 => ['bar' => $six]]);

        $this::fromIterable($input)
            ->pluck('foo.*')
            ->shouldIterateAs([0 => [0 => 0], 1 => [0 => 1], 2 => [0 => 2], 3 => [0 => 3], 4 => [0 => 4], 5 => [0 => 5], 6 => [0 => $six]]);

        $this::fromIterable($input)
            ->pluck('.foo.bar.')
            ->shouldIterateAs([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => $six]);

        $this::fromIterable($input)
            ->pluck('foo.bar.*', 'taz')
            ->shouldIterateAs([0 => 'taz', 1 => 'taz', 2 => 'taz', 3 => 'taz', 4 => 'taz', 5 => 'taz', 6 => 'taz']);

        $this::fromIterable($input)
            ->pluck('azerty', 'taz')
            ->shouldIterateAs([0 => 'taz', 1 => 'taz', 2 => 'taz', 3 => 'taz', 4 => 'taz', 5 => 'taz', 6 => 'taz']);

        $this::fromIterable($input)
            ->pluck(0)
            ->shouldIterateAs([0 => 'A', 1 => 'B', 2 => 'C', null, null, null, 6 => 'D']);
    }

    public function it_can_prepend(): void
    {
        $generator = static function (): Generator {
            yield 0 => 'A';

            yield 1 => 'B';

            yield 2 => 'C';

            yield 0 => 'D';

            yield 1 => 'E';

            yield 2 => 'F';
        };

        $this::fromIterable(range('D', 'F'))
            ->prepend('A', 'B', 'C')
            ->shouldIterateAs($generator());
    }

    public function it_can_random(): void
    {
        $input = range('a', 'z');

        $generator = static function (array $input): Generator {
            yield from $input;
        };

        $this::fromIterable($input)
            ->random()
            ->count()
            ->shouldBeEqualTo(1);

        $this::fromIterable($input)
            ->random(100)
            ->count()
            ->shouldBeEqualTo(26);

        $this::fromIterable($input)
            ->random(26)
            ->shouldNotIterateAs($generator($input));
    }

    public function it_can_reduce(): void
    {
        $this::fromIterable(range(1, 100))
            ->reduce(
                static function ($carry, $item) {
                    return $carry + $item;
                },
                0
            )
            ->shouldReturn(5050);
    }

    public function it_can_reduction(): void
    {
        $this::fromIterable(range(1, 5))
            ->reduction(
                static function ($carry, $item) {
                    return $carry + $item;
                },
                0
            )
            ->shouldIterateAs([1, 3, 6, 10, 15]);
    }

    public function it_can_reverse(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->reverse()
            ->shouldIterateAs([5 => 'F', 4 => 'E', 3 => 'D', 2 => 'C', 1 => 'B', 0 => 'A']);

        $this::fromIterable(range('A', 'F'))
            ->skip(3, 3)
            ->shouldIterateAs([]);
    }

    public function it_can_rsample(): void
    {
        $this::fromIterable(range(1, 10))
            ->rsample(1)
            ->shouldHaveCount(10);

        $this::fromIterable(range(1, 10))
            ->rsample(.5)
            ->shouldNotHaveCount(10);
    }

    public function it_can_run_an_operation(Operation $operation): void
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

        $map = new class() extends AbstractOperation implements Operation {
            public function __invoke(): Closure
            {
                return static function ($collection) {
                    foreach ($collection as $item) {
                        yield (int) $item;
                    }
                };
            }
        };

        $this::fromIterable(range(1, 5))
            ->run($square, $sqrt, $map)
            ->shouldIterateAs(range(1, 5));
    }

    public function it_can_scale(): void
    {
        $input = [0, 2, 4, 6, 8, 10];

        $this::fromIterable($input)
            ->scale(0, 10)
            // @todo: For some reason, using shouldIterateAs does not work here.
            ->all()
            ->shouldReturn([0.0, 0.2, 0.4, 0.6, 0.8, 1.0]);

        $this::fromIterable($input)
            ->scale(0, 10, 5, 15, 3)
            ->walk(static function ($value) {
                return (float) round($value, 2);
            })
            // @todo: For some reason, using shouldIterateAs does not work here.
            ->all()
            ->shouldReturn([5.0, 8.01, 11.02, 12.78, 14.03, 15.0]);
    }

    public function it_can_shuffle(): void
    {
        $data = range('A', 'Z');

        $this::fromIterable($data)
            ->shuffle()
            ->shouldNotIterateAs($data);

        $this::fromIterable($data)
            ->shuffle()
            ->shouldNotIterateAs([]);
    }

    public function it_can_since(): void
    {
        $this::fromIterable(range('a', 'z'))
            ->since(
                static function ($letter) {
                    return 'x' === $letter;
                }
            )
            ->shouldIterateAs([23 => 'x', 24 => 'y', 25 => 'z']);

        $this::fromIterable(range('a', 'z'))
            ->since(
                static function ($letter) {
                    return 'x' === $letter;
                },
                static function ($letter) {
                    return 1 === mb_strlen($letter);
                }
            )
            ->shouldIterateAs([23 => 'x', 24 => 'y', 25 => 'z']);

        $this::fromIterable(range('a', 'z'))
            ->since(
                static function ($letter) {
                    return 'foo' === $letter;
                },
                static function ($letter) {
                    return 'x' === $letter;
                }
            )
            ->shouldIterateAs([]);
    }

    public function it_can_skip(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->skip(3)
            ->shouldIterateAs([3 => 'D', 4 => 'E', 5 => 'F']);

        $this::fromIterable(range('A', 'F'))
            ->skip(3, 3)
            ->shouldIterateAs([]);
    }

    public function it_can_slice(): void
    {
        $this::fromIterable(range(0, 10))
            ->slice(5)
            ->shouldIterateAs([5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]);

        $this::fromIterable(range(0, 10))
            ->slice(5, 2)
            ->shouldIterateAs([5 => 5, 6 => 6]);

        $this::fromIterable(range(0, 10))
            ->slice(5, 1000)
            ->shouldIterateAs([5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]);
    }

    public function it_can_sort(): void
    {
        $input = range('A', 'E');
        $input = array_combine($input, $input);

        $this::fromIterable($input)
            ->sort()
            ->shouldIterateAs($input);

        $this::fromIterable($input)
            ->sort(
                static function ($left, $right): int {
                    return $right <=> $left;
                }
            )
            ->shouldIterateAs(array_reverse($input, true));
    }

    public function it_can_split(): void
    {
        $this::fromIterable(range(1, 17))
            ->split(static function ($value) {
                return 0 === $value % 3;
            })
            ->shouldIterateAs([0 => [1, 2, 3], 1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [13, 14, 15], 5 => [16, 17]]);

        $this::fromIterable(range(1, 15))
            ->split(static function ($value) {
                return 0 === $value % 3;
            })
            ->shouldIterateAs([0 => [1, 2, 3], 1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [13, 14, 15]]);
    }

    public function it_can_tail(): void
    {
        $this::fromIterable(range('A', 'F'))
            ->tail()
            ->shouldIterateAs([5 => 'F']);

        $this::fromIterable(range('A', 'F'))
            ->tail(3)
            ->shouldIterateAs([3 => 'D', 4 => 'E', 5 => 'F']);

        $this::fromIterable(range('A', 'F'))
            ->tail(-5)
            ->shouldThrow(OutOfRangeException::class)
            ->during('all');

        $this::fromIterable(range('A', 'F'))
            ->tail(100)
            ->shouldIterateAs(range('A', 'F'));

        $this::fromIterable(['a', 'b', 'c', 'd', 'a'])
            ->flip()
            ->flip()
            ->tail(2)
            ->all()
            ->shouldIterateAs([3 => 'd', 4 => 'a']);
    }

    public function it_can_transpose(): void
    {
        $records = [
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

        $this::fromIterable($records)
            ->transpose()
            ->shouldIterateAs(
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
                ]
            );
    }

    public function it_can_truthy(): void
    {
        $this::fromIterable([true, true, true])
            ->truthy()
            ->shouldReturn(true);

        $this::fromIterable([true, false, true])
            ->truthy()
            ->shouldReturn(false);
    }

    public function it_can_until(): void
    {
        $collatz = static function (int $initial = 1): int {
            return 0 === $initial % 2 ?
                $initial / 2 :
                $initial * 3 + 1;
        };

        $until = static function (int $number): bool {
            return 1 === $number;
        };

        $this::iterate($collatz, 10)
            ->until($until)
            ->shouldIterateAs([5, 16, 8, 4, 2, 1]);
    }

    public function it_can_unwrap()
    {
        $this::fromIterable([['a' => 'A'], ['b' => 'B'], ['c' => 'C']])
            ->unwrap()
            ->shouldIterateAs([
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
            ]);

        $this::fromIterable(['foo' => ['a' => 'A'], 'bar' => ['b' => 'B'], 'foobar' => ['c' => 'C', 'd' => 'D']])
            ->unwrap()
            ->shouldIterateAs([
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
                'd' => 'D',
            ]);
    }

    public function it_can_use_range(): void
    {
        $this::range(0, 5)
            ->shouldIterateAs([(float) 0, (float) 1, (float) 2, (float) 3, (float) 4]);

        $this::range(1, 10, 2)
            ->shouldIterateAs([(float) 1, (float) 3, (float) 5, (float) 7, (float) 9]);

        $this::range(-5, 5, 2)
            ->shouldIterateAs([0 => (float) -5, 1 => (float) -3, 2 => (float) -1, 3 => (float) 1, 4 => (float) 3]);

        $this::range()
            ->limit(10)
            ->shouldIterateAs([0 => (float) 0, 1 => (float) 1, 2 => (float) 2, 3 => (float) 3, 4 => (float) 4, 5 => (float) 5, 6 => (float) 6, 7 => (float) 7, 8 => (float) 8, 9 => (float) 9]);
    }

    public function it_can_use_range_with_value_1(): void
    {
        $this::range(0, 1)
            ->shouldIterateAs([(float) 0]);
    }

    public function it_can_use_times_with_a_callback(): void
    {
        $a = [[1, 2, 3, 4, 5], [1, 2, 3, 4, 5]];

        $this::times(2, static function () {
            return range(1, 5);
        })
            ->shouldIterateAs($a);
    }

    public function it_can_use_times_without_a_callback(): void
    {
        $this::times(10)
            ->shouldIterateAs(range(1, 10));

        $this::times(10)
            ->shouldThrow(InvalidArgumentException::class)
            ->during('times', [-5]);

        $this::times(1)
            ->shouldIterateAs([1]);
    }

    public function it_can_use_with(): void
    {
        $input = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        $generator = static function () {
            yield 'a' => 'A';

            yield 'b' => 'B';

            yield 'c' => 'C';
        };

        $this::with($input)
            ->shouldIterateAs($generator());

        $this::with($generator)
            ->shouldIterateAs($generator());

        $this::with('abc')
            ->shouldIterateAs(['a', 'b', 'c']);

        $this::with('abc def', ' ')
            ->shouldIterateAs(['abc', 'def']);

        $stream = static function () {
            $stream = fopen(__DIR__ . '/../../../.editorconfig', 'rb');

            while (false !== $chunk = fgetc($stream)) {
                yield $chunk;
            }

            fclose($stream);
        };

        $this::with($stream)
            ->split(static function ($v) {
                return "\n" === $v;
            })
            ->tail(1)
            ->unwrap()
            ->implode()
            ->shouldReturn('indent_size = 4');

        $stream = fopen(__DIR__ . '/../../fixtures/sample.txt', 'rb');

        $this::with($stream)
            ->shouldIterateAs(['a', 'b', 'c']);

        $this::with(1)
            ->shouldIterateAs([1]);
    }

    public function it_can_walk(): void
    {
        $input = array_combine(range('A', 'E'), range('A', 'E'));

        $this::fromIterable($input)
            ->walk(static function (string $item) {
                return $item . $item;
            })
            ->shouldIterateAs(['A' => 'AA', 'B' => 'BB', 'C' => 'CC', 'D' => 'DD', 'E' => 'EE']);

        $this::fromIterable(range(1, 10))
            ->walk(static function ($item) {
                return $item * 2;
            }, static function ($item) {
                return $item + 1;
            })
            ->shouldIterateAs(range(3, 21, 2));

        $this::fromIterable(range(1, 10))
            ->walk(static function ($item) {
                return $item;
            }, static function ($item) {
                return $item;
            })
            ->shouldIterateAs(range(1, 10));
    }

    public function it_can_window(): void
    {
        $this::fromIterable(range('a', 'z'))
            ->window(2, 4, 3)
            ->shouldIterateAs([
                0 => [
                    0 => 'a',
                    1 => 'b',
                ],
                1 => [
                    1 => 'b',
                    2 => 'c',
                    3 => 'd',
                    4 => 'e',
                ],
                2 => [
                    2 => 'c',
                    3 => 'd',
                    4 => 'e',
                ],
                3 => [
                    3 => 'd',
                    4 => 'e',
                ],
                4 => [
                    4 => 'e',
                    5 => 'f',
                    6 => 'g',
                    7 => 'h',
                ],
                5 => [
                    5 => 'f',
                    6 => 'g',
                    7 => 'h',
                ],
                6 => [
                    6 => 'g',
                    7 => 'h',
                ],
                7 => [
                    7 => 'h',
                    8 => 'i',
                    9 => 'j',
                    10 => 'k',
                ],
                8 => [
                    8 => 'i',
                    9 => 'j',
                    10 => 'k',
                ],
                9 => [
                    9 => 'j',
                    10 => 'k',
                ],
                10 => [
                    10 => 'k',
                    11 => 'l',
                    12 => 'm',
                    13 => 'n',
                ],
                11 => [
                    11 => 'l',
                    12 => 'm',
                    13 => 'n',
                ],
                12 => [
                    12 => 'm',
                    13 => 'n',
                ],
                13 => [
                    13 => 'n',
                    14 => 'o',
                    15 => 'p',
                    16 => 'q',
                ],
                14 => [
                    14 => 'o',
                    15 => 'p',
                    16 => 'q',
                ],
                15 => [
                    15 => 'p',
                    16 => 'q',
                ],
                16 => [
                    16 => 'q',
                    17 => 'r',
                    18 => 's',
                    19 => 't',
                ],
                17 => [
                    17 => 'r',
                    18 => 's',
                    19 => 't',
                ],
                18 => [
                    18 => 's',
                    19 => 't',
                ],
                19 => [
                    19 => 't',
                    20 => 'u',
                    21 => 'v',
                    22 => 'w',
                ],
                20 => [
                    20 => 'u',
                    21 => 'v',
                    22 => 'w',
                ],
                21 => [
                    21 => 'v',
                    22 => 'w',
                ],
                22 => [
                    22 => 'w',
                    23 => 'x',
                    24 => 'y',
                    25 => 'z',
                ],
                23 => [
                    23 => 'x',
                    24 => 'y',
                    25 => 'z',
                ],
                24 => [
                    24 => 'y',
                    25 => 'z',
                ],
                25 => [
                    25 => 'z',
                ],
            ]);
    }

    public function it_can_wrap()
    {
        $this::fromIterable(['a' => 'A', 'b' => 'B', 'c' => 'C'])
            ->wrap()
            ->shouldIterateAs([
                ['a' => 'A'],
                ['b' => 'B'],
                ['c' => 'C'],
            ]);
    }

    public function it_can_zip(): void
    {
        $this::fromIterable(range('A', 'C'))
            ->zip(['D', 'E', 'F'])
            ->all()
            ->shouldReturn([['A', 'D'], ['B', 'E'], ['C', 'F']]);

        $this::fromIterable(['A', 'C', 'E'])
            ->zip(['B', 'D', 'F', 'H'])
            ->all()
            ->shouldReturn([['A', 'B'], ['C', 'D'], ['E', 'F'], [null, 'H']]);

        $collection = Collection::fromIterable(range(1, 5));

        $this::fromIterable($collection)
            ->zip(range('A', 'E'))
            ->all()
            ->shouldReturn([[1, 'A'], [2, 'B'], [3, 'C'], [4, 'D'], [5, 'E']]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Collection::class);
    }
}
