<?php

declare(strict_types=1);

namespace drupol\collection;

use ArrayIterator;
use Closure;
use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Contract\Manipulator;
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
use drupol\collection\Operation\Proxy;
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
final class Collection implements CollectionInterface
{
    /**
     * @var null|callable|Closure|\drupol\collection\Contract\Collection
     */
    private $source;

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->run(All::with([]));
    }

    /**
     * {@inheritdoc}
     */
    public function append(...$items): \Traversable
    {
        return $this->run(Append::with($items));
    }

    /**
     * {@inheritdoc}
     */
    public function apply(callable ...$callables): \Traversable
    {
        return $this->run(Apply::with($callables));
    }

    /**
     * {@inheritdoc}
     */
    public function chunk(int $size): CollectionInterface
    {
        return $this->run(Chunk::with($size));
    }

    /**
     * {@inheritdoc}
     */
    public function collapse(): CollectionInterface
    {
        return $this->run(Collapse::with());
    }

    /**
     * {@inheritdoc}
     */
    public function combine($keys): CollectionInterface
    {
        return $this->run(Combine::with($keys));
    }

    /**
     * {@inheritdoc}
     */
    public function contains($key): bool
    {
        return $this->run(Contains::with($key));
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->run(Count::with());
    }

    /**
     * Create a new instance with no items.
     */
    public static function empty(): CollectionInterface
    {
        return self::withArray([]);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Filter::with($callbacks));
    }

    /**
     * {@inheritdoc}
     */
    public function first(callable $callback = null, $default = null)
    {
        return $this->run(First::with($callback, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function flatten(int $depth = \PHP_INT_MAX): CollectionInterface
    {
        return $this->run(Flatten::with($depth));
    }

    /**
     * {@inheritdoc}
     */
    public function flip(): CollectionInterface
    {
        return $this->run(Flip::with());
    }

    /**
     * {@inheritdoc}
     */
    public function forget(...$keys): CollectionInterface
    {
        return $this->run(Forget::with($keys));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $this->run(Get::with($key, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        if ($this->source instanceof Closure) {
            return ($this->source)();
        }

        return new ArrayIterator((array) $this->source);
    }

    /**
     * {@inheritdoc}
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return $this->run(Intersperse::with($element, $every, $startAt));
    }

    /**
     * {@inheritdoc}
     */
    public function keys(): CollectionInterface
    {
        return $this->run(Keys::with());
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        return $this->run(Last::with());
    }

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): CollectionInterface
    {
        return $this->run(Limit::with($limit));
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Walk::with($callbacks), Normalize::with());
    }

    /**
     * {@inheritdoc}
     */
    public function merge(...$sources): CollectionInterface
    {
        return $this->run(Merge::with($sources));
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(): CollectionInterface
    {
        return $this->run(Normalize::with());
    }

    /**
     * {@inheritdoc}
     */
    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return $this->run(Nth::with($step, $offset));
    }

    /**
     * {@inheritdoc}
     */
    public function only(...$keys): CollectionInterface
    {
        return $this->run(Only::with($keys));
    }

    /**
     * {@inheritdoc}
     */
    public function pad(int $size, $value): CollectionInterface
    {
        return $this->run(Pad::with($size, $value));
    }

    /**
     * {@inheritdoc}
     */
    public function pluck($pluck, $default = null): CollectionInterface
    {
        return $this->run(Pluck::with($pluck, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(...$items): \Traversable
    {
        return $this->run(Prepend::with($items));
    }

    /**
     * {@inheritdoc}
     */
    public function proxy(string $method, string $proxyMethod, ...$parameters): CollectionInterface
    {
        return $this->run(Proxy::with($method, $proxyMethod, $parameters));
    }

    /**
     * Create a new with a range of number.
     *
     * @param int $start
     * @param float|int $end
     * @param int $step
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function range(int $start = 0, $end = \INF, $step = 1): CollectionInterface
    {
        return self::empty()->run(Range::with($start, $end, $step));
    }

    /**
     * {@inheritdoc}
     */
    public function rebase(): CollectionInterface
    {
        return $this->run(Rebase::with());
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        return $this->run(Reduce::with($callback, $initial));
    }

    /**
     * {@inheritdoc}
     */
    public function run(Manipulator ...$operations)
    {
        return Run::with($operations)->run($this);
    }

    /**
     * {@inheritdoc}
     */
    public function skip(int ...$counts): CollectionInterface
    {
        return $this->run(Skip::with($counts));
    }

    /**
     * {@inheritdoc}
     */
    public function slice(int $offset, int $length = null): CollectionInterface
    {
        return $this->run(Slice::with($offset, $length));
    }

    /**
     * {@inheritdoc}
     */
    public function sort(callable $callback): CollectionInterface
    {
        return $this->run(Sort::with($callback));
    }

    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @param  int  $number
     * @param  callable  $callback
     *
     * @return CollectionInterface
     */
    public static function times($number, callable $callback = null): CollectionInterface
    {
        if (1 > $number) {
            return self::empty();
        }

        $instance = self::withClosure(
            static function () use ($number) {
                for ($current = 1; $current <= $number; ++$current) {
                    yield $current;
                }
            }
        );

        return null === $callback ? $instance : $instance->map($callback);
    }

    /**
     * {@inheritdoc}
     */
    public function walk(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Walk::with($callbacks));
    }

    /**
     * Create a new collection instance.
     *
     * @param array|callable|Closure|CollectionInterface|\Iterator|\Traversable $data
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function with($data): CollectionInterface
    {
        if ($data instanceof Closure) {
            return self::withClosure($data);
        }

        if ($data instanceof \Traversable) {
            return self::withArray(
                \iterator_to_array(
                    (static function () use ($data) {
                        yield from $data;
                    })()
                )
            );
        }

        return self::withArray((array) $data);
    }

    /**
     * {@inheritdoc}
     */
    public function zip(...$items): CollectionInterface
    {
        return $this->run(Zip::with($items));
    }

    /**
     * @param array $data
     *
     * @return \drupol\collection\Contract\Collection
     */
    private static function withArray(array $data): CollectionInterface
    {
        return self::withClosure(
            static function () use ($data) {
                yield from $data;
            }
        );
    }

    /**
     * Create a new collection instance.
     *
     * @param callable $callable
     *
     * @return \drupol\collection\Contract\Collection
     */
    private static function withClosure(callable $callable): CollectionInterface
    {
        $instance = new static();

        $instance->source = $callable;

        return $instance;
    }
}
