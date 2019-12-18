<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\Base as BaseInterface;
use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Operation\Append;
use drupol\collection\Operation\Apply;
use drupol\collection\Operation\Chunk;
use drupol\collection\Operation\Collapse;
use drupol\collection\Operation\Combine;
use drupol\collection\Operation\Cycle;
use drupol\collection\Operation\Distinct;
use drupol\collection\Operation\Explode;
use drupol\collection\Operation\Filter;
use drupol\collection\Operation\Flatten;
use drupol\collection\Operation\Flip;
use drupol\collection\Operation\Forget;
use drupol\collection\Operation\Intersperse;
use drupol\collection\Operation\Keys;
use drupol\collection\Operation\Limit;
use drupol\collection\Operation\Merge;
use drupol\collection\Operation\Normalize;
use drupol\collection\Operation\Nth;
use drupol\collection\Operation\Only;
use drupol\collection\Operation\Pad;
use drupol\collection\Operation\Pluck;
use drupol\collection\Operation\Prepend;
use drupol\collection\Operation\Range;
use drupol\collection\Operation\Reduction;
use drupol\collection\Operation\Scale;
use drupol\collection\Operation\Skip;
use drupol\collection\Operation\Slice;
use drupol\collection\Operation\Sort;
use drupol\collection\Operation\Split;
use drupol\collection\Operation\Until;
use drupol\collection\Operation\Walk;
use drupol\collection\Operation\Zip;
use drupol\collection\Transformation\All;
use drupol\collection\Transformation\Contains;
use drupol\collection\Transformation\Count;
use drupol\collection\Transformation\First;
use drupol\collection\Transformation\Get;
use drupol\collection\Transformation\Implode;
use drupol\collection\Transformation\Last;
use drupol\collection\Transformation\Reduce;

use const INF;
use const PHP_INT_MAX;

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
        return $this->transform(new All());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function append(...$items): BaseInterface
    {
        return $this->run(new Append($items));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function apply(callable ...$callables): BaseInterface
    {
        return $this->run(new Apply(...$callables));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function chunk(int $size): BaseInterface
    {
        return $this->run(new Chunk($size));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function collapse(): BaseInterface
    {
        return $this->run(new Collapse());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function combine($keys): BaseInterface
    {
        return $this->run(new Combine($keys));
    }

    /**
     * {@inheritdoc}
     */
    public function contains($key): bool
    {
        return $this->transform(new Contains($key));
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->transform(new Count());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function cycle(int $count = 0): BaseInterface
    {
        return $this->run(new Cycle($count));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function distinct(): BaseInterface
    {
        return $this->run(new Distinct());
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
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function explode(string ...$strings): BaseInterface
    {
        return $this->run(new Explode(...$strings));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function filter(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Filter(...$callbacks));
    }

    /**
     * {@inheritdoc}
     */
    public function first(?callable $callback = null, $default = null)
    {
        return $this->transform(new First($callback, $default));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function flatten(int $depth = PHP_INT_MAX): BaseInterface
    {
        return $this->run(new Flatten($depth));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function flip(): BaseInterface
    {
        return $this->run(new Flip());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function forget(...$keys): BaseInterface
    {
        return $this->run(new Forget($keys));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $this->transform(new Get($key, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function implode(string $glue = ''): string
    {
        return $this->transform(new Implode($glue));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): BaseInterface
    {
        return $this->run(new Intersperse($element, $every, $startAt));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function iterate(callable $callback, ...$parameters): CollectionInterface
    {
        return new Collection(
            static function () use ($parameters, $callback) {
                while (true) {
                    $parameters = $callback(...$parameters);

                    yield $parameters;

                    $parameters = (array) $parameters;
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function keys(): BaseInterface
    {
        return $this->run(new Keys());
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        return $this->transform(new Last());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function limit(int $limit): BaseInterface
    {
        return $this->run(new Limit($limit));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function map(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks), new Normalize());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function merge(...$sources): BaseInterface
    {
        return $this->run(new Merge($sources));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function normalize(): BaseInterface
    {
        return $this->run(new Normalize());
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function nth(int $step, int $offset = 0): BaseInterface
    {
        return $this->run(new Nth($step, $offset));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function only(...$keys): BaseInterface
    {
        return $this->run(new Only($keys));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function pad(int $size, $value): BaseInterface
    {
        return $this->run(new Pad($size, $value));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function pluck($pluck, $default = null): BaseInterface
    {
        return $this->run(new Pluck($pluck, $default));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function prepend(...$items): BaseInterface
    {
        return $this->run(new Prepend($items));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function range(int $start = 0, $end = INF, $step = 1): CollectionInterface
    {
        return (new Collection())->run(new Range($start, $end, $step));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function rebase(): BaseInterface
    {
        return new Collection($this->transform(new All()));
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        return $this->transform(new Reduce($callback, $initial));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function reduction(callable $callback, $initial = null): BaseInterface
    {
        return $this->run(new Reduction($callback, $initial));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function rsample($probability): BaseInterface
    {
        $callback = static function ($item) use ($probability) {
            return (mt_rand() / mt_getrandmax()) < $probability;
        };

        return $this->run(new Filter($callback));
    }

    /**
     * {@inheritdoc}
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ): BaseInterface {
        return $this->run(new Scale($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function skip(int ...$counts): BaseInterface
    {
        return $this->run(new Skip(...$counts));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function slice(int $offset, ?int $length = null): BaseInterface
    {
        return $this->run(new Slice($offset, $length));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function sort(callable $callback): BaseInterface
    {
        return $this->run(new Sort($callback));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function split(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Split(...$callbacks));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function times($number, ?callable $callback = null): CollectionInterface
    {
        if (1 > $number) {
            return self::empty();
        }

        $instance = new Collection(
            static function () use ($number) {
                for ($current = 1; $current <= $number; ++$current) {
                    yield $current;
                }
            }
        );

        return null === $callback ? $instance : $instance->run(new Walk($callback));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function until(callable $callback): BaseInterface
    {
        return $this->run(new Until($callback));
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function walk(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks));
    }

    /**
     * @param array $data
     * @param mixed ...$parameters
     *
     * @return \drupol\collection\Contract\Base
     */
    public static function with($data = [], ...$parameters): BaseInterface
    {
        return new Collection($data, ...$parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @return \drupol\collection\Contract\Collection
     */
    public function zip(...$items): BaseInterface
    {
        return $this->run(new Zip($items));
    }
}
