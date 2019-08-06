<?php

declare(strict_types = 1);

namespace drupol\collection;

use ArrayIterator;
use Closure;
use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Contract\Operation;
use drupol\collection\Operation\Append;
use drupol\collection\Operation\Chunk;
use drupol\collection\Operation\Collapse;
use drupol\collection\Operation\Combine;
use drupol\collection\Operation\Filter;
use drupol\collection\Operation\Flatten;
use drupol\collection\Operation\Flip;
use drupol\collection\Operation\Forget;
use drupol\collection\Operation\Keys;
use drupol\collection\Operation\Limit;
use drupol\collection\Operation\Merge;
use drupol\collection\Operation\Normalize;
use drupol\collection\Operation\Nth;
use drupol\collection\Operation\Only;
use drupol\collection\Operation\Pad;
use drupol\collection\Operation\Prepend;
use drupol\collection\Operation\Range;
use drupol\collection\Operation\Skip;
use drupol\collection\Operation\Slice;
use drupol\collection\Operation\Walk;
use drupol\collection\Operation\Zip;
use Traversable;

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
        return iterator_to_array($this->getIterator());
    }

    /**
     * {@inheritdoc}
     */
    public function append(...$items): CollectionInterface
    {
        return $this->run(Append::with(...$items));
    }

    /**
     * {@inheritdoc}
     */
    public function apply(callable $callback): CollectionInterface
    {
        foreach ($this as $key => $item) {
            $return = $callback($item, $key);

            if (\is_bool($return) && false === $return) {
                break;
            }
        }

        return $this;
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
        return $this->run(Combine::with(...$keys));
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    /**
     * Create a new instance with no items.
     */
    public static function empty(): CollectionInterface
    {
        return static::withArray([]);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $callback = null): CollectionInterface
    {
        return $this->run(Filter::with($callback));
    }

    /**
     * {@inheritdoc}
     */
    public function first(callable $callback = null, $default = null)
    {
        /** @var \Iterator $iterator */
        $iterator = $this->getIterator();

        if (null === $callback) {
            if (!$iterator->valid()) {
                return $default;
            }

            return $iterator->current();
        }

        foreach ($iterator as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function flatten(int $depth = PHP_INT_MAX): CollectionInterface
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
        return $this->run(Forget::with(...$keys));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key = null, $default = null)
    {
        if (null === $key) {
            return;
        }

        foreach ($this->getIterator() as $outerKey => $outerValue) {
            if ($outerKey === $key) {
                return $outerValue;
            }
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->makeIterator($this->source);
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
    public function limit(int $limit): CollectionInterface
    {
        return $this->run(Limit::with($limit));
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Walk::with(...$callbacks), Normalize::with());
    }

    /**
     * {@inheritdoc}
     */
    public function merge(...$sources): CollectionInterface
    {
        return $this->run(Merge::with(...array_map([$this, 'makeIterator'], $sources)));
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
        return $this->run(Only::with(...$keys));
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
    public function prepend(...$items): CollectionInterface
    {
        return $this->run(Prepend::with(...$items));
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
    public static function range(int $start = 0, $end = INF, $step = 1): CollectionInterface
    {
        return (new static())->run(Range::with($start, $end, $step));
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        $result = $initial;

        foreach ($this as $value) {
            $result = $callback($result, $value);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function run(Operation ...$operations): CollectionInterface
    {
        return array_reduce($operations, [$this, 'doRun'], $this);
    }

    /**
     * {@inheritdoc}
     */
    public function skip(int ...$counts): CollectionInterface
    {
        return $this->run(Skip::with(...$counts));
    }

    /**
     * {@inheritdoc}
     */
    public function slice(int $offset, int $length = null): CollectionInterface
    {
        return $this->run(Slice::with($offset, $length));
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
        return $this->run(Walk::with(...$callbacks));
    }

    /**
     * Create a new collection instance.
     *
     * @param null|array|callable|Closure|CollectionInterface $data
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function with($data = []): CollectionInterface
    {
        if ($data instanceof Closure || \is_callable($data)) {
            return self::withClosure($data);
        }

        return self::withArray(self::getArrayableItems($data));
    }

    /**
     * @param array $array
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function withArray(array $array): CollectionInterface
    {
        $instance = new static();

        $instance->source = static function () use ($array) {
            yield from $array;
        };

        return $instance;
    }

    /**
     * Create a new collection instance.
     *
     * @param callable $callback
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function withClosure(callable $callback): CollectionInterface
    {
        $instance = new static();

        $instance->source = $callback;

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function zip(...$items): CollectionInterface
    {
        return $this->run(Zip::with(...$items));
    }

    /**
     * Run an operation on the collection.
     *
     * @param \drupol\collection\Contract\Collection $collection
     *   The collection.
     * @param \drupol\collection\Contract\Operation $operation
     *   The operation.
     *
     * @return \drupol\collection\Contract\Collection
     *   A new collection.
     */
    private function doRun(CollectionInterface $collection, Operation $operation): CollectionInterface
    {
        return $operation->run($collection);
    }

    /**
     * Get items as an array.
     *
     * @param mixed $items
     *
     * @return array
     */
    private static function getArrayableItems($items): array
    {
        if (\is_array($items)) {
            return $items;
        }

        if ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }

    /**
     * Make an iterator from the given source.
     *
     * @param mixed $source
     *
     * @return \Iterator
     */
    private function makeIterator($source): \Iterator
    {
        if (\is_array($source)) {
            $source = new ArrayIterator($source);
        }

        if (\is_callable($source)) {
            $source = $source();
        }

        return $source;
    }
}
