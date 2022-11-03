<?php

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Doctrine\Common\Collections\Criteria;
use Generator;
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
use loophp\collection\Operation\Range;
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
use loophp\collection\Operation\Times;
use loophp\collection\Operation\Transpose;
use loophp\collection\Operation\Truthy;
use loophp\collection\Operation\Unfold;
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
use loophp\iterators\ClosureIteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\ResourceIteratorAggregate;
use loophp\iterators\StringIteratorAggregate;
use NoRewindIterator;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Traversable;

use const INF;
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
final class Collection implements CollectionInterface
{
    /**
     * @var ClosureIteratorAggregate<TKey, T>
     */
    private ClosureIteratorAggregate $innerIterator;

    /**
     * @param callable(mixed ...$parameters): iterable<TKey, T> $callable
     * @param iterable<int, mixed> $parameters
     */
    private function __construct(callable $callable, iterable $parameters = [])
    {
        $this->innerIterator = new ClosureIteratorAggregate($callable, $parameters);
    }

    public function all(bool $normalize = true): array
    {
        return iterator_to_array((new All())()($normalize)($this));
    }

    public function append(...$items): CollectionInterface
    {
        return new self((new Append())()(...$items), [$this]);
    }

    public function apply(callable ...$callbacks): CollectionInterface
    {
        return new self((new Apply())()(...$callbacks), [$this]);
    }

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

        return new self((new Associate())()($callbackForKeys ?? $defaultCallback)($callbackForValues ?? $defaultCallback), [$this]);
    }

    public function asyncMap(callable $callback): CollectionInterface
    {
        return new self((new AsyncMap())()($callback), [$this]);
    }

    public function asyncMapN(callable ...$callbacks): CollectionInterface
    {
        return new self((new AsyncMapN())()(...$callbacks), [$this]);
    }

    public function averages(): CollectionInterface
    {
        return new self((new Averages())(), [$this]);
    }

    public function cache(?CacheItemPoolInterface $cache = null): CollectionInterface
    {
        return new self((new Cache())()($cache ?? new ArrayAdapter()), [$this]);
    }

    public function chunk(int ...$sizes): CollectionInterface
    {
        return new self((new Chunk())()(...$sizes), [$this]);
    }

    public function coalesce(): CollectionInterface
    {
        return new self((new Coalesce())(), [$this]);
    }

    public function collapse(): CollectionInterface
    {
        return new self((new Collapse())(), [$this]);
    }

    public function column($column): CollectionInterface
    {
        return new self((new Column())()($column), [$this]);
    }

    public function combinate(?int $length = null): CollectionInterface
    {
        return new self((new Combinate())()($length), [$this]);
    }

    public function combine(...$keys): CollectionInterface
    {
        return new self((new Combine())()(...$keys), [$this]);
    }

    public function compact(...$values): CollectionInterface
    {
        return new self((new Compact())()(...$values), [$this]);
    }

    public function compare(callable $comparator, $default = null)
    {
        return (new self((new Compare())()($comparator), [$this]))->current(0, $default);
    }

    public function contains(...$values): bool
    {
        return (new Contains())()(...$values)($this)->current();
    }

    public function count(): int
    {
        return iterator_count($this);
    }

    public function current(int $index = 0, $default = null)
    {
        return (new Current())()($index)($default)($this)->current();
    }

    public function cycle(): CollectionInterface
    {
        return new self((new Cycle())(), [$this]);
    }

    public function diff(...$values): CollectionInterface
    {
        return new self((new Diff())()(...$values), [$this]);
    }

    public function diffKeys(...$keys): CollectionInterface
    {
        return new self((new DiffKeys())()(...$keys), [$this]);
    }

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

        return new self((new Distinct())()($comparatorCallback)($accessorCallback), [$this]);
    }

    public function drop(int $count): CollectionInterface
    {
        return new self((new Drop())()($count), [$this]);
    }

    public function dropWhile(callable ...$callbacks): CollectionInterface
    {
        return new self((new DropWhile())()(...$callbacks), [$this]);
    }

    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): CollectionInterface
    {
        return new self((new Dump())()($name)($size)($closure), [$this]);
    }

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

        return new self((new Duplicate())()($comparatorCallback)($accessorCallback), [$this]);
    }

    /**
     * @return self<TKey, T>
     */
    public static function empty(): CollectionInterface
    {
        return new self(static fn (): Generator => yield from []);
    }

    public function equals(iterable $other): bool
    {
        return (new Equals())()($other)($this)->current();
    }

    public function every(callable ...$callbacks): bool
    {
        return (new Every())()(static fn (int $index, $value, $key, iterable $iterable) => CallbacksArrayReducer::or()($callbacks)($value, $key, $iterable))($this)
            ->current();
    }

    public function explode(...$explodes): CollectionInterface
    {
        return new self((new Explode())()(...$explodes), [$this]);
    }

    public function falsy(): bool
    {
        return (new Falsy())()($this)->current();
    }

    public function filter(callable ...$callbacks): CollectionInterface
    {
        return new self((new Filter())()(...$callbacks), [$this]);
    }

    public function find($default = null, callable ...$callbacks)
    {
        return (new Find())()($default)(...$callbacks)($this)->current();
    }

    public function first($default = null)
    {
        return (new self((new First())(), [$this]))->current(0, $default);
    }

    public function flatMap(callable $callback): CollectionInterface
    {
        return new self((new FlatMap())()($callback), [$this]);
    }

    public function flatten(int $depth = PHP_INT_MAX): CollectionInterface
    {
        return new self((new Flatten())()($depth), [$this]);
    }

    public function flip(): CollectionInterface
    {
        return new self((new Flip())(), [$this]);
    }

    public function foldLeft(callable $callback, $initial)
    {
        return (new self((new FoldLeft())()($callback)($initial), [$this]))->current();
    }

    public function foldLeft1(callable $callback)
    {
        return (new self((new FoldLeft1())()($callback), [$this]))->current();
    }

    public function foldRight(callable $callback, $initial)
    {
        return (new self((new Foldright())()($callback)($initial), [$this]))->current();
    }

    public function foldRight1(callable $callback)
    {
        return (new self((new FoldRight1())()($callback), [$this]))->current();
    }

    public function forget(...$keys): CollectionInterface
    {
        return new self((new Forget())()(...$keys), [$this]);
    }

    public function frequency(): CollectionInterface
    {
        return new self((new Frequency())(), [$this]);
    }

    /**
     * @template NewTKey
     * @template NewT
     *
     * @param callable(mixed ...$parameters): iterable<NewTKey, NewT> $callable
     * @param iterable<int, mixed> $parameters
     *
     * @return self<NewTKey, NewT>
     */
    public static function fromCallable(callable $callable, iterable $parameters = []): self
    {
        return new self($callable, $parameters);
    }

    /**
     * @return self<int, string>
     */
    public static function fromFile(string $filepath): self
    {
        return new self(
            static fn (): Generator => yield from new ResourceIteratorAggregate(fopen($filepath, 'rb'), true),
        );
    }

    /**
     * @template NewTKey
     * @template NewT
     *
     * @param Generator<NewTKey, NewT> $generator
     *
     * @return self<NewTKey, NewT>
     */
    public static function fromGenerator(Generator $generator): self
    {
        return new self(static fn (): Generator => yield from new NoRewindIterator($generator));
    }

    /**
     * @template NewTKey
     * @template NewT
     *
     * @param iterable<NewTKey, NewT> $iterable
     *
     * @return self<NewTKey, NewT>
     */
    public static function fromIterable(iterable $iterable): self
    {
        return new self(static fn (): Generator => yield from new IterableIteratorAggregate($iterable));
    }

    /**
     * @param resource $resource
     *
     * @return self<int, string>
     */
    public static function fromResource($resource): self
    {
        return new self(static fn (): Generator => yield from new ResourceIteratorAggregate($resource));
    }

    /**
     * @return self<int, string>
     */
    public static function fromString(string $string, string $delimiter = ''): self
    {
        return new self(static fn (): Generator => yield from new StringIteratorAggregate($string, $delimiter));
    }

    public function get($key, $default = null)
    {
        return (new self((new Get())()($key)($default), [$this]))->current(0, $default);
    }

    /**
     * @return Traversable<TKey, T>
     */
    public function getIterator(): Traversable
    {
        yield from $this->innerIterator->getIterator();
    }

    public function group(): CollectionInterface
    {
        return new self((new Group())(), [$this]);
    }

    public function groupBy(callable $callable): CollectionInterface
    {
        return new self((new GroupBy())()($callable), [$this]);
    }

    public function has(callable ...$callbacks): bool
    {
        return (new Has())()(...$callbacks)($this)->current();
    }

    public function head($default = null)
    {
        return (new self((new Head())(), [$this]))->current(0, $default);
    }

    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): CollectionInterface
    {
        $identity =
            /**
             * @param T $value
             *
             * @return T
             */
            static fn ($value) => $value;

        return new self((new IfThenElse())()($condition)($then)($else ?? $identity), [$this]);
    }

    public function implode(string $glue = ''): string
    {
        return (new self((new Implode())()($glue), [$this]))->current(0, '');
    }

    public function init(): CollectionInterface
    {
        return new self((new Init())(), [$this]);
    }

    public function inits(): CollectionInterface
    {
        return new self((new Inits())(), [$this]);
    }

    public function intersect(...$values): CollectionInterface
    {
        return new self((new Intersect())()(...$values), [$this]);
    }

    public function intersectKeys(...$keys): CollectionInterface
    {
        return new self((new IntersectKeys())()(...$keys), [$this]);
    }

    public function intersperse($element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return new self((new Intersperse())()($element)($every)($startAt), [$this]);
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

    public function key(int $index = 0)
    {
        return (new Key())()($index)($this)->current();
    }

    public function keys(): CollectionInterface
    {
        return new self((new Keys())(), [$this]);
    }

    public function last($default = null)
    {
        return (new self((new Last())(), [$this]))->current(0, $default);
    }

    public function limit(int $count = -1, int $offset = 0): CollectionInterface
    {
        return new self((new Limit())()($count)($offset), [$this]);
    }

    public function lines(): CollectionInterface
    {
        return new self((new Lines())(), [$this]);
    }

    public function map(callable $callback): CollectionInterface
    {
        return new self((new Map())()($callback), [$this]);
    }

    public function mapN(callable ...$callbacks): CollectionInterface
    {
        return new self((new MapN())()(...$callbacks), [$this]);
    }

    public function match(callable $callback, ?callable $matcher = null): bool
    {
        return (new MatchOne())()($matcher ?? static fn (): bool => true)($callback)($this)->current();
    }

    public function matching(Criteria $criteria): CollectionInterface
    {
        return new self((new Matching())()($criteria), [$this]);
    }

    public function max($default = null)
    {
        return (new self((new Max())(), [$this]))->current(0, $default);
    }

    public function merge(iterable ...$sources): CollectionInterface
    {
        return new self((new Merge())()(...$sources), [$this]);
    }

    public function min($default = null)
    {
        return (new self((new Min())(), [$this]))->current(0, $default);
    }

    public function normalize(): CollectionInterface
    {
        return new self((new Normalize())(), [$this]);
    }

    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return new self((new Nth())()($step)($offset), [$this]);
    }

    public function nullsy(): bool
    {
        return (new Nullsy())()($this)->current();
    }

    public function pack(): CollectionInterface
    {
        return new self((new Pack())(), [$this]);
    }

    public function pad(int $size, $value): CollectionInterface
    {
        return new self((new Pad())()($size)($value), [$this]);
    }

    public function pair(): CollectionInterface
    {
        return new self((new Pair())(), [$this]);
    }

    public function partition(callable ...$callbacks): CollectionInterface
    {
        return (new self((new Partition())()(...$callbacks), [$this]))
            ->map(
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return CollectionInterface<TKey, T>
                 */
                static fn (iterable $iterable): CollectionInterface => Collection::fromIterable($iterable)
            );
    }

    public function permutate(): CollectionInterface
    {
        return new self((new Permutate())(), [$this]);
    }

    public function pipe(callable ...$callbacks): CollectionInterface
    {
        return new self((new Pipe())()(...$callbacks), [$this]);
    }

    public function pluck($pluck, $default = null): CollectionInterface
    {
        return new self((new Pluck())()($pluck)($default), [$this]);
    }

    public function prepend(...$items): CollectionInterface
    {
        return new self((new Prepend())()(...$items), [$this]);
    }

    public function product(iterable ...$iterables): CollectionInterface
    {
        return new self((new Product())()(...$iterables), [$this]);
    }

    public function random(int $size = 1, ?int $seed = null): CollectionInterface
    {
        return new self((new Random())()($seed ?? random_int(0, 1000))($size), [$this]);
    }

    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return new self((new Range())()($start)($end)($step));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return (new self((new Reduce())()($callback)($initial), [$this]))->current();
    }

    public function reduction(callable $callback, $initial = null): CollectionInterface
    {
        return new self((new Reduction())()($callback)($initial), [$this]);
    }

    public function reject(callable ...$callbacks): CollectionInterface
    {
        return new self((new Reject())()(...$callbacks), [$this]);
    }

    public function reverse(): CollectionInterface
    {
        return new self((new Reverse())(), [$this]);
    }

    public function rsample(float $probability): CollectionInterface
    {
        return new self((new RSample())()($probability), [$this]);
    }

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

    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): CollectionInterface {
        return new self((new Scale())()($lowerBound)($upperBound)($wantedLowerBound)($wantedUpperBound)($base), [$this]);
    }

    public function scanLeft(callable $callback, $initial): CollectionInterface
    {
        return new self((new ScanLeft())()($callback)($initial), [$this]);
    }

    public function scanLeft1(callable $callback): CollectionInterface
    {
        return new self((new ScanLeft1())()($callback), [$this]);
    }

    public function scanRight(callable $callback, $initial): CollectionInterface
    {
        return new self((new ScanRight())()($callback)($initial), [$this]);
    }

    public function scanRight1(callable $callback): CollectionInterface
    {
        return new self((new ScanRight1())()($callback), [$this]);
    }

    public function shuffle(?int $seed = null): CollectionInterface
    {
        return new self((new Shuffle())()($seed ?? random_int(0, 1000)), [$this]);
    }

    public function since(callable ...$callbacks): CollectionInterface
    {
        return new self((new Since())()(...$callbacks), [$this]);
    }

    public function slice(int $offset, int $length = -1): CollectionInterface
    {
        return new self((new Slice())()($offset)($length), [$this]);
    }

    public function sort(int $type = Operation\Sortable::BY_VALUES, ?callable $callback = null): CollectionInterface
    {
        return new self((new Sort())()($type)($callback), [$this]);
    }

    public function span(callable ...$callbacks): CollectionInterface
    {
        return (new self((new Span())()(...$callbacks), [$this]))
            ->map(
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return CollectionInterface<TKey, T>
                 */
                static fn (iterable $iterable): CollectionInterface => Collection::fromIterable($iterable)
            );
    }

    public function split(int $type = Operation\Splitable::BEFORE, callable ...$callbacks): CollectionInterface
    {
        return new self((new Split())()($type)(...$callbacks), [$this]);
    }

    public function squash(): CollectionInterface
    {
        return self::fromIterable($this->pack()->all(false))->unpack();
    }

    public function strict(?callable $callback = null): CollectionInterface
    {
        return new self((new Strict())()($callback), [$this]);
    }

    public function tail(): CollectionInterface
    {
        return new self((new Tail())(), [$this]);
    }

    public function tails(): CollectionInterface
    {
        return new self((new Tails())(), [$this]);
    }

    public function takeWhile(callable ...$callbacks): CollectionInterface
    {
        return new self((new TakeWhile())()(...$callbacks), [$this]);
    }

    public static function times(int $number = 0, ?callable $callback = null): CollectionInterface
    {
        return new self((new Times())()($number)($callback));
    }

    public function transpose(): CollectionInterface
    {
        return new self((new Transpose())(), [$this]);
    }

    public function truthy(): bool
    {
        return (new Truthy())()($this)->current();
    }

    public static function unfold(callable $callback, array $parameters = []): CollectionInterface
    {
        return new self((new Unfold())()($parameters)($callback));
    }

    public function unlines(): string
    {
        return (new self((new Unlines())(), [$this]))->current(0, '');
    }

    public function unpack(): CollectionInterface
    {
        return new self((new Unpack())(), [$this]);
    }

    public function unpair(): CollectionInterface
    {
        return new self((new Unpair())(), [$this]);
    }

    public function until(callable ...$callbacks): CollectionInterface
    {
        return new self((new Until())()(...$callbacks), [$this]);
    }

    public function unwindow(): CollectionInterface
    {
        return new self((new Unwindow())(), [$this]);
    }

    public function unwords(): string
    {
        return (new self((new Unwords())(), [$this]))->current(0, '');
    }

    public function unwrap(): CollectionInterface
    {
        return new self((new Unwrap())(), [$this]);
    }

    public function unzip(): CollectionInterface
    {
        return new self((new Unzip())(), [$this]);
    }

    public function when(callable $predicate, callable $whenTrue, ?callable $whenFalse = null): CollectionInterface
    {
        $whenFalse ??=
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return iterable<TKey, T>
             */
            static fn (iterable $iterable): iterable => $iterable;

        return new self((new When())()($predicate)($whenTrue)($whenFalse), [$this]);
    }

    public function window(int $size): CollectionInterface
    {
        return new self((new Window())()($size), [$this]);
    }

    public function words(): CollectionInterface
    {
        return new self((new Words())(), [$this]);
    }

    public function wrap(): CollectionInterface
    {
        return new self((new Wrap())(), [$this]);
    }

    public function zip(iterable ...$iterables): CollectionInterface
    {
        return new self((new Zip())()(...$iterables), [$this]);
    }
}
