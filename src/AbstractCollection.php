<?php

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Doctrine\Common\Collections\Criteria;
use Iterator;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Contract\Operation;
use loophp\collection\Operation\All;
use loophp\collection\Operation\Append;
use loophp\collection\Operation\Apply;
use loophp\collection\Operation\Associate;
use loophp\collection\Operation\AsyncMap;
use loophp\collection\Operation\AsyncMapN;
use loophp\collection\Operation\Averages;
use loophp\collection\Operation\Cache;
use loophp\collection\Operation\Chunk;
use loophp\collection\Operation\Coalesce;
use loophp\collection\Operation\Collapse;
use loophp\collection\Operation\Column;
use loophp\collection\Operation\Combinate;
use loophp\collection\Operation\Combine;
use loophp\collection\Operation\Compact;
use loophp\collection\Operation\Compare;
use loophp\collection\Operation\Contains;
use loophp\collection\Operation\Current;
use loophp\collection\Operation\Cycle;
use loophp\collection\Operation\Diff;
use loophp\collection\Operation\DiffKeys;
use loophp\collection\Operation\Distinct;
use loophp\collection\Operation\Drop;
use loophp\collection\Operation\DropWhile;
use loophp\collection\Operation\Dump;
use loophp\collection\Operation\Duplicate;
use loophp\collection\Operation\Equals;
use loophp\collection\Operation\Every;
use loophp\collection\Operation\Explode;
use loophp\collection\Operation\Falsy;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\Find;
use loophp\collection\Operation\First;
use loophp\collection\Operation\FlatMap;
use loophp\collection\Operation\Flatten;
use loophp\collection\Operation\Flip;
use loophp\collection\Operation\FoldLeft;
use loophp\collection\Operation\FoldLeft1;
use loophp\collection\Operation\FoldRight;
use loophp\collection\Operation\FoldRight1;
use loophp\collection\Operation\Forget;
use loophp\collection\Operation\Frequency;
use loophp\collection\Operation\Get;
use loophp\collection\Operation\Group;
use loophp\collection\Operation\GroupBy;
use loophp\collection\Operation\Has;
use loophp\collection\Operation\Head;
use loophp\collection\Operation\IfThenElse;
use loophp\collection\Operation\Implode;
use loophp\collection\Operation\Init;
use loophp\collection\Operation\Inits;
use loophp\collection\Operation\Intersect;
use loophp\collection\Operation\IntersectKeys;
use loophp\collection\Operation\Intersperse;
use loophp\collection\Operation\IsEmpty;
use loophp\collection\Operation\Key;
use loophp\collection\Operation\Keys;
use loophp\collection\Operation\Last;
use loophp\collection\Operation\Limit;
use loophp\collection\Operation\Lines;
use loophp\collection\Operation\Map;
use loophp\collection\Operation\MapN;
use loophp\collection\Operation\Matching;
use loophp\collection\Operation\MatchOne;
use loophp\collection\Operation\Max;
use loophp\collection\Operation\Merge;
use loophp\collection\Operation\Min;
use loophp\collection\Operation\Normalize;
use loophp\collection\Operation\Nth;
use loophp\collection\Operation\Nullsy;
use loophp\collection\Operation\Pack;
use loophp\collection\Operation\Pad;
use loophp\collection\Operation\Pair;
use loophp\collection\Operation\Partition;
use loophp\collection\Operation\Permutate;
use loophp\collection\Operation\Pipe;
use loophp\collection\Operation\Pluck;
use loophp\collection\Operation\Prepend;
use loophp\collection\Operation\Product;
use loophp\collection\Operation\Random;
use loophp\collection\Operation\Reduce;
use loophp\collection\Operation\Reduction;
use loophp\collection\Operation\Reject;
use loophp\collection\Operation\Reverse;
use loophp\collection\Operation\RSample;
use loophp\collection\Operation\Same;
use loophp\collection\Operation\Scale;
use loophp\collection\Operation\ScanLeft;
use loophp\collection\Operation\ScanLeft1;
use loophp\collection\Operation\ScanRight;
use loophp\collection\Operation\ScanRight1;
use loophp\collection\Operation\Shuffle;
use loophp\collection\Operation\Since;
use loophp\collection\Operation\Slice;
use loophp\collection\Operation\Sort;
use loophp\collection\Operation\Span;
use loophp\collection\Operation\Split;
use loophp\collection\Operation\Strict;
use loophp\collection\Operation\Tail;
use loophp\collection\Operation\Tails;
use loophp\collection\Operation\TakeWhile;
use loophp\collection\Operation\Transpose;
use loophp\collection\Operation\Truthy;
use loophp\collection\Operation\Unlines;
use loophp\collection\Operation\Unpack;
use loophp\collection\Operation\Unpair;
use loophp\collection\Operation\Until;
use loophp\collection\Operation\Unwindow;
use loophp\collection\Operation\Unwords;
use loophp\collection\Operation\Unwrap;
use loophp\collection\Operation\Unzip;
use loophp\collection\Operation\When;
use loophp\collection\Operation\Window;
use loophp\collection\Operation\Words;
use loophp\collection\Operation\Wrap;
use loophp\collection\Operation\Zip;
use loophp\collection\Utils\CallbacksArrayReducer;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

use const PHP_INT_MAX;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 *
 * @implements \loophp\collection\Contract\Collection<TKey, T>
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * @psalm-return ($normalize is true ? list<T> : array<TKey, T>)
     */
    public function all(bool $normalize = true): array
    {
        return iterator_to_array((new All())()($normalize)($this));
    }

    /**
     * @template U
     *
     * @param U ...$items
     *
     * @return CollectionInterface<int|TKey, T|U>
     */
    public function append(...$items): CollectionInterface
    {
        return static::fromCallable((new Append())()(...$items), [$this]);
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     *
     * @return CollectionInterface<TKey, T>
     */
    public function apply(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Apply())()(...$callbacks), [$this]);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param callable(TKey=, T=, Iterator<TKey, T>=): UKey $callbackForKeys
     * @param callable(T=, TKey=, Iterator<TKey, T>=): U $callbackForValues
     *
     * @return CollectionInterface<UKey, U>
     */
    public function associate(
        ?callable $callbackForKeys = null,
        ?callable $callbackForValues = null
    ): CollectionInterface {
        $defaultCallback =
            /**
             * @param mixed $carry
             *
             * @return mixed
             */
            static fn ($carry) => $carry;

        return static::fromCallable((new Associate())()($callbackForKeys ?? $defaultCallback)($callbackForValues ?? $defaultCallback), [$this]);
    }

    /**
     * @template V
     *
     * @param callable(T, TKey): V $callback
     *
     * @return CollectionInterface<TKey, V>
     */
    public function asyncMap(callable $callback): CollectionInterface
    {
        return static::fromCallable((new AsyncMap())()($callback), [$this]);
    }

    /**
     * @param callable(mixed, mixed): mixed ...$callbacks
     *
     * @return CollectionInterface<mixed, mixed>
     */
    public function asyncMapN(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new AsyncMapN())()(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<int, float>
     */
    public function averages(): CollectionInterface
    {
        return static::fromCallable((new Averages())(), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function cache(?CacheItemPoolInterface $cache = null): CollectionInterface
    {
        return static::fromCallable((new Cache())()($cache ?? new ArrayAdapter()), [$this]);
    }

    /**
     * @return CollectionInterface<int, list<T>>
     */
    public function chunk(int ...$sizes): CollectionInterface
    {
        return static::fromCallable((new Chunk())()(...$sizes), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function coalesce(): CollectionInterface
    {
        return static::fromCallable((new Coalesce())(), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function collapse(): CollectionInterface
    {
        return static::fromCallable((new Collapse())(), [$this]);
    }

    /**
     * @param mixed $column
     *
     * @return CollectionInterface<int, mixed>
     */
    public function column($column): CollectionInterface
    {
        return static::fromCallable((new Column())()($column), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function combinate(?int $length = null): CollectionInterface
    {
        return static::fromCallable((new Combinate())()($length), [$this]);
    }

    /**
     * @template U
     *
     * @param U ...$keys
     *
     * @return CollectionInterface<U|null, T|null>
     */
    public function combine(...$keys): CollectionInterface
    {
        return static::fromCallable((new Combine())()(...$keys), [$this]);
    }

    /**
     * @param T ...$values
     *
     * @return CollectionInterface<TKey, T>
     */
    public function compact(...$values): CollectionInterface
    {
        return static::fromCallable((new Compact())()(...$values), [$this]);
    }

    /**
     * @template V
     *
     * @param callable(T, T): T $comparator
     * @param V $default
     *
     * @return T|V
     */
    public function compare(callable $comparator, $default = null)
    {
        return static::fromCallable((new Compare())()($comparator), [$this])->current(0, $default);
    }

    /**
     * @param T ...$values
     */
    public function contains(...$values): bool
    {
        return (new Contains())()(...$values)($this)->current();
    }

    public function count(): int
    {
        return iterator_count($this);
    }

    /**
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function current(int $index = 0, $default = null)
    {
        return (new Current())()($index)($default)($this)->current();
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function cycle(): CollectionInterface
    {
        return static::fromCallable((new Cycle())(), [$this]);
    }

    /**
     * @template U
     *
     * @param U ...$values
     *
     * @return CollectionInterface<TKey, T>
     */
    public function diff(...$values): CollectionInterface
    {
        return static::fromCallable((new Diff())()(...$values), [$this]);
    }

    /**
     * @param TKey ...$keys
     *
     * @return CollectionInterface<TKey, T>
     */
    public function diffKeys(...$keys): CollectionInterface
    {
        return static::fromCallable((new DiffKeys())()(...$keys), [$this]);
    }

    /**
     * @template U
     *
     * @param null|callable(U): (Closure(U): bool) $comparatorCallback
     * @param null|callable(T, TKey): U $accessorCallback
     *
     * @return CollectionInterface<TKey, T>
     */
    public function distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): CollectionInterface
    {
        $accessorCallback ??=
            /**
             * @param T $value
             * @param TKey $key
             *
             * @return T
             */
            static fn ($value, $key) => $value;

        $comparatorCallback ??=
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn ($left): Closure =>
                /**
                 * @param T $right
                 */
                static fn ($right): bool => $left === $right;

        return static::fromCallable((new Distinct())()($comparatorCallback)($accessorCallback), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function drop(int $count): CollectionInterface
    {
        return static::fromCallable((new Drop())()($count), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function dropWhile(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new DropWhile())()(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): CollectionInterface
    {
        return static::fromCallable((new Dump())()($name)($size)($closure), [$this]);
    }

    /**
     * @template U
     *
     * @param null|callable(U): (Closure(U): bool) $comparatorCallback
     * @param null|callable(T, TKey): U $accessorCallback
     *
     * @return CollectionInterface<TKey, T>
     */
    public function duplicate(?callable $comparatorCallback = null, ?callable $accessorCallback = null): CollectionInterface
    {
        $accessorCallback ??=
            /**
             * @param T $value
             * @param TKey $key
             *
             * @return T
             */
            static fn ($value, $key) => $value;

        $comparatorCallback ??=
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn ($left): Closure =>
                /**
                 * @param T $right
                 */
                static fn ($right): bool => $left === $right;

        return static::fromCallable((new Duplicate())()($comparatorCallback)($accessorCallback), [$this]);
    }

    /**
     * @param iterable<mixed, mixed> $other
     */
    public function equals(iterable $other): bool
    {
        return (new Equals())()($other)($this)->current();
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     */
    public function every(callable ...$callbacks): bool
    {
        return (new Every())()(static fn (int $index, $value, $key, iterable $iterable) => CallbacksArrayReducer::or()($callbacks)($value, $key, $iterable))($this)
            ->current();
    }

    /**
     * @param mixed ...$explodes
     *
     * @return CollectionInterface<int, list<T>>
     */
    public function explode(...$explodes): CollectionInterface
    {
        return static::fromCallable((new Explode())()(...$explodes), [$this]);
    }

    public function falsy(): bool
    {
        return (new Falsy())()($this)->current();
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     *
     * @return CollectionInterface<TKey, T>
     */
    public function filter(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Filter())()(...$callbacks), [$this]);
    }

    /**
     * @template V
     *
     * @param V $default
     * @param (callable(T=, TKey=, iterable<TKey, T>=): bool) ...$callbacks
     *
     * @return T|V
     */
    public function find($default = null, callable ...$callbacks)
    {
        return (new Find())()($default)(...$callbacks)($this)->current();
    }

    /**
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function first($default = null)
    {
        return static::fromCallable((new First())(), [$this])->current(0, $default);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param callable(T=, TKey=, iterable<TKey, T>=): iterable<UKey, U> $callback
     *
     * @return CollectionInterface<UKey, U>
     */
    public function flatMap(callable $callback): CollectionInterface
    {
        return static::fromCallable((new FlatMap())()($callback), [$this]);
    }

    /**
     * @return CollectionInterface<mixed, mixed>
     */
    public function flatten(int $depth = PHP_INT_MAX): CollectionInterface
    {
        return static::fromCallable((new Flatten())()($depth), [$this]);
    }

    /**
     * @return CollectionInterface<T, TKey>
     */
    public function flip(): CollectionInterface
    {
        return static::fromCallable((new Flip())(), [$this]);
    }

    /**
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return V|W
     */
    public function foldLeft(callable $callback, $initial)
    {
        return static::fromCallable((new FoldLeft())()($callback)($initial), [$this])->current();
    }

    /**
     * @template V
     *
     * @param callable(T, T, TKey, Iterator<TKey, T>): T $callback
     *
     * @return T|null
     */
    public function foldLeft1(callable $callback)
    {
        return static::fromCallable((new FoldLeft1())()($callback), [$this])->current();
    }

    /**
     * @template U
     * @template V
     *
     * @param callable(U|V, T, TKey, iterable<TKey, T>): V $callback
     * @param U|null $initial
     *
     * @return V|null
     */
    public function foldRight(callable $callback, $initial = null)
    {
        return static::fromCallable((new Foldright())()($callback)($initial), [$this])->current();
    }

    /**
     * @template V
     *
     * @param callable(T, T, TKey, Iterator<TKey, T>): V $callback
     *
     * @return V|null
     */
    public function foldRight1(callable $callback)
    {
        return static::fromCallable((new FoldRight1())()($callback), [$this])->current();
    }

    /**
     * @param mixed ...$keys
     *
     * @return CollectionInterface<TKey, T>
     */
    public function forget(...$keys): CollectionInterface
    {
        return static::fromCallable((new Forget())()(...$keys), [$this]);
    }

    /**
     * @return CollectionInterface<int, T>
     */
    public function frequency(): CollectionInterface
    {
        return static::fromCallable((new Frequency())(), [$this]);
    }

    /**
     * @template V
     *
     * @param TKey $key
     * @param V $default
     *
     * @return T|V
     */
    public function get($key, $default = null)
    {
        return static::fromCallable((new Get())()($key)($default), [$this])->current(0, $default);
    }

    /**
     * @return CollectionInterface<int, list<T>>
     */
    public function group(): CollectionInterface
    {
        return static::fromCallable((new Group())(), [$this]);
    }

    /**
     * @template UKey
     *
     * @param callable(T=, TKey=): UKey $callable
     *
     * @return CollectionInterface<UKey, non-empty-list<T>>
     */
    public function groupBy(callable $callable): CollectionInterface
    {
        return static::fromCallable((new GroupBy())()($callable), [$this]);
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): T ...$callbacks
     */
    public function has(callable ...$callbacks): bool
    {
        return (new Has())()(...$callbacks)($this)->current();
    }

    /**
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function head($default = null)
    {
        return static::fromCallable((new Head())(), [$this])->current(0, $default);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): CollectionInterface
    {
        $identity =
            /**
             * @param T $value
             *
             * @return T
             */
            static fn ($value) => $value;

        return static::fromCallable((new IfThenElse())()($condition)($then)($else ?? $identity), [$this]);
    }

    public function implode(string $glue = ''): string
    {
        return static::fromCallable((new Implode())()($glue), [$this])->current(0, '');
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function init(): CollectionInterface
    {
        return static::fromCallable((new Init())(), [$this]);
    }

    /**
     * @return CollectionInterface<int, list<array{0: TKey, 1: T}>>
     */
    public function inits(): CollectionInterface
    {
        return static::fromCallable((new Inits())(), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function intersect(...$values): CollectionInterface
    {
        return static::fromCallable((new Intersect())()(...$values), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function intersectKeys(...$keys): CollectionInterface
    {
        return static::fromCallable((new IntersectKeys())()(...$keys), [$this]);
    }

    /**
     * @template U
     *
     * @param U $element
     *
     * @return CollectionInterface<TKey, T|U>
     */
    public function intersperse($element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return static::fromCallable((new Intersperse())()($element)($every)($startAt), [$this]);
    }

    public function isEmpty(): bool
    {
        return (new IsEmpty())()($this)->current();
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->all(false);
    }

    /**
     * @return TKey|null
     */
    public function key(int $index = 0)
    {
        return (new Key())()($index)($this)->current();
    }

    /**
     * @return CollectionInterface<int, TKey>
     */
    public function keys(): CollectionInterface
    {
        return static::fromCallable((new Keys())(), [$this]);
    }

    /**
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function last($default = null)
    {
        return static::fromCallable((new Last())(), [$this])->current(0, $default);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function limit(int $count = -1, int $offset = 0): CollectionInterface
    {
        return static::fromCallable((new Limit())()($count)($offset), [$this]);
    }

    /**
     * @return CollectionInterface<int, string>
     */
    public function lines(): CollectionInterface
    {
        return static::fromCallable((new Lines())(), [$this]);
    }

    /**
     * @template U
     *
     * @param callable(T=, TKey=, Iterator<TKey, T>=): U $callback
     *
     * @return CollectionInterface<TKey, U>
     */
    public function map(callable $callback): CollectionInterface
    {
        return static::fromCallable((new Map())()($callback), [$this]);
    }

    /**
     * @param callable(mixed, mixed, iterable<TKey, T>): mixed ...$callbacks
     *
     * @return CollectionInterface<mixed, mixed>
     */
    public function mapN(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new MapN())()(...$callbacks), [$this]);
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool $callback
     * @param null|callable(T=, TKey=, iterable<TKey, T>=): bool $matcher
     */
    public function match(callable $callback, ?callable $matcher = null): bool
    {
        return (new MatchOne())()($matcher ?? static fn (): bool => true)($callback)($this)->current();
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function matching(Criteria $criteria): CollectionInterface
    {
        return static::fromCallable((new Matching())()($criteria), [$this]);
    }

    /**
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function max($default = null)
    {
        return static::fromCallable((new Max())(), [$this])->current(0, $default);
    }

    /**
     * @template U
     *
     * @param iterable<U> ...$sources
     *
     * @return CollectionInterface<TKey, T|U>
     */
    public function merge(iterable ...$sources): CollectionInterface
    {
        return static::fromCallable((new Merge())()(...$sources), [$this]);
    }

    /**
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function min($default = null)
    {
        return static::fromCallable((new Min())(), [$this])->current(0, $default);
    }

    /**
     * @return CollectionInterface<int, T>
     */
    public function normalize(): CollectionInterface
    {
        return static::fromCallable((new Normalize())(), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return static::fromCallable((new Nth())()($step)($offset), [$this]);
    }

    public function nullsy(): bool
    {
        return (new Nullsy())()($this)->current();
    }

    /**
     * @return CollectionInterface<int, array{0: TKey, 1: T}>
     */
    public function pack(): CollectionInterface
    {
        return static::fromCallable((new Pack())(), [$this]);
    }

    /**
     * Pad a collection to the given length with a given value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#pad
     *
     * @template U
     *
     * @param U $value
     *
     * @return CollectionInterface<int|TKey, T|U>
     */
    public function pad(int $size, $value): CollectionInterface
    {
        return static::fromCallable((new Pad())()($size)($value), [$this]);
    }

    /**
     * @return CollectionInterface<T, T|null>
     */
    public function pair(): CollectionInterface
    {
        return static::fromCallable((new Pair())(), [$this]);
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     *
     * @return CollectionInterface<int, Collection<TKey, T>>
     */
    public function partition(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Partition())()(...$callbacks), [$this])
            ->map(
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return CollectionInterface<TKey, T>
                 */
                static fn (iterable $iterable): CollectionInterface => Collection::fromIterable($iterable)
            );
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function permutate(): CollectionInterface
    {
        return static::fromCallable((new Permutate())(), [$this]);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param callable(iterable<TKey, T>): iterable<UKey, U> ...$callbacks
     *
     * @return CollectionInterface<UKey, U>
     */
    public function pipe(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Pipe())()(...$callbacks), [$this]);
    }

    /**
     * @param array<int, string>|array-key $pluck
     * @param mixed|null $default
     *
     * @return CollectionInterface<int, iterable<int, T>|T>
     */
    public function pluck($pluck, $default = null): CollectionInterface
    {
        return static::fromCallable((new Pluck())()($pluck)($default), [$this]);
    }

    /**
     * @param mixed ...$items
     *
     * @return CollectionInterface<int|TKey, T>
     */
    public function prepend(...$items): CollectionInterface
    {
        return static::fromCallable((new Prepend())()(...$items), [$this]);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> ...$iterables
     *
     * @return CollectionInterface<TKey, list<T|U>>
     */
    public function product(iterable ...$iterables): CollectionInterface
    {
        return static::fromCallable((new Product())()(...$iterables), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function random(int $size = 1, ?int $seed = null): CollectionInterface
    {
        return static::fromCallable((new Random())()($seed ?? random_int(0, 1000))($size), [$this]);
    }

    /**
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return W
     */
    public function reduce(callable $callback, $initial = null)
    {
        return static::fromCallable((new Reduce())()($callback)($initial), [$this])->current();
    }

    /**
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return CollectionInterface<TKey, W>
     */
    public function reduction(callable $callback, $initial = null): CollectionInterface
    {
        return static::fromCallable((new Reduction())()($callback)($initial), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function reject(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Reject())()(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function reverse(): CollectionInterface
    {
        return static::fromCallable((new Reverse())(), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function rsample(float $probability): CollectionInterface
    {
        return static::fromCallable((new RSample())()($probability), [$this]);
    }

    /**
     * @param iterable<mixed, mixed> $other
     * @param null|callable(mixed, mixed): (Closure(mixed, mixed): bool) $comparatorCallback
     */
    public function same(iterable $other, ?callable $comparatorCallback = null): bool
    {
        $comparatorCallback ??=
            /**
             * @param T $leftValue
             * @param TKey $leftKey
             *
             * @return Closure(T, TKey): bool
             */
            static fn ($leftValue, $leftKey): Closure =>
                /**
                 * @param T $rightValue
                 * @param TKey $rightKey
                 */
                static fn ($rightValue, $rightKey): bool => $leftValue === $rightValue && $leftKey === $rightKey;

        return (new Same())()($other)($comparatorCallback)($this)->current();
    }

    /**
     * @return CollectionInterface<TKey, float|int>
     */
    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): CollectionInterface {
        return static::fromCallable((new Scale())()($lowerBound)($upperBound)($wantedLowerBound)($wantedUpperBound)($base), [$this]);
    }

    /**
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return CollectionInterface<TKey, W>
     */
    public function scanLeft(callable $callback, $initial): CollectionInterface
    {
        return static::fromCallable((new ScanLeft())()($callback)($initial), [$this]);
    }

    /**
     * @template W
     *
     * @param callable(T|W, T, TKey, Iterator<TKey, T>): W $callback
     *
     * @return CollectionInterface<TKey, W>
     */
    public function scanLeft1(callable $callback): CollectionInterface
    {
        return static::fromCallable((new ScanLeft1())()($callback), [$this]);
    }

    /**
     * @template V
     * @template W
     *
     * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
     * @param V $initial
     *
     * @return CollectionInterface<TKey, W>
     */
    public function scanRight(callable $callback, $initial): CollectionInterface
    {
        return static::fromCallable((new ScanRight())()($callback)($initial), [$this]);
    }

    /**
     * @template W
     *
     * @param callable(T|W, T, TKey, Iterator<TKey, T>): W $callback
     *
     * @return CollectionInterface<TKey, W>
     */
    public function scanRight1(callable $callback): CollectionInterface
    {
        return static::fromCallable((new ScanRight1())()($callback), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function shuffle(?int $seed = null): CollectionInterface
    {
        return static::fromCallable((new Shuffle())()($seed ?? random_int(0, 1000)), [$this]);
    }

    /**
     * @param callable(T, TKey): bool ...$callbacks
     *
     * @return CollectionInterface<TKey, T>
     */
    public function since(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Since())()(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function slice(int $offset, int $length = -1): CollectionInterface
    {
        return static::fromCallable((new Slice())()($offset)($length), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function sort(int $type = Operation\Sortable::BY_VALUES, ?callable $callback = null): CollectionInterface
    {
        return static::fromCallable((new Sort())()($type)($callback), [$this]);
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     *
     * @return CollectionInterface<int, Collection<TKey, T>>
     */
    public function span(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Span())()(...$callbacks), [$this])
            ->map(
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return CollectionInterface<TKey, T>
                 */
                static fn (iterable $iterable): CollectionInterface => Collection::fromIterable($iterable)
            );
    }

    /**
     * @return CollectionInterface<int, list<T>>
     */
    public function split(int $type = Operation\Splitable::BEFORE, callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Split())()($type)(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function squash(): CollectionInterface
    {
        return static::fromIterable($this->pack()->all(false))->unpack();
    }

    /**
     * @param null|callable(mixed): string $callback
     *
     * @return CollectionInterface<TKey, T>
     */
    public function strict(?callable $callback = null): CollectionInterface
    {
        return static::fromCallable((new Strict())()($callback), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function tail(): CollectionInterface
    {
        return static::fromCallable((new Tail())(), [$this]);
    }

    /**
     * @return CollectionInterface<int, list<T>>
     */
    public function tails(): CollectionInterface
    {
        return static::fromCallable((new Tails())(), [$this]);
    }

    /**
     * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
     *
     * @return CollectionInterface<TKey, T>
     */
    public function takeWhile(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new TakeWhile())()(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, list<T>>
     */
    public function transpose(): CollectionInterface
    {
        return static::fromCallable((new Transpose())(), [$this]);
    }

    public function truthy(): bool
    {
        return (new Truthy())()($this)->current();
    }

    public function unlines(): string
    {
        return static::fromCallable((new Unlines())(), [$this])->current(0, '');
    }

    /**
     * @return CollectionInterface<mixed, mixed>
     */
    public function unpack(): CollectionInterface
    {
        return static::fromCallable((new Unpack())(), [$this]);
    }

    /**
     * @return CollectionInterface<int, TKey|T>
     */
    public function unpair(): CollectionInterface
    {
        return static::fromCallable((new Unpair())(), [$this]);
    }

    /**
     * @param callable(T, TKey):bool ...$callbacks
     *
     * @return CollectionInterface<TKey, T>
     */
    public function until(callable ...$callbacks): CollectionInterface
    {
        return static::fromCallable((new Until())()(...$callbacks), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, T>
     */
    public function unwindow(): CollectionInterface
    {
        return static::fromCallable((new Unwindow())(), [$this]);
    }

    public function unwords(): string
    {
        return static::fromCallable((new Unwords())(), [$this])->current(0, '');
    }

    /**
     * @return CollectionInterface<mixed, mixed>
     */
    public function unwrap(): CollectionInterface
    {
        return static::fromCallable((new Unwrap())(), [$this]);
    }

    /**
     * @return CollectionInterface<int, list<T>>
     */
    public function unzip(): CollectionInterface
    {
        return static::fromCallable((new Unzip())(), [$this]);
    }

    /**
     * @param callable(iterable<TKey, T>): bool $predicate
     * @param callable(iterable<TKey, T>): iterable<TKey, T> $whenTrue
     * @param callable(iterable<TKey, T>): iterable<TKey, T> $whenFalse
     *
     * @return CollectionInterface<TKey, T>
     */
    public function when(callable $predicate, callable $whenTrue, ?callable $whenFalse = null): CollectionInterface
    {
        $whenFalse ??=
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return iterable<TKey, T>
             */
            static fn (iterable $iterable): iterable => $iterable;

        return static::fromCallable((new When())()($predicate)($whenTrue)($whenFalse), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, list<T>>
     */
    public function window(int $size): CollectionInterface
    {
        return static::fromCallable((new Window())()($size), [$this]);
    }

    /**
     * @return CollectionInterface<TKey, string>
     */
    public function words(): CollectionInterface
    {
        return static::fromCallable((new Words())(), [$this]);
    }

    /**
     * @return CollectionInterface<int, array<TKey, T>>
     */
    public function wrap(): CollectionInterface
    {
        return static::fromCallable((new Wrap())(), [$this]);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> ...$iterables
     *
     * @return CollectionInterface<list<TKey|UKey>, list<T|U>>
     */
    public function zip(iterable ...$iterables): CollectionInterface
    {
        return static::fromCallable((new Zip())()(...$iterables), [$this]);
    }
}
