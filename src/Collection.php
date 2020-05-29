<?php

declare(strict_types=1);

namespace loophp\collection;

use loophp\collection\Contract\Base as BaseInterface;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\Append;
use loophp\collection\Operation\Apply;
use loophp\collection\Operation\Chunk;
use loophp\collection\Operation\Collapse;
use loophp\collection\Operation\Combinate;
use loophp\collection\Operation\Combine;
use loophp\collection\Operation\Cycle;
use loophp\collection\Operation\Distinct;
use loophp\collection\Operation\Explode;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\Flatten;
use loophp\collection\Operation\Flip;
use loophp\collection\Operation\Forget;
use loophp\collection\Operation\Intersperse;
use loophp\collection\Operation\Iterate;
use loophp\collection\Operation\Keys;
use loophp\collection\Operation\Limit;
use loophp\collection\Operation\Loop;
use loophp\collection\Operation\Merge;
use loophp\collection\Operation\Normalize;
use loophp\collection\Operation\Nth;
use loophp\collection\Operation\Only;
use loophp\collection\Operation\Pad;
use loophp\collection\Operation\Permutate;
use loophp\collection\Operation\Pluck;
use loophp\collection\Operation\Prepend;
use loophp\collection\Operation\Product;
use loophp\collection\Operation\Range;
use loophp\collection\Operation\Reduction;
use loophp\collection\Operation\Reverse;
use loophp\collection\Operation\RSample;
use loophp\collection\Operation\Scale;
use loophp\collection\Operation\Skip;
use loophp\collection\Operation\Slice;
use loophp\collection\Operation\Sort;
use loophp\collection\Operation\Split;
use loophp\collection\Operation\Tail;
use loophp\collection\Operation\Times;
use loophp\collection\Operation\Until;
use loophp\collection\Operation\Walk;
use loophp\collection\Operation\Zip;
use loophp\collection\Transformation\All;
use loophp\collection\Transformation\Contains;
use loophp\collection\Transformation\Count;
use loophp\collection\Transformation\First;
use loophp\collection\Transformation\FoldLeft;
use loophp\collection\Transformation\FoldRight;
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
     */
    public function append(...$items): BaseInterface
    {
        return $this->run(new Append(...$items));
    }

    /**
     * {@inheritdoc}
     */
    public function apply(callable ...$callables): BaseInterface
    {
        return $this->run(new Apply(...$callables));
    }

    /**
     * {@inheritdoc}
     */
    public function chunk(int $size): BaseInterface
    {
        return $this->run(new Chunk($size));
    }

    /**
     * {@inheritdoc}
     */
    public function collapse(): BaseInterface
    {
        return $this->run(new Collapse());
    }

    /**
     * {@inheritdoc}
     */
    public function combinate(?int $length = null): BaseInterface
    {
        return $this->run(new Combinate($length));
    }

    /**
     * {@inheritdoc}
     */
    public function combine(...$keys): BaseInterface
    {
        return $this->run(new Combine(...$keys));
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
     */
    public function cycle(int $length = 0): BaseInterface
    {
        return $this->run(new Cycle($length));
    }

    /**
     * {@inheritdoc}
     */
    public function distinct(): BaseInterface
    {
        return $this->run(new Distinct());
    }

    /**
     * {@inheritdoc}
     */
    public static function empty(): CollectionInterface
    {
        return new self();
    }

    /**
     * {@inheritdoc}
     */
    public function explode(...$explodes): BaseInterface
    {
        return $this->run(new Explode(...$explodes));
    }

    /**
     * {@inheritdoc}
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
     */
    public function flatten(int $depth = PHP_INT_MAX): BaseInterface
    {
        return $this->run(new Flatten($depth));
    }

    /**
     * {@inheritdoc}
     */
    public function flip(): BaseInterface
    {
        return $this->run(new Flip());
    }

    /**
     * {@inheritdoc}
     */
    public function foldLeft(callable $callback, $initial = null)
    {
        return $this->transform(new FoldLeft($callback, $initial));
    }

    /**
     * {@inheritdoc}
     */
    public function foldRight(callable $callback, $initial = null)
    {
        return $this->transform(new FoldRight($callback, $initial));
    }

    /**
     * {@inheritdoc}
     */
    public function forget(...$keys): BaseInterface
    {
        return $this->run(new Forget(...$keys));
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
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): BaseInterface
    {
        return $this->run(new Intersperse($element, $every, $startAt));
    }

    /**
     * {@inheritdoc}
     */
    public static function iterate(callable $callback, ...$parameters): CollectionInterface
    {
        return (new self())->run(new Iterate($callback, $parameters));
    }

    /**
     * {@inheritdoc}
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
     */
    public function limit(int $limit): BaseInterface
    {
        return $this->run(new Limit($limit));
    }

    /**
     * {@inheritdoc}
     */
    public function loop(): BaseInterface
    {
        return $this->run(new Loop());
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks), new Normalize());
    }

    /**
     * {@inheritdoc}
     */
    public function merge(iterable ...$sources): BaseInterface
    {
        return $this->run(new Merge(...$sources));
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(): BaseInterface
    {
        return $this->run(new Normalize());
    }

    /**
     * {@inheritdoc}
     */
    public function nth(int $step, int $offset = 0): BaseInterface
    {
        return $this->run(new Nth($step, $offset));
    }

    /**
     * {@inheritdoc}
     */
    public function only(...$keys): BaseInterface
    {
        return $this->run(new Only(...$keys));
    }

    /**
     * {@inheritdoc}
     */
    public function pad(int $size, $value): BaseInterface
    {
        return $this->run(new Pad($size, $value));
    }

    /**
     * {@inheritdoc}
     */
    public function permutate(): BaseInterface
    {
        return $this->run(new Permutate());
    }

    /**
     * {@inheritdoc}
     */
    public function pluck($pluck, $default = null): BaseInterface
    {
        return $this->run(new Pluck($pluck, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(...$items): BaseInterface
    {
        return $this->run(new Prepend($items));
    }

    /**
     * {@inheritdoc}
     */
    public function product(iterable ...$iterables): BaseInterface
    {
        return $this->run(new Product(...$iterables));
    }

    /**
     * {@inheritdoc}
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return (new self())->run(new Range($start, $end, $step));
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
     */
    public function reduction(callable $callback, $initial = null): BaseInterface
    {
        return $this->run(new Reduction($callback, $initial));
    }

    /**
     * {@inheritdoc}
     */
    public function reverse(): BaseInterface
    {
        return $this->run(new Reverse());
    }

    /**
     * {@inheritdoc}
     */
    public function rsample($probability): BaseInterface
    {
        return $this->run(new RSample($probability));
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
     */
    public function skip(int ...$counts): BaseInterface
    {
        return $this->run(new Skip(...$counts));
    }

    /**
     * {@inheritdoc}
     */
    public function slice(int $offset, ?int $length = null): BaseInterface
    {
        return $this->run(new Slice($offset, $length));
    }

    /**
     * {@inheritdoc}
     */
    public function sort(?callable $callback = null): BaseInterface
    {
        return $this->run(new Sort($callback));
    }

    /**
     * {@inheritdoc}
     */
    public function split(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Split(...$callbacks));
    }

    /**
     * {@inheritdoc}
     */
    public function tail(int $length = 1): BaseInterface
    {
        return $this->run(new Tail($length));
    }

    /**
     * {@inheritdoc}
     */
    public static function times($number = INF, ?callable $callback = null): CollectionInterface
    {
        return (new self())->run(new Times($number, $callback));
    }

    /**
     * {@inheritdoc}
     */
    public function until(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Until(...$callbacks));
    }

    /**
     * {@inheritdoc}
     */
    public function walk(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks));
    }

    /**
     * {@inheritdoc}
     */
    public static function with($data = [], ...$parameters): CollectionInterface
    {
        return new self($data, ...$parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function zip(iterable ...$iterables): BaseInterface
    {
        return $this->run(new Zip(...$iterables));
    }
}
