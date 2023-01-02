<?php

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Countable;
use Doctrine\Common\Collections\Criteria;
use Generator;
use JsonSerializable;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Contract\Operation as OperationInterface;
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
 * @implements \loophp\collection\Contract\Collection<TKey, T>
 */
final class Collection implements CollectionInterface, JsonSerializable, Countable
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
        return iterator_to_array((new Operation\All())()($normalize)($this));
    }

    public function append(mixed ...$items): CollectionInterface
    {
        return new self((new Operation\Append())()($items), [$this]);
    }

    public function apply(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Apply())()(...$callbacks), [$this]);
    }

    public function associate(
        ?callable $callbackForKeys = null,
        ?callable $callbackForValues = null
    ): CollectionInterface {
        $defaultCallback = static fn (mixed $carry): mixed => $carry;

        return new self((new Operation\Associate())()($callbackForKeys ?? $defaultCallback)($callbackForValues ?? $defaultCallback), [$this]);
    }

    public function asyncMap(callable $callback): CollectionInterface
    {
        return new self((new Operation\AsyncMap())()($callback), [$this]);
    }

    public function asyncMapN(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\AsyncMapN())()(...$callbacks), [$this]);
    }

    public function averages(): CollectionInterface
    {
        return new self((new Operation\Averages())(), [$this]);
    }

    public function cache(?CacheItemPoolInterface $cache = null): CollectionInterface
    {
        return new self((new Operation\Cache())()($cache ?? new ArrayAdapter()), [$this]);
    }

    public function chunk(int ...$sizes): CollectionInterface
    {
        return new self((new Operation\Chunk())()(...$sizes), [$this]);
    }

    public function coalesce(): CollectionInterface
    {
        return new self((new Operation\Coalesce())(), [$this]);
    }

    public function collapse(): CollectionInterface
    {
        return new self((new Operation\Collapse())(), [$this]);
    }

    public function column(mixed $column): CollectionInterface
    {
        return new self((new Operation\Column())()($column), [$this]);
    }

    public function combinate(?int $length = null): CollectionInterface
    {
        return new self((new Operation\Combinate())()($length), [$this]);
    }

    public function combine(mixed ...$keys): CollectionInterface
    {
        return new self((new Operation\Combine())()($keys), [$this]);
    }

    public function compact(mixed ...$values): CollectionInterface
    {
        return new self((new Operation\Compact())()($values), [$this]);
    }

    public function compare(callable $comparator, $default = null)
    {
        return (new self((new Operation\Compare())()($comparator), [$this]))->current(0, $default);
    }

    public function contains(mixed ...$values): bool
    {
        return (new Operation\Contains())()($values)($this)->current();
    }

    public function count(): int
    {
        return iterator_count($this);
    }

    public function current(int $index = 0, $default = null)
    {
        return (new Operation\Current())()($index)($default)($this)->current();
    }

    public function cycle(): CollectionInterface
    {
        return new self((new Operation\Cycle())(), [$this]);
    }

    public function diff(mixed ...$values): CollectionInterface
    {
        return new self((new Operation\Diff())()($values), [$this]);
    }

    public function diffKeys(mixed ...$keys): CollectionInterface
    {
        return new self((new Operation\DiffKeys())()($keys), [$this]);
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
            static fn (mixed $value, mixed $key): mixed => $value;

        $comparatorCallback ??=
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn (mixed $left): Closure =>
                /**
                 * @param T $right
                 */
                static fn (mixed $right): bool => $left === $right;

        return new self((new Operation\Distinct())()($comparatorCallback)($accessorCallback), [$this]);
    }

    public function drop(int $count): CollectionInterface
    {
        return new self((new Operation\Drop())()($count), [$this]);
    }

    public function dropWhile(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\DropWhile())()(...$callbacks), [$this]);
    }

    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): CollectionInterface
    {
        return new self((new Operation\Dump())()($name)($size)($closure), [$this]);
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
            static fn (mixed $value, mixed $key): mixed => $value;

        $comparatorCallback ??=
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn (mixed $left): Closure =>
                /**
                 * @param T $right
                 */
                static fn (mixed $right): bool => $left === $right;

        return new self((new Operation\Duplicate())()($comparatorCallback)($accessorCallback), [$this]);
    }

    /**
     * @template UKey
     * @template U
     *
     * @return self<UKey, U>
     */
    public static function empty(): CollectionInterface
    {
        return self::fromIterable([]);
    }

    public function equals(iterable $other): bool
    {
        return (new Operation\Equals())()($other)($this)->current();
    }

    public function every(callable ...$callbacks): bool
    {
        return (new Operation\Every())()(static fn (int $index, mixed $value, mixed $key, iterable $iterable): bool => CallbacksArrayReducer::or()($callbacks)($value, $key, $iterable))($this)
            ->current();
    }

    public function explode(mixed ...$explodes): CollectionInterface
    {
        return new self((new Operation\Explode())()($explodes), [$this]);
    }

    public function falsy(): bool
    {
        return (new Operation\Falsy())()($this)->current();
    }

    public function filter(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Filter())()(...$callbacks), [$this]);
    }

    public function find(mixed $default = null, callable ...$callbacks)
    {
        return (new Operation\Find())()($default)(...$callbacks)($this)->current();
    }

    public function first(mixed $default = null)
    {
        return (new self((new Operation\First())(), [$this]))->current(0, $default);
    }

    public function flatMap(callable $callback): CollectionInterface
    {
        return new self((new Operation\FlatMap())()($callback), [$this]);
    }

    public function flatten(int $depth = PHP_INT_MAX): CollectionInterface
    {
        return new self((new Operation\Flatten())()($depth), [$this]);
    }

    public function flip(): CollectionInterface
    {
        return new self((new Operation\Flip())(), [$this]);
    }

    public function foldLeft(callable $callback, mixed $initial)
    {
        return (new self((new Operation\FoldLeft())()($callback)($initial), [$this]))->current();
    }

    public function foldLeft1(callable $callback): mixed
    {
        return (new self((new Operation\FoldLeft1())()($callback), [$this]))->current();
    }

    public function foldRight(callable $callback, mixed $initial): mixed
    {
        return (new self((new Operation\FoldRight())()($callback)($initial), [$this]))->current();
    }

    public function foldRight1(callable $callback): mixed
    {
        return (new self((new Operation\FoldRight1())()($callback), [$this]))->current();
    }

    public function forget(mixed ...$keys): CollectionInterface
    {
        return new self((new Operation\Forget())()($keys), [$this]);
    }

    public function frequency(): CollectionInterface
    {
        return new self((new Operation\Frequency())(), [$this]);
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
    public static function fromCallable(callable $callable, iterable $parameters = []): CollectionInterface
    {
        return new self($callable, $parameters);
    }

    /**
     * @return self<int, string>
     */
    public static function fromFile(string $filepath): CollectionInterface
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
    public static function fromGenerator(Generator $generator): CollectionInterface
    {
        return new self(static fn (): Generator => yield from new NoRewindIterator($generator));
    }

    /**
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> $iterable
     *
     * @return self<UKey, U>
     */
    public static function fromIterable(iterable $iterable): CollectionInterface
    {
        return new self(static fn (): Generator => yield from new IterableIteratorAggregate($iterable));
    }

    /**
     * @param resource $resource
     *
     * @return self<int, string>
     */
    public static function fromResource($resource): CollectionInterface
    {
        return new self(static fn (): Generator => yield from new ResourceIteratorAggregate($resource));
    }

    /**
     * @return self<int, string>
     */
    public static function fromString(string $string, string $delimiter = ''): CollectionInterface
    {
        return new self(static fn (): Generator => yield from new StringIteratorAggregate($string, $delimiter));
    }

    public function get(mixed $key, mixed $default = null)
    {
        return (new self((new Operation\Get())()($key)($default), [$this]))->current(0, $default);
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
        return new self((new Operation\Group())(), [$this]);
    }

    public function groupBy(callable $callback): CollectionInterface
    {
        return new self((new Operation\GroupBy())()($callback), [$this]);
    }

    public function has(callable ...$callbacks): bool
    {
        return (new Operation\Has())()(...$callbacks)($this)->current();
    }

    public function head(mixed $default = null)
    {
        return (new self((new Operation\Head())(), [$this]))->current(0, $default);
    }

    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): CollectionInterface
    {
        $identity =
            /**
             * @param T $value
             *
             * @return T
             */
            static fn (mixed $value): mixed => $value;

        return new self((new Operation\IfThenElse())()($condition)($then)($else ?? $identity), [$this]);
    }

    public function implode(string $glue = ''): string
    {
        return (new self((new Operation\Implode())()($glue), [$this]))->current(0, '');
    }

    public function init(): CollectionInterface
    {
        return new self((new Operation\Init())(), [$this]);
    }

    public function inits(): CollectionInterface
    {
        return new self((new Operation\Inits())(), [$this]);
    }

    public function intersect(mixed ...$values): CollectionInterface
    {
        return new self((new Operation\Intersect())()($values), [$this]);
    }

    public function intersectKeys(mixed ...$keys): CollectionInterface
    {
        return new self((new Operation\IntersectKeys())()($keys), [$this]);
    }

    public function intersperse(mixed $element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return new self((new Operation\Intersperse())()($element)($every)($startAt), [$this]);
    }

    public function isEmpty(): bool
    {
        return (new Operation\IsEmpty())()($this)->current();
    }

    public function isNotEmpty(): bool
    {
        return (new Operation\IsNotEmpty())()($this)->current();
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->all(false);
    }

    public function key(int $index = 0): mixed
    {
        return (new Operation\Key())()($index)($this)->current();
    }

    public function keys(): CollectionInterface
    {
        return new self((new Operation\Keys())(), [$this]);
    }

    public function last(mixed $default = null): mixed
    {
        return (new self((new Operation\Last())(), [$this]))->current(0, $default);
    }

    public function limit(int $count = -1, int $offset = 0): CollectionInterface
    {
        return new self((new Operation\Limit())()($count)($offset), [$this]);
    }

    public function lines(): CollectionInterface
    {
        return new self((new Operation\Lines())(), [$this]);
    }

    public function map(callable $callback): CollectionInterface
    {
        return new self((new Operation\Map())()($callback), [$this]);
    }

    public function mapN(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\MapN())()(...$callbacks), [$this]);
    }

    public function match(callable $callback, ?callable $matcher = null): bool
    {
        return (new Operation\MatchOne())()($matcher ?? static fn (): bool => true)($callback)($this)->current();
    }

    public function matching(Criteria $criteria): CollectionInterface
    {
        return new self((new Operation\Matching())()($criteria), [$this]);
    }

    public function max(mixed $default = null): mixed
    {
        return (new self((new Operation\Max())(), [$this]))->current(0, $default);
    }

    public function merge(iterable ...$sources): CollectionInterface
    {
        return new self((new Operation\Merge())()(...$sources), [$this]);
    }

    public function min(mixed $default = null): mixed
    {
        return (new self((new Operation\Min())(), [$this]))->current(0, $default);
    }

    public function normalize(): CollectionInterface
    {
        return new self((new Operation\Normalize())(), [$this]);
    }

    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return new self((new Operation\Nth())()($step)($offset), [$this]);
    }

    public function nullsy(): bool
    {
        return (new Operation\Nullsy())()($this)->current();
    }

    public function pack(): CollectionInterface
    {
        return new self((new Operation\Pack())(), [$this]);
    }

    public function pad(int $size, mixed $value): CollectionInterface
    {
        return new self((new Operation\Pad())()($size)($value), [$this]);
    }

    public function pair(): CollectionInterface
    {
        return new self((new Operation\Pair())(), [$this]);
    }

    public function partition(callable ...$callbacks): CollectionInterface
    {
        return (new self((new Operation\Partition())()(...$callbacks), [$this]))
            ->map(
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Collection<TKey, T>
                 */
                static fn (iterable $iterable): Collection => Collection::fromIterable($iterable)
            );
    }

    public function permutate(): CollectionInterface
    {
        return new self((new Operation\Permutate())(), [$this]);
    }

    public function pipe(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Pipe())()(...$callbacks), [$this]);
    }

    public function pluck(mixed $pluck, mixed $default = null): CollectionInterface
    {
        return new self((new Operation\Pluck())()($pluck)($default), [$this]);
    }

    public function prepend(mixed ...$items): CollectionInterface
    {
        return new self((new Operation\Prepend())()($items), [$this]);
    }

    public function product(iterable ...$iterables): CollectionInterface
    {
        return new self((new Operation\Product())()(...$iterables), [$this]);
    }

    public function random(int $size = 1, ?int $seed = null): CollectionInterface
    {
        return new self((new Operation\Random())()($seed ?? random_int(0, 1000))($size), [$this]);
    }

    /**
     * @return self<int, float>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return new self((new Operation\Range())()($start)($end)($step));
    }

    public function reduce(callable $callback, mixed $initial = null)
    {
        return (new self((new Operation\Reduce())()($callback)($initial), [$this]))->current();
    }

    public function reduction(callable $callback, mixed $initial = null): CollectionInterface
    {
        return new self((new Operation\Reduction())()($callback)($initial), [$this]);
    }

    public function reject(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Reject())()(...$callbacks), [$this]);
    }

    public function reverse(): CollectionInterface
    {
        return new self((new Operation\Reverse())(), [$this]);
    }

    public function rsample(float $probability): CollectionInterface
    {
        return new self((new Operation\RSample())()($probability), [$this]);
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
            static fn (mixed $leftValue, mixed $leftKey): Closure =>
                /**
                 * @param T $rightValue
                 * @param TKey $rightKey
                 */
                static fn (mixed $rightValue, mixed $rightKey): bool => $leftValue === $rightValue && $leftKey === $rightKey;

        return (new Operation\Same())()($other)($comparatorCallback)($this)->current();
    }

    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): CollectionInterface {
        return new self((new Operation\Scale())()($lowerBound)($upperBound)($wantedLowerBound)($wantedUpperBound)($base), [$this]);
    }

    public function scanLeft(callable $callback, mixed $initial): CollectionInterface
    {
        return new self((new Operation\ScanLeft())()($callback)($initial), [$this]);
    }

    public function scanLeft1(callable $callback): CollectionInterface
    {
        return new self((new Operation\ScanLeft1())()($callback), [$this]);
    }

    public function scanRight(callable $callback, mixed $initial): CollectionInterface
    {
        return new self((new Operation\ScanRight())()($callback)($initial), [$this]);
    }

    public function scanRight1(callable $callback): CollectionInterface
    {
        return new self((new Operation\ScanRight1())()($callback), [$this]);
    }

    public function shuffle(?int $seed = null): CollectionInterface
    {
        return new self((new Operation\Shuffle())()($seed ?? random_int(0, 1000)), [$this]);
    }

    public function since(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Since())()(...$callbacks), [$this]);
    }

    public function slice(int $offset, int $length = -1): CollectionInterface
    {
        return new self((new Operation\Slice())()($offset)($length), [$this]);
    }

    public function sort(int $type = OperationInterface\Sortable::BY_VALUES, ?callable $callback = null): CollectionInterface
    {
        return new self((new Operation\Sort())()($type)($callback), [$this]);
    }

    public function span(callable ...$callbacks): CollectionInterface
    {
        return (new self((new Operation\Span())()(...$callbacks), [$this]))
            ->map(
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Collection<TKey, T>
                 */
                static fn (iterable $iterable): Collection => Collection::fromIterable($iterable)
            );
    }

    public function split(int $type = OperationInterface\Splitable::BEFORE, callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Split())()($type)(...$callbacks), [$this]);
    }

    public function squash(): CollectionInterface
    {
        return self::fromIterable($this->pack()->all(false))->unpack();
    }

    public function strict(?callable $callback = null): CollectionInterface
    {
        return new self((new Operation\Strict())()($callback), [$this]);
    }

    public function tail(): CollectionInterface
    {
        return new self((new Operation\Tail())(), [$this]);
    }

    public function tails(): CollectionInterface
    {
        return new self((new Operation\Tails())(), [$this]);
    }

    public function takeWhile(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\TakeWhile())()(...$callbacks), [$this]);
    }

    /**
     * @template U
     *
     * @param callable(int): U $callback
     *
     * @return self<int, U>
     */
    public static function times(int $number = 0, ?callable $callback = null): CollectionInterface
    {
        return new self((new Operation\Times())()($number)($callback));
    }

    public function transpose(): CollectionInterface
    {
        return new self((new Operation\Transpose())(), [$this]);
    }

    public function truthy(): bool
    {
        return (new Operation\Truthy())()($this)->current();
    }

    public static function unfold(callable $callback, iterable $parameters = []): CollectionInterface
    {
        return new self((new Operation\Unfold())()($parameters)($callback));
    }

    public function unlines(): string
    {
        return (new self((new Operation\Unlines())(), [$this]))->current(0, '');
    }

    public function unpack(): CollectionInterface
    {
        return new self((new Operation\Unpack())(), [$this]);
    }

    public function unpair(): CollectionInterface
    {
        return new self((new Operation\Unpair())(), [$this]);
    }

    public function until(callable ...$callbacks): CollectionInterface
    {
        return new self((new Operation\Until())()(...$callbacks), [$this]);
    }

    public function unwindow(): CollectionInterface
    {
        return new self((new Operation\Unwindow())(), [$this]);
    }

    public function unwords(): string
    {
        return (new self((new Operation\Unwords())(), [$this]))->current(0, '');
    }

    public function unwrap(): CollectionInterface
    {
        return new self((new Operation\Unwrap())(), [$this]);
    }

    public function unzip(): CollectionInterface
    {
        return new self((new Operation\Unzip())(), [$this]);
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

        return new self((new Operation\When())()($predicate)($whenTrue)($whenFalse), [$this]);
    }

    public function window(int $size): CollectionInterface
    {
        return new self((new Operation\Window())()($size), [$this]);
    }

    public function words(): CollectionInterface
    {
        return new self((new Operation\Words())(), [$this]);
    }

    public function wrap(): CollectionInterface
    {
        return new self((new Operation\Wrap())(), [$this]);
    }

    public function zip(iterable ...$iterables): CollectionInterface
    {
        return new self((new Operation\Zip())()(...$iterables), [$this]);
    }
}
