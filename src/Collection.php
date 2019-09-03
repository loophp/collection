<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\Base as BaseInterface;
use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Operation\All;
use drupol\collection\Operation\Append;
use drupol\collection\Operation\Apply;
use drupol\collection\Operation\Chunk;
use drupol\collection\Operation\Collapse;
use drupol\collection\Operation\Combine;
use drupol\collection\Operation\Contains;
use drupol\collection\Operation\Count;
use drupol\collection\Operation\Distinct;
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
use drupol\collection\Operation\Reduction;
use drupol\collection\Operation\Run;
use drupol\collection\Operation\Skip;
use drupol\collection\Operation\Slice;
use drupol\collection\Operation\Sort;
use drupol\collection\Operation\Walk;
use drupol\collection\Operation\Zip;

/**
 * Class Collection.
 */
final class Collection extends Base implements CollectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->run(new All());
    }

    /**
     * {@inheritdoc}
     */
    public function append(...$items): BaseInterface
    {
        return new Collection($this->run(new Append($items)));
    }

    /**
     * {@inheritdoc}
     */
    public function apply(callable ...$callables): BaseInterface
    {
        return new Collection($this->run(new Apply(...$callables)));
    }

    /**
     * {@inheritdoc}
     */
    public function chunk(int $size): BaseInterface
    {
        return new Collection($this->run(new Chunk($size)));
    }

    /**
     * {@inheritdoc}
     */
    public function collapse(): BaseInterface
    {
        return new Collection($this->run(new Collapse()));
    }

    /**
     * {@inheritdoc}
     */
    public function combine($keys): BaseInterface
    {
        return new Collection($this->run(new Combine($keys)));
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
    public function distinct(): BaseInterface
    {
        return new Collection($this->run(new Distinct()));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function empty(): CollectionInterface
    {
        return new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable ...$callbacks): BaseInterface
    {
        return new Collection($this->run(new Filter(...$callbacks)));
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
     */
    public function flatten(int $depth = \PHP_INT_MAX): BaseInterface
    {
        return new Collection($this->run(new Flatten($depth)));
    }

    /**
     * {@inheritdoc}
     */
    public function flip(): BaseInterface
    {
        return new Collection($this->run(new Flip()));
    }

    /**
     * {@inheritdoc}
     */
    public function forget(...$keys): BaseInterface
    {
        return new Collection($this->run(new Forget($keys)));
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
    public function implode(string $implode = ''): string
    {
        return (new Implode($implode))->on($this);
    }

    /**
     * {@inheritdoc}
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): BaseInterface
    {
        return new Collection($this->run(new Intersperse($element, $every, $startAt)));
    }

    /**
     * {@inheritdoc}
     */
    public static function iterate(callable $callback, ...$parameters): CollectionInterface
    {
        return new Collection(
            static function () use ($parameters, $callback) {
                while (true) {
                    yield $parameters;

                    $parameters = $callback($parameters);
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function keys(): BaseInterface
    {
        return new Collection($this->run(new Keys()));
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
     */
    public function limit(int $limit): BaseInterface
    {
        return new Collection($this->run(new Limit($limit)));
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable ...$callbacks): BaseInterface
    {
        return new Collection($this->run(new Walk(...$callbacks), new Normalize()));
    }

    /**
     * {@inheritdoc}
     */
    public function merge(...$sources): BaseInterface
    {
        return new Collection($this->run(new Merge($sources)));
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(): BaseInterface
    {
        return new Collection($this->run(new Normalize()));
    }

    /**
     * {@inheritdoc}
     */
    public function nth(int $step, int $offset = 0): BaseInterface
    {
        return new Collection($this->run(new Nth($step, $offset)));
    }

    /**
     * {@inheritdoc}
     */
    public function only(...$keys): BaseInterface
    {
        return new Collection($this->run(new Only($keys)));
    }

    /**
     * {@inheritdoc}
     */
    public function pad(int $size, $value): BaseInterface
    {
        return new Collection($this->run(new Pad($size, $value)));
    }

    /**
     * {@inheritdoc}
     */
    public function pluck($pluck, $default = null): BaseInterface
    {
        return new Collection($this->run(new Pluck($pluck, $default)));
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(...$items): BaseInterface
    {
        return new Collection($this->run(new Prepend($items)));
    }

    /**
     * {@inheritdoc}
     */
    public static function range(int $start = 0, $end = \INF, $step = 1): CollectionInterface
    {
        return new Collection((new Collection())->run(new Range($start, $end, $step)));
    }

    /**
     * {@inheritdoc}
     */
    public function rebase(): BaseInterface
    {
        return new Collection($this->run(new Rebase()));
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
    public function reduction(callable $callback, $initial = null): BaseInterface
    {
        return new Collection($this->run(new Reduction($callback, $initial)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function rsample($probability): BaseInterface
    {
        $callback = static function ($item) use ($probability) {
            return (\mt_rand() / \mt_getrandmax()) < $probability;
        };

        return new Collection($this->run(new Filter($callback)));
    }

    /**
     * {@inheritdoc}
     */
    public function skip(int ...$counts): BaseInterface
    {
        return new Collection($this->run(new Skip(...$counts)));
    }

    /**
     * {@inheritdoc}
     */
    public function slice(int $offset, int $length = null): BaseInterface
    {
        return new Collection($this->run(new Slice($offset, $length)));
    }

    /**
     * {@inheritdoc}
     */
    public function sort(callable $callback): BaseInterface
    {
        return new Collection($this->run(new Sort($callback)));
    }

    /**
     * {@inheritdoc}
     */
    public static function times($number, callable $callback = null): CollectionInterface
    {
        if (1 > $number) {
            return static::empty();
        }

        $instance = new Collection(
            static function () use ($number) {
                for ($current = 1; $current <= $number; ++$current) {
                    yield $current;
                }
            }
        );

        return null === $callback ? $instance : new Collection((new Run(new Walk($callback)))->on($instance));
    }

    /**
     * {@inheritdoc}
     */
    public function walk(callable ...$callbacks): BaseInterface
    {
        return new Collection($this->run(new Walk(...$callbacks)));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function with($data = []): BaseInterface
    {
        return new Collection($data);
    }

    /**
     * {@inheritdoc}
     */
    public function zip(...$items): BaseInterface
    {
        return new Collection($this->run(new Zip($items)));
    }
}
