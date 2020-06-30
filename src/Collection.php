<?php

declare(strict_types=1);

namespace loophp\collection;

use loophp\collection\Contract\Base as BaseInterface;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\Append;
use loophp\collection\Operation\Apply;
use loophp\collection\Operation\Chunk;
use loophp\collection\Operation\Collapse;
use loophp\collection\Operation\Column;
use loophp\collection\Operation\Combinate;
use loophp\collection\Operation\Combine;
use loophp\collection\Operation\Cycle;
use loophp\collection\Operation\Distinct;
use loophp\collection\Operation\Explode;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\Flatten;
use loophp\collection\Operation\Flip;
use loophp\collection\Operation\Forget;
use loophp\collection\Operation\Frequency;
use loophp\collection\Operation\Group;
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
use loophp\collection\Operation\Shuffle;
use loophp\collection\Operation\Since;
use loophp\collection\Operation\Skip;
use loophp\collection\Operation\Slice;
use loophp\collection\Operation\Sort;
use loophp\collection\Operation\Split;
use loophp\collection\Operation\Tail;
use loophp\collection\Operation\Times;
use loophp\collection\Operation\Transpose;
use loophp\collection\Operation\Until;
use loophp\collection\Operation\Walk;
use loophp\collection\Operation\Window;
use loophp\collection\Operation\Zip;
use loophp\collection\Transformation\All;
use loophp\collection\Transformation\Contains;
use loophp\collection\Transformation\Count;
use loophp\collection\Transformation\Falsy;
use loophp\collection\Transformation\First;
use loophp\collection\Transformation\FoldLeft;
use loophp\collection\Transformation\FoldRight;
use loophp\collection\Transformation\Get;
use loophp\collection\Transformation\Implode;
use loophp\collection\Transformation\Last;
use loophp\collection\Transformation\Nullsy;
use loophp\collection\Transformation\Reduce;
use loophp\collection\Transformation\Truthy;

use const INF;
use const PHP_INT_MAX;

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

    public function apply(callable ...$callables): BaseInterface
    {
        return $this->run(new Apply(...$callables));
    }

    public function chunk(int ...$size): BaseInterface
    {
        return $this->run(new Chunk(...$size));
    }

    public function collapse(): BaseInterface
    {
        return $this->run(new Collapse());
    }

    /**
     * {@inheritdoc}
     */
    public function column($column): BaseInterface
    {
        return $this->run(new Column($column));
    }

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

    public function count(): int
    {
        return $this->transform(new Count());
    }

    public function cycle(int $length = 0): BaseInterface
    {
        return $this->run(new Cycle($length));
    }

    public function distinct(): BaseInterface
    {
        return $this->run(new Distinct());
    }

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

    public function falsy(): bool
    {
        return $this->transform(new Falsy());
    }

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

    public function flatten(int $depth = PHP_INT_MAX): BaseInterface
    {
        return $this->run(new Flatten($depth));
    }

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

    public function forget(...$keys): BaseInterface
    {
        return $this->run(new Forget(...$keys));
    }

    public function frequency(): BaseInterface
    {
        return $this->run(new Frequency());
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $this->transform(new Get($key, $default));
    }

    public function group(?callable $callable = null): BaseInterface
    {
        return $this->run(new Group($callable));
    }

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
    public static function iterate(callable $callback, ...$parameters): BaseInterface
    {
        return (new self())->run(new Iterate($callback, $parameters));
    }

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

    public function limit(int $limit): BaseInterface
    {
        return $this->run(new Limit($limit));
    }

    public function loop(): BaseInterface
    {
        return $this->run(new Loop());
    }

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

    public function normalize(): BaseInterface
    {
        return $this->run(new Normalize());
    }

    public function nth(int $step, int $offset = 0): BaseInterface
    {
        return $this->run(new Nth($step, $offset));
    }

    public function nullsy(): bool
    {
        return $this->transform(new Nullsy());
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
        return $this->run(new Prepend(...$items));
    }

    /**
     * {@inheritdoc}
     */
    public function product(iterable ...$iterables): BaseInterface
    {
        return $this->run(new Product(...$iterables));
    }

    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): BaseInterface
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

    public function reverse(): BaseInterface
    {
        return $this->run(new Reverse());
    }

    public function rsample(float $probability): BaseInterface
    {
        return $this->run(new RSample($probability));
    }

    public function scale(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ): BaseInterface {
        return $this->run(new Scale($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base));
    }

    public function shuffle(): BaseInterface
    {
        return $this->run(new Shuffle());
    }

    public function since(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Since(...$callbacks));
    }

    public function skip(int ...$counts): BaseInterface
    {
        return $this->run(new Skip(...$counts));
    }

    public function slice(int $offset, ?int $length = null): BaseInterface
    {
        return $this->run(new Slice($offset, $length));
    }

    public function sort(?callable $callback = null): BaseInterface
    {
        return $this->run(new Sort($callback));
    }

    public function split(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Split(...$callbacks));
    }

    public function tail(int $length = 1): BaseInterface
    {
        return $this->run(new Tail($length));
    }

    /**
     * {@inheritdoc}
     */
    public static function times(int $number = 0, ?callable $callback = null): BaseInterface
    {
        return (new self())->run(new Times($number, $callback));
    }

    public function transpose(): BaseInterface
    {
        return $this->run(new Transpose());
    }

    public function truthy(): bool
    {
        return $this->transform(new Truthy());
    }

    public function until(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Until(...$callbacks));
    }

    public function walk(callable ...$callbacks): BaseInterface
    {
        return $this->run(new Walk(...$callbacks));
    }

    public function window(int ...$length): BaseInterface
    {
        return $this->run(new Window(...$length));
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
