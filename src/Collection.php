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
use loophp\collection\Operation\Pipe;
use loophp\collection\Utils\CallbacksArrayReducer;
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
     * @param array{callable(iterable<TKey, T>): iterable<TKey, T>} $pipe
     */
    public array $pipe;

    /**
     * @param iterable<TKey, T> $subject
     */
    public iterable $subject;

    /**
     * @param array{callable(iterable<TKey, T>): iterable<TKey, T>} $pipe
     * @param iterable<TKey, T> $subject
     */
    private function __construct(array $pipe = [], iterable $subject = [])
    {
        $this->pipe = $pipe;
        $this->subject = $subject;
    }

    public function all(bool $normalize = true): array
    {
        return iterator_to_array($this, !$normalize);
    }

    public function append(mixed ...$items): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Append())()($items)], $this->subject);
    }

    public function apply(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Apply())()(...$callbacks)], $this->subject);
    }

    public function associate(
        ?callable $callbackForKeys = null,
        ?callable $callbackForValues = null
    ): CollectionInterface {
        $defaultCallback = static fn(mixed $carry): mixed => $carry;

        return new self([...$this->pipe, (new Operation\Associate())()($callbackForKeys ?? $defaultCallback)($callbackForValues ?? $defaultCallback)], $this->subject);
    }

    public function asyncMap(callable $callback): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\AsyncMap())()($callback)], $this->subject);
    }

    public function asyncMapN(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\AsyncMapN())()(...$callbacks)], $this->subject);
    }

    public function averages(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Averages())()], $this->subject);
    }

    public function cache(?CacheItemPoolInterface $cache = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Cache())()($cache ?? new ArrayAdapter())], $this->subject);
    }

    public function chunk(int ...$sizes): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Chunk())()(...$sizes)], $this->subject);
    }

    public function coalesce(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Coalesce())()], $this->subject);
    }

    public function collapse(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Collapse())()], $this->subject);
    }

    public function column(mixed $column): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Column())()($column)], $this->subject);
    }

    public function combinate(?int $length = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Combinate())()($length)], $this->subject);
    }

    public function combine(mixed ...$keys): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Combine())()($keys)], $this->subject);
    }

    public function compact(mixed ...$values): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Compact())()($values)], $this->subject);
    }

    public function compare(callable $comparator, $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Compare())()($comparator)], $this->subject))->current(0, $default);
    }

    public function contains(mixed ...$values): bool
    {
        return (new self([...$this->pipe, (new Operation\Contains())()($values)], $this->subject))->current();
    }

    public function count(): int
    {
        return iterator_count($this);
    }

    public function countIn(int &$counter): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Tap())()(
            static function () use (&$counter): void {
                ++$counter;
            }
        )], $this->subject);
    }

    public function current(int $index = 0, $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Current())()($index)($default)], $this->subject))->getIterator()->current();
    }

    public function cycle(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Cycle())()], $this->subject);
    }

    public function diff(mixed ...$values): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Diff())()($values)], $this->subject);
    }

    public function diffKeys(mixed ...$keys): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\DiffKeys())()($keys)], $this->subject);
    }

    public function dispersion(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Dispersion())()], $this->subject);
    }

    public function distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): CollectionInterface
    {
        $accessorCallback ??=
            /**
             * @param T $value
             *
             * @return T
             */
            static fn(mixed $value): mixed => $value;

        $comparatorCallback ??=
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn(mixed $left): Closure =>
            /**
             * @param T $right
             */
            static fn(mixed $right): bool => $left === $right;

        return new self([...$this->pipe, (new Operation\Distinct())()($comparatorCallback)($accessorCallback)], $this->subject);
    }

    public function drop(int $count): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Drop())()($count)], $this->subject);
    }

    public function dropWhile(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\DropWhile())()(...$callbacks)], $this->subject);
    }

    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Dump())()($name)($size)($closure)], $this->subject);
    }

    public function duplicate(?callable $comparatorCallback = null, ?callable $accessorCallback = null): CollectionInterface
    {
        $accessorCallback ??=
            /**
             * @param T $value
             *
             * @return T
             */
            static fn(mixed $value): mixed => $value;

        $comparatorCallback ??=
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn(mixed $left): Closure =>
            /**
             * @param T $right
             */
            static fn(mixed $right): bool => $left === $right;

        return new self([...$this->pipe, (new Operation\Duplicate())()($comparatorCallback)($accessorCallback)], $this->subject);
    }

    /**
     * @template UKey
     * @template U
     *
     * @return CollectionInterface<UKey, U>&self<UKey, U>
     */
    public static function empty(): CollectionInterface
    {
        return self::fromIterable([]);
    }

    public function entropy(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Entropy())()], $this->subject);
    }

    public function equals(iterable $other): bool
    {
        return (new self([...$this->pipe, (new Operation\Equals())()($other)], $this->subject))->current();
    }

    public function every(callable ...$callbacks): bool
    {
        return (new self([...$this->pipe, (new Operation\Every())()(static fn(int $index, mixed $value, mixed $key, iterable $iterable): bool => CallbacksArrayReducer::or()($callbacks)($value, $key, $iterable))], $this->subject))->current();
    }

    public function explode(mixed ...$explodes): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Explode())()($explodes)], $this->subject);
    }

    public function falsy(): bool
    {
        return (new self([...$this->pipe, (new Operation\Falsy())()], $this->subject))->current();
    }

    public function filter(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Filter())()(...$callbacks)], $this->subject);
    }

    public function find(mixed $default = null, callable ...$callbacks)
    {
        return (new self([...$this->pipe, (new Operation\Find())()($default)(...$callbacks)], $this->subject))->current();
    }

    public function first(mixed $default = null)
    {
        return (new self([...$this->pipe, (new Operation\First())()], $this->subject))->current(0, $default);
    }

    public function flatMap(callable $callback): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\FlatMap())()($callback)], $this->subject);
    }

    public function flatten(int $depth = PHP_INT_MAX): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Flatten())()($depth)], $this->subject);
    }

    public function flip(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Flip())()], $this->subject);
    }

    public function foldLeft(callable $callback, mixed $initial)
    {
        return (new self([...$this->pipe, (new Operation\FoldLeft())()($callback)($initial)], $this->subject))->current();
    }

    public function foldLeft1(callable $callback): mixed
    {
        return (new self([...$this->pipe, (new Operation\FoldLeft1())()($callback)], $this->subject))->current();
    }

    public function foldRight(callable $callback, mixed $initial): mixed
    {
        return (new self([...$this->pipe, (new Operation\FoldRight())()($callback)($initial)], $this->subject))->current();
    }

    public function foldRight1(callable $callback): mixed
    {
        return (new self([...$this->pipe, (new Operation\FoldRight1())()($callback)], $this->subject))->current();
    }

    public function forget(mixed ...$keys): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Forget())()($keys)], $this->subject);
    }

    public function frequency(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Frequency())()], $this->subject);
    }

    /**
     * @template NewTKey
     * @template NewT
     *
     * @param callable(mixed ...$parameters): iterable<NewTKey, NewT> $callable
     * @param iterable<int, mixed> $parameters
     *
     * @return CollectionInterface<NewTKey, NewT>&self<NewTKey, NewT>
     */
    public static function fromCallable(callable $callable, iterable $parameters = []): CollectionInterface
    {
        return new self([static fn(): iterable => $callable(...$parameters)]);
    }

    /**
     * @param Closure(resource): mixed $consumer
     *
     * @return CollectionInterface<int, string|mixed>&self<int, string|mixed>
     */
    public static function fromFile(string $filepath, ?Closure $consumer = null): CollectionInterface
    {
        return new self(
            [static fn(): Generator => yield from new ResourceIteratorAggregate(fopen($filepath, 'rb'), true, $consumer)],
        );
    }

    /**
     * @template NewTKey
     * @template NewT
     *
     * @param Generator<NewTKey, NewT> $generator
     *
     * @return CollectionInterface<NewTKey, NewT>&self<NewTKey, NewT>
     */
    public static function fromGenerator(Generator $generator): CollectionInterface
    {
        return new self([static fn(): Generator => yield from new NoRewindIterator($generator)]);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> $iterable
     *
     * @return CollectionInterface<UKey, U>&self<UKey, U>
     */
    public static function fromIterable(iterable $iterable): CollectionInterface
    {
        return new self([], $iterable);
    }

    /**
     * @param resource $resource
     *
     * @return CollectionInterface<int, string>&self<int, string>
     */
    public static function fromResource($resource): CollectionInterface
    {
        return new self([static fn(): Generator => yield from new ResourceIteratorAggregate($resource)]);
    }

    /**
     * @return CollectionInterface<int, string>&self<int, string>
     */
    public static function fromString(string $string, string $delimiter = ''): CollectionInterface
    {
        return new self([static fn(): Generator => yield from new StringIteratorAggregate($string, $delimiter)]);
    }

    public function get(mixed $key, mixed $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Get())()($key)($default)], $this->subject))->current();
    }

    /**
     * @return Traversable<TKey, T>
     */
    public function getIterator(): Traversable
    {
        yield from (new Pipe)()(...$this->pipe)($this->subject);
    }

    public function group(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Group())()], $this->subject);
    }

    public function groupBy(callable $callback): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\GroupBy())()($callback)], $this->subject);
    }

    public function has(callable ...$callbacks): bool
    {
        return (new self([...$this->pipe, (new Operation\Has())()(...$callbacks)], $this->subject))->current();
    }

    public function head(mixed $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Head())()], $this->subject))->current(0, $default);
    }

    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): CollectionInterface
    {
        $identity =
            /**
             * @param T $value
             *
             * @return T
             */
            static fn(mixed $value): mixed => $value;

        return new self([...$this->pipe, (new Operation\IfThenElse())()($condition)($then)($else ?? $identity)], $this->subject);
    }

    public function implode(string $glue = ''): string
    {
        return (new self([...$this->pipe, (new Operation\Implode())()($glue)], $this->subject))->current(0, '');
    }

    public function init(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Init())()], $this->subject);
    }

    public function inits(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Inits())()], $this->subject);
    }

    public function intersect(mixed ...$values): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Intersect())()($values)], $this->subject);
    }

    public function intersectKeys(mixed ...$keys): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\IntersectKeys())()($keys)], $this->subject);
    }

    public function intersperse(mixed $element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Intersperse())()($element)($every)($startAt)], $this->subject);
    }

    public function isEmpty(): bool
    {
        return (new self([...$this->pipe, (new Operation\IsEmpty())()], $this->subject))->current();
    }

    public function isNotEmpty(): bool
    {
        return (new self([...$this->pipe, (new Operation\IsNotEmpty())()], $this->subject))->current();
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
        return (new self([...$this->pipe, (new Operation\Key())()($index)], $this->subject))->current();
    }

    public function keys(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Keys())()], $this->subject);
    }

    public function last(mixed $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Last())()], $this->subject))->current(0, $default);
    }

    public function limit(int $count = -1, int $offset = 0): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Limit())()($count)($offset)], $this->subject);
    }

    public function lines(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Lines())()], $this->subject);
    }

    public function map(callable $callback): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Map())()($callback)], $this->subject);
    }

    public function mapN(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\MapN())()(...$callbacks)], $this->subject);
    }

    public function match(callable $callback, ?callable $matcher = null): bool
    {
        return (new self([...$this->pipe, (new Operation\MatchOne())()($matcher ?? static fn(): bool => true)($callback)], $this->subject))->current();
    }

    public function matching(Criteria $criteria): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Matching())()($criteria)], $this->subject);
    }

    public function max(mixed $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Max())()], $this->subject))->current(0, $default);
    }

    public function merge(iterable ...$sources): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Merge())()(...$sources)], $this->subject);
    }

    public function min(mixed $default = null)
    {
        return (new self([...$this->pipe, (new Operation\Min())()], $this->subject))->current(0, $default);
    }

    public function normalize(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Normalize())()], $this->subject);
    }

    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Nth())()($step)($offset)], $this->subject);
    }

    public function nullsy(): bool
    {
        return (new self([...$this->pipe, (new Operation\Nullsy())()], $this->subject))->current();
    }

    public function pack(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Pack())()], $this->subject);
    }

    public function pad(int $size, mixed $value): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Pad())()($size)($value)], $this->subject);
    }

    public function pair(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Pair())()], $this->subject);
    }

    public function partition(callable ...$callbacks): CollectionInterface
    {
        $map =
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Collection<TKey, T>
             */
            static fn(iterable $iterable): Collection => Collection::fromIterable($iterable);

        return new self([...$this->pipe, (new Operation\Partition())()(...$callbacks), (new Operation\Map())()($map)], $this->subject);
    }

    public function permutate(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Permutate())()], $this->subject);
    }

    public function pipe(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Pipe())()(...$callbacks)], $this->subject);
    }

    public function pluck(mixed $pluck, mixed $default = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Pluck())()($pluck)($default)], $this->subject);
    }

    public function prepend(mixed ...$items): CollectionInterface
    {
        return new self([...$this->pipe,  (new Operation\Prepend())()($items)], $this->subject);
    }

    public function product(iterable ...$iterables): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Product())()(...$iterables)], $this->subject);
    }

    public function random(int $size = 1, ?int $seed = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Random())()($seed ?? random_int(0, 1000))($size)], $this->subject);
    }

    /**
     * @return self<int, float>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return new self([(new Operation\Range())()($start)($end)($step)]);
    }

    public function reduce(callable $callback, mixed $initial = null)
    {
        return (new self([...$this->pipe, (new Operation\Reduce())()($callback)($initial)], $this->subject))->current();
    }

    public function reduction(callable $callback, mixed $initial = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Reduction())()($callback)($initial)], $this->subject);
    }

    public function reject(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Reject())()(...$callbacks)], $this->subject);
    }

    public function reverse(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Reverse())()], $this->subject);
    }

    public function rsample(float $probability): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\RSample())()($probability)], $this->subject);
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
            static fn(mixed $leftValue, mixed $leftKey): Closure =>
            /**
             * @param T $rightValue
             * @param TKey $rightKey
             */
            static fn(mixed $rightValue, mixed $rightKey): bool => $leftValue === $rightValue && $leftKey === $rightKey;

        return (new self([...$this->pipe, (new Operation\Same())()($other)($comparatorCallback)], $this->subject))->current();
    }

    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): CollectionInterface {
        return new self([...$this->pipe, (new Operation\Scale())()($lowerBound)($upperBound)($wantedLowerBound)($wantedUpperBound)($base)], $this->subject);
    }

    public function scanLeft(callable $callback, mixed $initial): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\ScanLeft())()($callback)($initial)], $this->subject);
    }

    public function scanLeft1(callable $callback): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\ScanLeft1())()($callback)], $this->subject);
    }

    public function scanRight(callable $callback, mixed $initial): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\ScanRight())()($callback)($initial)], $this->subject);
    }

    public function scanRight1(callable $callback): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\ScanRight1())()($callback)], $this->subject);
    }

    public function shuffle(?int $seed = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Shuffle())()($seed ?? random_int(0, 1000))], $this->subject);
    }

    public function since(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Since())()(...$callbacks)], $this->subject);
    }

    public function slice(int $offset, int $length = -1): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Slice())()($offset)($length)], $this->subject);
    }

    public function sort(int $type = OperationInterface\Sortable::BY_VALUES, null|callable|Closure $callback = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Sort())()($type)($callback)], $this->subject);
    }

    public function span(callable ...$callbacks): CollectionInterface
    {
        $map =
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Collection<TKey, T>
             */
            static fn(iterable $iterable): Collection => Collection::fromIterable($iterable);

        return new self([...$this->pipe, (new Operation\Span())()(...$callbacks), (new Operation\Map())()($map)], $this->subject);
    }

    public function split(int $type = OperationInterface\Splitable::BEFORE, callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Split())()($type)(...$callbacks)], $this->subject);
    }

    public function squash(): CollectionInterface
    {
        return self::fromIterable($this->pack()->all(false))->unpack();
    }

    public function strict(?callable $callback = null): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Strict())()($callback)], $this->subject);
    }

    public function tail(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Tail())()], $this->subject);
    }

    public function tails(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Tails())()], $this->subject);
    }

    public function takeWhile(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\TakeWhile())()(...$callbacks)], $this->subject);
    }

    public function tap(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Tap())()(...$callbacks)], $this->subject);
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
        return new self([(new Operation\Times())()($number)($callback)]);
    }

    public function transpose(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Transpose())()], $this->subject);
    }

    public function truthy(): bool
    {
        return (new self([...$this->pipe, (new Operation\Truthy())()], $this->subject))->current();
    }

    public static function unfold(callable $callback, iterable $parameters = []): CollectionInterface
    {
        return new self([(new Operation\Unfold())()($parameters)($callback)]);
    }

    public function unlines(): string
    {
        return (new self([...$this->pipe, (new Operation\Unlines())()], $this->subject))->current(0, '');
    }

    public function unpack(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Unpack())()], $this->subject);
    }

    public function unpair(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Unpair())()], $this->subject);
    }

    public function until(callable ...$callbacks): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Until())()(...$callbacks)], $this->subject);
    }

    public function unwindow(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Unwindow())()], $this->subject);
    }

    public function unwords(): string
    {
        return (new self([...$this->pipe, (new Operation\Unwords())()], $this->subject))->current(0, '');
    }

    public function unwrap(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Unwrap())()], $this->subject);
    }

    public function unzip(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Unzip())()], $this->subject);
    }

    public function when(callable $predicate, callable $whenTrue, ?callable $whenFalse = null): CollectionInterface
    {
        $whenFalse ??=
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return iterable<TKey, T>
             */
            static fn(iterable $iterable): iterable => $iterable;

        return new self([...$this->pipe, (new Operation\When())()($predicate)($whenTrue)($whenFalse)], $this->subject);
    }

    public function window(int $size): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Window())()($size)], $this->subject);
    }

    public function words(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Words())()], $this->subject);
    }

    public function wrap(): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Wrap())()], $this->subject);
    }

    public function zip(iterable ...$iterables): CollectionInterface
    {
        return new self([...$this->pipe, (new Operation\Zip())()(...$iterables)], $this->subject);
    }
}
