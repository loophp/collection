<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\ClosureIterator;
use drupol\collection\Operation\All;
use drupol\collection\Operation\Append;
use drupol\collection\Operation\Apply;
use drupol\collection\Operation\Chunk;
use drupol\collection\Operation\Collapse;
use drupol\collection\Operation\Combine;
use drupol\collection\Operation\Contains;
use drupol\collection\Operation\Count;
use drupol\collection\Operation\Filter;
use drupol\collection\Operation\First;
use drupol\collection\Operation\Flatten;
use drupol\collection\Operation\Flip;
use drupol\collection\Operation\Forget;
use drupol\collection\Operation\Get;
use drupol\collection\Operation\Implode;
use drupol\collection\Operation\Intersperse;
use drupol\collection\Operation\Keys;
use drupol\collection\Operation\Last;
use drupol\collection\Operation\Limit;
use drupol\collection\Operation\Merge;
use drupol\collection\Operation\Normalize;
use drupol\collection\Operation\Nth;
use drupol\collection\Operation\Only;
use drupol\collection\Operation\Pad;
use drupol\collection\Operation\Pluck;
use drupol\collection\Operation\Prepend;
use drupol\collection\Operation\Range;
use drupol\collection\Operation\Rebase;
use drupol\collection\Operation\Reduce;
use drupol\collection\Operation\Run;
use drupol\collection\Operation\Skip;
use drupol\collection\Operation\Slice;
use drupol\collection\Operation\Sort;
use drupol\collection\Operation\Walk;
use drupol\collection\Operation\Zip;

/**
 * Class Collection.
 */
class Collection implements CollectionInterface
{
    /**
     * @var \Closure
     */
    protected $source;

    /**
     * Collection constructor.
     *
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        switch (true) {
            case $data instanceof \Closure:
                $this->source = $data;

                break;
            case \is_iterable($data):
                $this->source = static function () use ($data) {
                    foreach ($data as $k => $v) {
                        yield $k => $v;
                    }
                };

                break;

            default:
                $this->source = static function () use ($data) {
                    foreach ((array) $data as $k => $v) {
                        yield $k => $v;
                    }
                };
        }
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->run(new All());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function append(...$items): CollectionInterface
    {
        return $this::with($this->run(new Append($items)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function apply(callable ...$callables): CollectionInterface
    {
        return $this::with($this->run(new Apply(...$callables)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function chunk(int $size): CollectionInterface
    {
        return $this::with($this->run(new Chunk($size)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function collapse(): CollectionInterface
    {
        return $this::with($this->run(new Collapse()));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function combine($keys): CollectionInterface
    {
        return $this::with($this->run(new Combine($keys)));
    }

    /**
     * {@inheritdoc}
     */
    public function contains($key): bool
    {
        return $this->run(new Contains($key));
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->run(new Count());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function empty(): CollectionInterface
    {
        return new static();
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function filter(callable ...$callbacks): CollectionInterface
    {
        return $this::with($this->run(new Filter(...$callbacks)));
    }

    /**
     * {@inheritdoc}
     */
    public function first(callable $callback = null, $default = null)
    {
        return $this->run(new First($callback, $default));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function flatten(int $depth = \PHP_INT_MAX): CollectionInterface
    {
        return $this::with($this->run(new Flatten($depth)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function flip(): CollectionInterface
    {
        return $this::with($this->run(new Flip()));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function forget(...$keys): CollectionInterface
    {
        return $this::with($this->run(new Forget($keys)));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $this->run(new Get($key, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): ClosureIterator
    {
        return new ClosureIterator($this->source);
    }

    /**
     * {@inheritdoc}
     */
    public function implode(string $implode = ''): string
    {
        return (new Implode($implode))->on($this);
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return $this::with($this->run(new Intersperse($element, $every, $startAt)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function keys(): CollectionInterface
    {
        return $this::with($this->run(new Keys()));
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        return $this->run(new Last());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function limit(int $limit): CollectionInterface
    {
        return $this::with($this->run(new Limit($limit)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function map(callable ...$callbacks): CollectionInterface
    {
        return $this::with($this->run(new Walk(...$callbacks), new Normalize()));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function merge(...$sources): CollectionInterface
    {
        return $this::with($this->run(new Merge($sources)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function normalize(): CollectionInterface
    {
        return $this::with($this->run(new Normalize()));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return $this::with($this->run(new Nth($step, $offset)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function only(...$keys): CollectionInterface
    {
        return $this::with($this->run(new Only($keys)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function pad(int $size, $value): CollectionInterface
    {
        return $this::with($this->run(new Pad($size, $value)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function pluck($pluck, $default = null): CollectionInterface
    {
        return $this::with($this->run(new Pluck($pluck, $default)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function prepend(...$items): CollectionInterface
    {
        return $this::with($this->run(new Prepend($items)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function range(int $start = 0, $end = \INF, $step = 1): CollectionInterface
    {
        return self::with((new self())->run(new Range($start, $end, $step)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function rebase(): CollectionInterface
    {
        return $this::with($this->run(new Rebase()));
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        return $this->run(new Reduce($callback, $initial));
    }

    /**
     * {@inheritdoc}
     */
    public function run(Operation ...$operations)
    {
        return (new Run(...$operations))->on($this);
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function skip(int ...$counts): CollectionInterface
    {
        return $this::with($this->run(new Skip(...$counts)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function slice(int $offset, int $length = null): CollectionInterface
    {
        return $this::with($this->run(new Slice($offset, $length)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function sort(callable $callback): CollectionInterface
    {
        return $this::with($this->run(new Sort($callback)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function times($number, callable $callback = null): CollectionInterface
    {
        if (1 > $number) {
            return static::empty();
        }

        $instance = static::with(
            static function () use ($number) {
                for ($current = 1; $current <= $number; ++$current) {
                    yield $current;
                }
            }
        );

        return null === $callback ? $instance : static::with((new Run(new Walk($callback)))->on($instance));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function walk(callable ...$callbacks): CollectionInterface
    {
        return $this::with($this->run(new Walk(...$callbacks)));
    }

    /**
     * Create a new collection instance.
     *
     * @param mixed $data
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function with($data = []): CollectionInterface
    {
        return new static($data);
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function zip(...$items): CollectionInterface
    {
        return $this::with($this->run(new Zip($items)));
    }
}
