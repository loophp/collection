<?php

declare(strict_types=1);

namespace loophp\collection;

use Generator;
use loophp\collection\Contract\Base as BaseInterface;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\Append;
use loophp\collection\Operation\Apply;
use loophp\collection\Operation\Chunk;
use loophp\collection\Operation\Collapse;
use loophp\collection\Operation\Combine;
use loophp\collection\Operation\Cycle;
use loophp\collection\Operation\Distinct;
use loophp\collection\Operation\Explode;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\Flatten;
use loophp\collection\Operation\Flip;
use loophp\collection\Operation\Forget;
use loophp\collection\Operation\Intersperse;
use loophp\collection\Operation\Keys;
use loophp\collection\Operation\Limit;
use loophp\collection\Operation\Merge;
use loophp\collection\Operation\Normalize;
use loophp\collection\Operation\Nth;
use loophp\collection\Operation\Only;
use loophp\collection\Operation\Pad;
use loophp\collection\Operation\Pluck;
use loophp\collection\Operation\Prepend;
use loophp\collection\Operation\Product;
use loophp\collection\Operation\Range;
use loophp\collection\Operation\Reduction;
use loophp\collection\Operation\Reverse;
use loophp\collection\Operation\Scale;
use loophp\collection\Operation\Skip;
use loophp\collection\Operation\Slice;
use loophp\collection\Operation\Sort;
use loophp\collection\Operation\Split;
use loophp\collection\Operation\Tail;
use loophp\collection\Operation\Until;
use loophp\collection\Operation\Walk;
use loophp\collection\Operation\Zip;
use loophp\collection\Transformation\All;
use loophp\collection\Transformation\Contains;
use loophp\collection\Transformation\Count;
use loophp\collection\Transformation\First;
use loophp\collection\Transformation\Get;
use loophp\collection\Transformation\Implode;
use loophp\collection\Transformation\Last;
use loophp\collection\Transformation\Reduce;

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
     * @return \loophp\collection\Contract\Collection
     */
    public function append(...$items): BaseInterface
    {
        return $this->run(new Append($items));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function apply(callable ...$callables): BaseInterface
    {
        return $this->run(new Apply(...$callables));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function chunk(int $size): BaseInterface
    {
        return $this->run(new Chunk($size));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function collapse(): BaseInterface
    {
        return $this->run(new Collapse());
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
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
     * @return \loophp\collection\Contract\Collection
     */
    public function cycle(int $length = 0): BaseInterface
    {
        return $this->run(new Cycle($length));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function distinct(): BaseInterface
    {
        return $this->run(new Distinct());
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public static function empty(): CollectionInterface
    {
        return new Collection();
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function explode(string ...$strings): BaseInterface
    {
        return $this->run(new Explode(...$strings));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
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
     * @return \loophp\collection\Contract\Collection
     */
    public function flatten(int $depth = PHP_INT_MAX): BaseInterface
    {
        return $this->run(new Flatten($depth));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function flip(): BaseInterface
    {
        return $this->run(new Flip());
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
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
     * @return \loophp\collection\Contract\Collection
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): BaseInterface
    {
        return $this->run(new Intersperse($element, $every, $startAt));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public static function iterate(callable $callback, ...$parameters): CollectionInterface
    {
        return new Collection(
            static function () use ($parameters, $callback): Generator {
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
     * @return \loophp\collection\Contract\Collection
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
     * @return \loophp\collection\Contract\Collection
     */
    public function limit(int $limit): BaseInterface
    {
        return $this->run(new Limit($limit));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function map(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks), new Normalize());
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function merge(...$sources): BaseInterface
    {
        return $this->run(new Merge($sources));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function normalize(): BaseInterface
    {
        return $this->run(new Normalize());
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function nth(int $step, int $offset = 0): BaseInterface
    {
        return $this->run(new Nth($step, $offset));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function only(...$keys): BaseInterface
    {
        return $this->run(new Only($keys));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function pad(int $size, $value): BaseInterface
    {
        return $this->run(new Pad($size, $value));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function pluck($pluck, $default = null): BaseInterface
    {
        return $this->run(new Pluck($pluck, $default));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function prepend(...$items): BaseInterface
    {
        return $this->run(new Prepend($items));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function product(iterable ...$iterables): BaseInterface
    {
        return $this->run(new Product(...$iterables));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public static function range(int $start = 0, $end = INF, $step = 1): CollectionInterface
    {
        return (new Collection())->run(new Range($start, $end, $step));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
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
     * @return \loophp\collection\Contract\Collection
     */
    public function reduction(callable $callback, $initial = null): BaseInterface
    {
        return $this->run(new Reduction($callback, $initial));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function reverse(): BaseInterface
    {
        return $this->run(new Reverse());
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function rsample($probability): BaseInterface
    {
        $callback = static function ($item) use ($probability): bool {
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
     * @return \loophp\collection\Contract\Collection
     */
    public function skip(int ...$counts): BaseInterface
    {
        return $this->run(new Skip(...$counts));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function slice(int $offset, ?int $length = null): BaseInterface
    {
        return $this->run(new Slice($offset, $length));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function sort(callable $callback): BaseInterface
    {
        return $this->run(new Sort($callback));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function split(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Split(...$callbacks));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function tail(int $length): BaseInterface
    {
        return $this->run(new Tail($length));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public static function times($number, ?callable $callback = null): CollectionInterface
    {
        if (1 > $number) {
            return self::empty();
        }

        $instance = new Collection(
            static function () use ($number): Generator {
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
     * @return \loophp\collection\Contract\Collection
     */
    public function until(callable $callback): BaseInterface
    {
        return $this->run(new Until($callback));
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function walk(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks));
    }

    /**
     * @param array<mixed> $data
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Contract\Base<mixed>
     */
    public static function with($data = [], ...$parameters): BaseInterface
    {
        return new Collection($data, ...$parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @return \loophp\collection\Contract\Collection
     */
    public function zip(...$items): BaseInterface
    {
        return $this->run(new Zip($items));
    }
}
