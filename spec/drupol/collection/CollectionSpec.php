<?php

declare(strict_types=1);

namespace spec\drupol\collection;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Contract\Operation;
use PhpSpec\ObjectBehavior;

class CollectionSpec extends ObjectBehavior
{
    public function it_can_append_items(): void
    {
        $this
            ->beConstructedThrough('with', [new \ArrayObject(['1', '2', '3'])]);

        $this
            ->append('4')
            ->all()
            ->shouldReturn(['1', '2', '3', '4']);

        $this
            ->append('5', '6')
            ->all()
            ->shouldReturn(['1', '2', '3', '5', '6']);

        $this
            ->all()
            ->shouldReturn(['1', '2', '3']);
    }

    public function it_can_apply(): void
    {
        $this
            ->beConstructedThrough('with', [\range(1, 10)]);

        $this
            ->apply(static function ($item) {
                // do what you want here.

                return true;
            })
            ->shouldIterateAs(\range(1, 10));

        $this
            ->apply(static function ($item) {
                // do what you want here.

                return false;
            })
            ->shouldIterateAs(\range(1, 10));

        $this
            ->apply(static function ($item): void {
                $item %= 2;
            })
            ->shouldIterateAs([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $this
            ->apply(static function ($item) {
                return false;
            })
            ->shouldReturn($this);

        $callback = static function (): void {
            throw new \Exception('foo');
        };

        $this
            ->shouldThrow(\Exception::class)
            ->during('apply', [$callback]);

        $context = [];

        $applyCallback1 = static function ($item, $key) use (&$context) {
            if (3 > $item) {
                $context[] = 0;

                return 0;
            }

            if (3 <= $item && 6 > $item) {
                $context[] = true;

                return true;
            }

            if (9 < $item) {
                $context[] = 'nine';

                return false;
            }

            $context[] = $item;
        };

        $walkCallback2 = static function ($item) {
            if (3 > $item) {
                return 0;
            }

            if (3 <= $item && 6 > $item) {
                return true;
            }

            if (10 === $item) {
                return 'nine';
            }

            if (10 < $item) {
                return false;
            }

            return $item;
        };

        $this::with(\range(1, 20))
            ->apply($applyCallback1)
            ->walk($walkCallback2)
            ->filter(static function ($item) {
                return false !== $item;
            })
            ->all()
            ->shouldReturn($context);

        $context = [];

        $applyCallback1 = static function ($item, $key) use (&$context) {
            $context[] = $item;

            return true;
        };

        $walkCallback2 = static function ($item) {
            return $item;
        };

        $this::with(\range(1, 20))
            ->apply($applyCallback1)
            ->walk($walkCallback2)
            ->all()
            ->shouldReturn($context);
    }

    public function it_can_be_constructed_from_array(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->all()
            ->shouldReturn(['A', 'B', 'C', 'D', 'E']);
    }

    public function it_can_be_constructed_from_empty(): void
    {
        $this
            ->beConstructedThrough('empty');

        $this
            ->all()
            ->shouldReturn([]);
    }

    public function it_can_be_constructed_with_a_closure(): void
    {
        $this
            ->beConstructedThrough('with', [static function () {
                yield from \range(1, 3);
            }]);
        $this->shouldImplement(CollectionInterface::class);
    }

    public function it_can_be_constructed_with_an_array(): void
    {
        $this
            ->beConstructedThrough('with', [['1', '2', '3']]);
        $this->shouldImplement(CollectionInterface::class);
    }

    public function it_can_be_constructed_with_an_arrayObject(): void
    {
        $this
            ->beConstructedThrough('with', [new \ArrayObject([1, 2, 3])]);
        $this->shouldImplement(CollectionInterface::class);
    }

    public function it_can_be_instantiated_with_withClosure(): void
    {
        $fibonacci = static function ($start = 0, $inc = 1) {
            yield $start;

            while (true) {
                $inc = $start + $inc;
                $start = $inc - $start;

                yield $start;
            }
        };

        $this
            ->beConstructedThrough('with', [$fibonacci]);

        $this
            ->limit(10)
            ->shouldIterateAs([0, 1, 1, 2, 3, 5, 8, 13, 21, 34]);
    }

    public function it_can_be_returned_as_an_array(): void
    {
        $this
            ->beConstructedThrough('with', [new \ArrayObject(['1', '2', '3'])]);

        $this
            ->all()
            ->shouldReturn(['1', '2', '3']);
    }

    public function it_can_chunk(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'F')]);

        $this
            ->chunk(2)
            ->all()
            ->shouldReturn([[0 => 'A', 1 => 'B'], [2 => 'C', 3 => 'D'], [4 => 'E', 5 => 'F']]);

        $this
            ->chunk(0)
            ->all()
            ->shouldReturn([]);

        $this
            ->chunk(1)
            ->all()
            ->shouldReturn([[0 => 'A'], [1 => 'B'], [2 => 'C'], [3 => 'D'], [4 => 'E'], [5 => 'F']]);
    }

    public function it_can_collapse(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'J')]);

        $this
            ->chunk(2)
            ->collapse()
            ->all()
            ->shouldReturn(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']);
    }

    public function it_can_combine(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->combine(\range('e', 'a'))
            ->shouldIterateAs(['e' => 'A', 'd' => 'B', 'c' => 'C', 'b' => 'D', 'a' => 'E']);

        $this
            ->combine(\range(1, 100))
            ->shouldThrow(\Exception::class)
            ->during('all');
    }

    public function it_can_contains(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'C')]);

        $this
            ->contains('A')
            ->shouldReturn(true);

        $this
            ->contains(static function ($item) {
                return 'A' === $item;
            })
            ->shouldReturn(true);
    }

    public function it_can_convert_use_a_string_as_parameter(): void
    {
        $this
            ->beConstructedThrough('with', ['foo']);

        $this
            ->shouldIterateAs(['foo']);
    }

    public function it_can_count_its_items(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'C')]);

        $this
            ->count()
            ->shouldReturn(3);
    }

    public function it_can_filter_its_element(): void
    {
        $input = \array_merge([0, false], \range(1, 10));

        $this
            ->beConstructedThrough('with', [$input]);

        $callable = static function ($item) {
            return $item % 2;
        };

        $this
            ->filter($callable)
            ->count()
            ->shouldReturn(5);

        $this
            ->filter($callable)
            ->normalize()
            ->all()
            ->shouldReturn([1, 3, 5, 7, 9]);

        $this
            ->filter()
            ->normalize()
            ->all()
            ->shouldReturn([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
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

        $input = \array_pad([], 5, $input);

        $this
            ->beConstructedThrough('with', [$input]);

        $output = [];

        for ($i = 0; 5 > $i; ++$i) {
            $output = \array_merge($output, \range(0, 9));
        }

        $this
            ->flatten()
            ->all()
            ->shouldReturn($output);

        $output = [];

        $j = 0;

        for ($i = 0; 25 > $i; ++$i) {
            $output[] = [
                $j++ % 10,
                $j++ % 10,
            ];
        }

        $this
            ->flatten(1)
            ->all()
            ->shouldReturn($output);
    }

    public function it_can_flip(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->flip()
            ->all()
            ->shouldReturn(['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4]);
    }

    public function it_can_forget(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->forget(0, 4)
            ->normalize()
            ->all()
            ->shouldReturn(['B', 'C', 'D']);
    }

    public function it_can_get(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->get(4)
            ->shouldReturn('E');

        $this
            ->get('unexistent key', 'default')
            ->shouldReturn('default');
    }

    public function it_can_get_an_iterator(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'J')]);

        $collection = Collection::with(\range(1, 5));

        $this::with($collection)
            ->getIterator()
            ->shouldImplement(\Iterator::class);
    }

    public function it_can_get_items_with_only_specific_keys(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->only(0, 1, 3)
            ->all()
            ->shouldReturn([0 => 'A', 1 => 'B', 3 => 'D']);

        $this
            ->only()
            ->all()
            ->shouldReturn([0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E']);
    }

    public function it_can_get_its_first_value(): void
    {
        $this
            ->beConstructedThrough('with', [\range(1, 10)]);

        $this
            ->first()
            ->shouldReturn(1);

        $this
            ->first(
                static function ($value) {
                    return 0 === $value % 5;
                }
            )
            ->shouldReturn(5);

        $this
            ->first(
                static function ($value) {
                    return 0 === $value % 11;
                },
                'foo'
            )
            ->shouldReturn('foo');

        $this::with([])
            ->first()
            ->shouldBe(null);
    }

    public function it_can_get_the_last_item(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'F')]);

        $this
            ->last()
            ->shouldReturn('F');

        $this::with(['A'])
            ->last()
            ->shouldReturn('A');

        $this::with([])
            ->last()
            ->shouldReturn(null);
    }

    public function it_can_keys(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $this
            ->keys()
            ->shouldIterateAs(\range(0, 4));
    }

    public function it_can_limit(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'F')]);

        $this
            ->limit(3)
            ->shouldHaveCount(3);

        $this
            ->limit(3)
            ->shouldIterateAs(['A', 'B', 'C']);
    }

    public function it_can_map(): void
    {
        $input = \array_combine(\range('A', 'E'), \range('A', 'E'));

        $this
            ->beConstructedThrough('with', [$input]);

        $this
            ->map(static function (string $item) {
                return $item . $item;
            })
            ->all()
            ->shouldReturn([0 => 'AA', 1 => 'BB', 2 => 'CC', 3 => 'DD', 4 => 'EE']);
    }

    public function it_can_merge(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'E')]);

        $collection = Collection::with(static function () {
            yield from \range('F', 'J');
        });

        $this
            ->merge($collection->all())
            ->normalize()
            ->all()
            ->shouldReturn(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']);
    }

    public function it_can_nth(): void
    {
        $this
            ->beConstructedThrough('with', [\range(0, 70)]);

        $this
            ->nth(7)
            ->shouldIterateAs([0 => 0, 7 => 7, 14 => 14, 21 => 21, 28 => 28, 35 => 35, 42 => 42, 49 => 49, 56 => 56, 63 => 63, 70 => 70]);

        $this
            ->nth(7, 3)
            ->shouldIterateAs([3 => 3, 10 => 10, 17 => 17, 24 => 24, 31 => 31, 38 => 38, 45 => 45, 52 => 52, 59 => 59, 66 => 66]);
    }

    public function it_can_pad(): void
    {
        $input = \array_combine(\range('A', 'E'), \range('A', 'E'));

        $this
            ->beConstructedThrough('with', [$input]);

        $this
            ->pad(10, 'foo')
            ->all()
            ->shouldReturn(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 0 => 'foo', 1 => 'foo', 2 => 'foo', 3 => 'foo', 4 => 'foo']);
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
                'foo' => [
                    'bar' => 0,
                ],
            ],
            [
                'foo' => [
                    'bar' => 1,
                ],
            ],
            [
                'foo' => [
                    'bar' => 2,
                ],
            ],
            Collection::with(
                [
                    'foo' => [
                        'bar' => 3,
                    ],
                ]
            ),
            new \ArrayObject([
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
                'foo' => [
                    'bar' => $six,
                ],
            ],
        ];

        $this::with($input)
            ->pluck('foo')
            ->shouldIterateAs([0 => ['bar' => 0], 1 => ['bar' => 1], 2 => ['bar' => 2], 3 => ['bar' => 3], 4 => ['bar' => 4], 5 => ['bar' => 5], 6 => ['bar' => $six]]);

        $this::with($input)
            ->pluck('foo.*')
            ->shouldIterateAs([0 => [0 => 0], 1 => [0 => 1], 2 => [0 => 2], 3 => [0 => 3], 4 => [0 => 4], 5 => [0 => 5], 6 => [0 => $six]]);

        $this::with($input)
            ->pluck('foo.bar')
            ->shouldIterateAs([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => $six]);

        $this::with($input)
            ->pluck('foo.bar.*', 'taz')
            ->shouldIterateAs([0 => 'taz', 1 => 'taz', 2 => 'taz', 3 => 'taz', 4 => 'taz', 5 => 'taz', 6 => 'taz']);

        $this::with($input)
            ->pluck('azerty', 'taz')
            ->shouldIterateAs([0 => 'taz', 1 => 'taz', 2 => 'taz', 3 => 'taz', 4 => 'taz', 5 => 'taz', 6 => 'taz']);
    }

    public function it_can_prepend(): void
    {
        $this
            ->beConstructedThrough('with', [\range('D', 'F')]);

        $this
            ->prepend('A', 'B', 'C')
            ->normalize()
            ->all()
            ->shouldReturn(['A', 'B', 'C', 'D', 'E', 'F']);
    }

    public function it_can_proxy(): void
    {
        $input1 = new \ArrayObject(\range('A', 'E'));
        $input2 = new \ArrayObject(\range(1, 5));

        $this
            ->beConstructedThrough('with', [[$input1, $input2]]);

        $this
            ->proxy('map', 'count')
            ->all()
            ->shouldReturn([5, 5]);

        $this
            ->shouldThrow(\Exception::class)
            ->during('proxy', ['map', 'foo']);

        $this
            ->shouldThrow(\Exception::class)
            ->during('proxy', ['foo', 'foo']);
    }

    public function it_can_rebase(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'C')]);

        $this
            ->rebase()
            ->all()
            ->shouldBeEqualTo($this->all());
    }

    public function it_can_reduce(): void
    {
        $this
            ->beConstructedThrough('with', [\range(1, 100)]);

        $this
            ->reduce(
                static function ($carry, $item) {
                    return $carry + $item;
                },
                0
            )
            ->shouldReturn(5050);
    }

    public function it_can_run_an_operation(Operation $operation): void
    {
        $square = new class() extends \drupol\collection\Operation\Operation {
            public function run(CollectionInterface $collection)
            {
                return Collection::with(
                    static function () use ($collection) {
                        foreach ($collection as $item) {
                            yield $item ** 2;
                        }
                    }
                );
            }
        };

        $sqrt = new class() extends \drupol\collection\Operation\Operation {
            public function run(CollectionInterface $collection)
            {
                return Collection::with(
                    static function () use ($collection) {
                        foreach ($collection as $item) {
                            yield $item ** .5;
                        }
                    }
                );
            }
        };

        $map = new class() extends \drupol\collection\Operation\Operation {
            public function run(CollectionInterface $collection)
            {
                return Collection::with(
                    static function () use ($collection) {
                        foreach ($collection as $item) {
                            yield (int) $item;
                        }
                    }
                );
            }
        };

        $this::with(\range(1, 5))
            ->run($square, $sqrt, $map)
            ->shouldIterateAs(\range(1, 5));
    }

    public function it_can_skip(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'F')]);

        $this
            ->skip(3)
            ->all()
            ->shouldReturn([3 => 'D', 4 => 'E', 5 => 'F']);

        $this
            ->skip(3, 3)
            ->all()
            ->shouldReturn([]);
    }

    public function it_can_slice(): void
    {
        $this
            ->beConstructedThrough('with', [\range(0, 10)]);

        $this
            ->slice(5)
            ->shouldIterateAs([5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]);

        $this
            ->slice(5, 2)
            ->shouldIterateAs([5 => 5, 6 => 6]);

        $this
            ->slice(5, 1000)
            ->shouldIterateAs([5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]);
    }

    public function it_can_sort(): void
    {
        $input = \range('A', 'E');
        $input = \array_combine($input, $input);

        $this
            ->beConstructedThrough('with', [$input]);

        $this
            ->sort(static function ($item1, $item2) {
                return $item2 <=> $item1;
            })
            ->shouldIterateAs(['E' => 'E', 'D' => 'D', 'C' => 'C', 'B' => 'B', 'A' => 'A']);
    }

    public function it_can_use_range(): void
    {
        $this
            ->beConstructedThrough('range', [0, 5]);

        $this
            ->all()
            ->shouldReturn([0, 1, 2, 3, 4]);

        $this::range(1, 10, 2)
            ->shouldIterateAs([1, 3, 5, 7, 9]);

        $this::range(-5, 5, 2)
            ->shouldIterateAs([0 => -5, 1 => -3, 2 => -1, 3 => 1, 4 => 3]);

        $this::range()
            ->limit(10)
            ->shouldIterateAs([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9]);
    }

    public function it_can_use_range_with_value_1(): void
    {
        $this
            ->beConstructedThrough('range', [0, 1]);

        $this
            ->all()
            ->shouldReturn([0]);
    }

    public function it_can_use_times_with_a_callback(): void
    {
        $this
            ->beConstructedThrough('times', [2, static function () {
                return \range(1, 5);
            }]);

        $a = [[1, 2, 3, 4, 5], [1, 2, 3, 4, 5]];

        $this
            ->all()
            ->shouldReturn($a);
    }

    public function it_can_use_times_without_a_callback(): void
    {
        $this
            ->beConstructedThrough('times', [10]);

        $this
            ->all()
            ->shouldReturn(\range(1, 10));

        $this::times(-5)
            ->all()
            ->shouldReturn([]);

        $this::times(1)
            ->all()
            ->shouldReturn([1]);
    }

    public function it_can_walk(): void
    {
        $input = \array_combine(\range('A', 'E'), \range('A', 'E'));

        $this
            ->beConstructedThrough('with', [$input]);

        $this
            ->walk(static function (string $item) {
                return $item . $item;
            })
            ->all()
            ->shouldReturn(['A' => 'AA', 'B' => 'BB', 'C' => 'CC', 'D' => 'DD', 'E' => 'EE']);

        $this::with(\range(1, 10))
            ->walk(static function ($item) {
                return $item * 2;
            }, static function ($item) {
                return $item + 1;
            })
            ->all()
            ->shouldReturn(\range(3, 21, 2));

        $this::with(\range(1, 10))
            ->walk(static function ($item) {
                return $item;
            }, static function ($item) {
                return $item;
            })
            ->shouldIterateAs(\range(1, 10));
    }

    public function it_can_zip(): void
    {
        $this
            ->beConstructedThrough('with', [\range('A', 'C')]);

        $this
            ->zip(['D', 'E', 'F'])
            ->all()
            ->shouldIterateAs([['A', 'D'], ['B', 'E'], ['C', 'F']]);

        $this::with(['A', 'C', 'E'])
            ->zip(['B', 'D', 'F', 'H'])
            ->all()
            ->shouldIterateAs([['A', 'B'], ['C', 'D'], ['E', 'F'], [null, 'H']]);

        $collection = Collection::with(\range(1, 5));

        $this::with($collection)
            ->zip(\range('A', 'E'))
            ->all()
            ->shouldReturn([[1, 'A'], [2, 'B'], [3, 'C'], [4, 'D'], [5, 'E']]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Collection::class);
    }
}
