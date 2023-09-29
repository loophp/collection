<?php

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Doctrine\Common\Collections\Criteria;
use Generator;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Contract\Operation;
use Psr\Cache\CacheItemPoolInterface;
use Traversable;

use const INF;
use const PHP_INT_MAX;

/**
 * @template TKey
 * @template T
 *
 * @immutable
 *
 * @psalm-consistent-constructor
 *
 * @psalm-consistent-templates
 *
 * @implements \loophp\collection\Contract\Collection<TKey, T>
 */
abstract class CollectionDecorator implements CollectionInterface
{
    /**
     * @param CollectionInterface<TKey, T> $innerCollection
     */
    public function __construct(protected CollectionInterface $innerCollection) {}

    public function all(bool $normalize = true): array
    {
        return $this->innerCollection->all($normalize);
    }

    public function append(mixed ...$items): static
    {
        return new static($this->innerCollection->append(...$items));
    }

    public function apply(callable ...$callbacks): static
    {
        return new static($this->innerCollection->apply(...$callbacks));
    }

    public function associate(
        ?callable $callbackForKeys = null,
        ?callable $callbackForValues = null
    ): static {
        return new static($this->innerCollection->associate($callbackForKeys, $callbackForValues));
    }

    public function asyncMap(callable $callback): static
    {
        return new static($this->innerCollection->asyncMap($callback));
    }

    public function asyncMapN(callable ...$callbacks): static
    {
        return new static($this->innerCollection->asyncMapN(...$callbacks));
    }

    public function averages(): static
    {
        return new static($this->innerCollection->averages());
    }

    public function cache(?CacheItemPoolInterface $cache = null): static
    {
        return new static($this->innerCollection->cache($cache));
    }

    public function chunk(int ...$sizes): static
    {
        return new static($this->innerCollection->chunk(...$sizes));
    }

    public function coalesce(): static
    {
        return new static($this->innerCollection->coalesce());
    }

    public function collapse(): static
    {
        return new static($this->innerCollection->collapse());
    }

    public function column(mixed $column): static
    {
        return new static($this->innerCollection->column($column));
    }

    public function combinate(?int $length = null): static
    {
        return new static($this->innerCollection->combinate($length));
    }

    public function combine(mixed ...$keys): static
    {
        return new static($this->innerCollection->combine(...$keys));
    }

    public function compact(mixed ...$values): static
    {
        return new static($this->innerCollection->compact(...$values));
    }

    public function compare(callable $comparator, $default = null): mixed
    {
        return $this->innerCollection->compare($comparator, $default);
    }

    public function contains(mixed ...$values): bool
    {
        return $this->innerCollection->contains(...$values);
    }

    public function countIn(int &$counter): CollectionInterface
    {
        $this->innerCollection->countIn($counter);

        return $this;
    }

    public function current(int $index = 0, $default = null): mixed
    {
        return $this->innerCollection->current($index, $default);
    }

    public function cycle(): static
    {
        return new static($this->innerCollection->cycle());
    }

    public function diff(mixed ...$values): static
    {
        return new static($this->innerCollection->diff(...$values));
    }

    public function diffKeys(mixed ...$keys): static
    {
        return new static($this->innerCollection->diffKeys(...$keys));
    }

    public function distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): static
    {
        return new static($this->innerCollection->distinct($comparatorCallback, $accessorCallback));
    }

    public function drop(int $count): static
    {
        return new static($this->innerCollection->drop($count));
    }

    public function dropWhile(callable ...$callbacks): static
    {
        return new static($this->innerCollection->dropWhile(...$callbacks));
    }

    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): static
    {
        return new static($this->innerCollection->dump($name, $size, $closure));
    }

    public function duplicate(?callable $comparatorCallback = null, ?callable $accessorCallback = null): static
    {
        return new static($this->innerCollection->duplicate($comparatorCallback, $accessorCallback));
    }

    public static function empty(): static
    {
        return new static(Collection::empty());
    }

    public function equals(iterable $other): bool
    {
        return $this->innerCollection->equals($other);
    }

    public function every(callable ...$callbacks): bool
    {
        return $this->innerCollection->every(...$callbacks);
    }

    public function explode(mixed ...$explodes): static
    {
        return new static($this->innerCollection->explode(...$explodes));
    }

    public function falsy(): bool
    {
        return $this->innerCollection->falsy();
    }

    public function filter(callable ...$callbacks): static
    {
        return new static($this->innerCollection->filter(...$callbacks));
    }

    public function find($default = null, callable ...$callbacks): mixed
    {
        return $this->innerCollection->find($default, ...$callbacks);
    }

    public function first($default = null): mixed
    {
        return $this->innerCollection->first($default);
    }

    public function flatMap(callable $callback): static
    {
        return new static($this->innerCollection->flatMap($callback));
    }

    public function flatten(int $depth = PHP_INT_MAX): static
    {
        return new static($this->innerCollection->flatten($depth));
    }

    public function flip(): static
    {
        return new static($this->innerCollection->flip());
    }

    public function foldLeft(callable $callback, $initial): mixed
    {
        return $this->innerCollection->foldLeft($callback, $initial);
    }

    public function foldLeft1(callable $callback): mixed
    {
        return $this->innerCollection->foldLeft1($callback);
    }

    public function foldRight(callable $callback, $initial): mixed
    {
        return $this->innerCollection->foldRight($callback, $initial);
    }

    public function foldRight1(callable $callback): mixed
    {
        return $this->innerCollection->foldRight1($callback);
    }

    public function forget(mixed ...$keys): static
    {
        return new static($this->innerCollection->forget(...$keys));
    }

    public function frequency(): static
    {
        return new static($this->innerCollection->frequency());
    }

    /**
     * @template UKey
     * @template U
     *
     * @param callable(mixed ...$parameters): iterable<UKey, U> $callable
     * @param iterable<int, mixed> $parameters
     *
     * @return static<UKey, U>
     */
    public static function fromCallable(callable $callable, iterable $parameters = []): static
    {
        return new static(Collection::fromCallable($callable, $parameters));
    }

    /**
     * @param null|non-negative-int $length
     */
    public static function fromFile(string $filepath, ?int $length = 2): static
    {
        return new static(Collection::fromFile($filepath, $length));
    }

    public static function fromGenerator(Generator $generator): static
    {
        return new static(Collection::fromGenerator($generator));
    }

    /**
     * @template UKey
     * @template U
     *
     * @param iterable<UKey, U> $iterable
     *
     * @return static<UKey, U>
     */
    public static function fromIterable(iterable $iterable): static
    {
        return new static(Collection::fromIterable($iterable));
    }

    /**
     * @param resource $resource
     *
     * @return static<int, string>
     */
    public static function fromResource($resource): static
    {
        return new static(Collection::fromResource($resource));
    }

    public static function fromString(string $string, string $delimiter = ''): static
    {
        return new static(Collection::fromString($string, $delimiter));
    }

    public function get(mixed $key, $default = null): mixed
    {
        return $this->innerCollection->get($key, $default);
    }

    /**
     * @return Traversable<TKey, T>
     */
    public function getIterator(): Traversable
    {
        yield from $this->innerCollection->getIterator();
    }

    public function group(): static
    {
        return new static($this->innerCollection->group());
    }

    public function groupBy(callable $callback): static
    {
        return new static($this->innerCollection->groupBy($callback));
    }

    public function has(callable ...$callbacks): bool
    {
        return $this->innerCollection->has(...$callbacks);
    }

    public function head($default = null): mixed
    {
        return $this->innerCollection->head($default);
    }

    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): static
    {
        return new static($this->innerCollection->ifThenElse($condition, $then, $else));
    }

    public function implode(string $glue = ''): string
    {
        return $this->innerCollection->implode($glue);
    }

    public function init(): static
    {
        return new static($this->innerCollection->init());
    }

    public function inits(): static
    {
        return new static($this->innerCollection->inits());
    }

    public function intersect(mixed ...$values): static
    {
        return new static($this->innerCollection->intersect(...$values));
    }

    public function intersectKeys(mixed ...$keys): static
    {
        return new static($this->innerCollection->intersectKeys(...$keys));
    }

    public function intersperse(mixed $element, int $every = 1, int $startAt = 0): static
    {
        return new static($this->innerCollection->intersperse($element, $every, $startAt));
    }

    public function isEmpty(): bool
    {
        return $this->innerCollection->isEmpty();
    }

    public function isNotEmpty(): bool
    {
        return $this->innerCollection->isNotEmpty();
    }

    public function key(int $index = 0): mixed
    {
        return $this->innerCollection->key($index);
    }

    public function keys(): static
    {
        return new static($this->innerCollection->keys());
    }

    public function last($default = null): mixed
    {
        return $this->innerCollection->last($default);
    }

    public function limit(int $count = -1, int $offset = 0): static
    {
        return new static($this->innerCollection->limit($count, $offset));
    }

    public function lines(): static
    {
        return new static($this->innerCollection->lines());
    }

    public function map(callable $callback): static
    {
        return new static($this->innerCollection->map($callback));
    }

    public function mapN(callable ...$callbacks): static
    {
        return new static($this->innerCollection->mapN(...$callbacks));
    }

    public function match(callable $callback, ?callable $matcher = null): bool
    {
        return $this->innerCollection->match($callback, $matcher);
    }

    public function matching(Criteria $criteria): static
    {
        return new static($this->innerCollection->matching($criteria));
    }

    public function max($default = null): mixed
    {
        return $this->innerCollection->max($default);
    }

    public function merge(iterable ...$sources): static
    {
        return new static($this->innerCollection->merge(...$sources));
    }

    public function min($default = null): mixed
    {
        return $this->innerCollection->min($default);
    }

    public function normalize(): static
    {
        return new static($this->innerCollection->normalize());
    }

    public function nth(int $step, int $offset = 0): static
    {
        return new static($this->innerCollection->nth($step, $offset));
    }

    public function nullsy(): bool
    {
        return $this->innerCollection->nullsy();
    }

    public function pack(): static
    {
        return new static($this->innerCollection->pack());
    }

    public function pad(int $size, mixed $value): static
    {
        return new static($this->innerCollection->pad($size, $value));
    }

    public function pair(): static
    {
        return new static($this->innerCollection->pair());
    }

    public function partition(callable ...$callbacks): static
    {
        return new static($this->innerCollection->partition(...$callbacks));
    }

    public function permutate(): static
    {
        return new static($this->innerCollection->permutate());
    }

    public function pipe(callable ...$callbacks): static
    {
        return new static($this->innerCollection->pipe(...$callbacks));
    }

    public function pluck(mixed $pluck, mixed $default = null): static
    {
        return new static($this->innerCollection->pluck($pluck, $default));
    }

    public function prepend(mixed ...$items): static
    {
        return new static($this->innerCollection->prepend(...$items));
    }

    public function product(iterable ...$iterables): static
    {
        return new static($this->innerCollection->product(...$iterables));
    }

    public function random(int $size = 1, ?int $seed = null): static
    {
        return new static($this->innerCollection->random($size, $seed));
    }

    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return new static(Collection::range($start, $end, $step));
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return $this->innerCollection->reduce($callback, $initial);
    }

    public function reduction(callable $callback, mixed $initial = null): static
    {
        return new static($this->innerCollection->reduction($callback, $initial));
    }

    public function reject(callable ...$callbacks): static
    {
        return new static($this->innerCollection->reject(...$callbacks));
    }

    public function reverse(): static
    {
        return new static($this->innerCollection->reverse());
    }

    public function rsample(float $probability): static
    {
        return new static($this->innerCollection->rsample($probability));
    }

    public function same(iterable $other, ?callable $comparatorCallback = null): bool
    {
        return $this->innerCollection->same($other, $comparatorCallback);
    }

    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): static {
        return new static($this->innerCollection->scale($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound));
    }

    public function scanLeft(callable $callback, mixed $initial): static
    {
        return new static($this->innerCollection->scanLeft($callback, $initial));
    }

    public function scanLeft1(callable $callback): static
    {
        return new static($this->innerCollection->scanLeft1($callback));
    }

    public function scanRight(callable $callback, mixed $initial): static
    {
        return new static($this->innerCollection->scanRight($callback, $initial));
    }

    public function scanRight1(callable $callback): static
    {
        return new static($this->innerCollection->scanRight1($callback));
    }

    public function shuffle(?int $seed = null): static
    {
        return new static($this->innerCollection->shuffle($seed));
    }

    public function since(callable ...$callbacks): static
    {
        return new static($this->innerCollection->since(...$callbacks));
    }

    public function slice(int $offset, int $length = -1): static
    {
        return new static($this->innerCollection->slice($offset, $length));
    }

    public function sort(int $type = Operation\Sortable::BY_VALUES, ?callable $callback = null): static
    {
        return new static($this->innerCollection->sort($type, $callback));
    }

    public function span(callable ...$callbacks): static
    {
        return new static($this->innerCollection->span(...$callbacks));
    }

    public function split(int $type = Operation\Splitable::BEFORE, callable ...$callbacks): static
    {
        return new static($this->innerCollection->split($type, ...$callbacks));
    }

    public function squash(): static
    {
        return new static($this->innerCollection->squash());
    }

    public function strict(?callable $callback = null): static
    {
        return new static($this->innerCollection->strict($callback));
    }

    public function tail(): static
    {
        return new static($this->innerCollection->tail());
    }

    public function tails(): static
    {
        return new static($this->innerCollection->tails());
    }

    public function takeWhile(callable ...$callbacks): static
    {
        return new static($this->innerCollection->takeWhile(...$callbacks));
    }

    public static function times(int $number = 0, ?callable $callback = null): static
    {
        return new static(Collection::times($number, $callback));
    }

    public function transpose(): static
    {
        return new static($this->innerCollection->transpose());
    }

    public function truthy(): bool
    {
        return $this->innerCollection->truthy();
    }

    public static function unfold(callable $callback, iterable $parameters = []): static
    {
        return new static(Collection::unfold($callback, $parameters));
    }

    public function unlines(): string
    {
        return $this->innerCollection->unlines();
    }

    public function unpack(): static
    {
        return new static($this->innerCollection->unpack());
    }

    public function unpair(): static
    {
        return new static($this->innerCollection->unpair());
    }

    public function until(callable ...$callbacks): static
    {
        return new static($this->innerCollection->until(...$callbacks));
    }

    public function unwindow(): static
    {
        return new static($this->innerCollection->unwindow());
    }

    public function unwords(): string
    {
        return $this->innerCollection->unwords();
    }

    public function unwrap(): static
    {
        return new static($this->innerCollection->unwrap());
    }

    public function unzip(): static
    {
        return new static($this->innerCollection->unzip());
    }

    public function when(callable $predicate, callable $whenTrue, ?callable $whenFalse = null): static
    {
        return new static($this->innerCollection->when($predicate, $whenTrue, $whenFalse));
    }

    public function window(int $size): static
    {
        return new static($this->innerCollection->window($size));
    }

    public function words(): static
    {
        return new static($this->innerCollection->words());
    }

    public function wrap(): static
    {
        return new static($this->innerCollection->wrap());
    }

    public function zip(iterable ...$iterables): static
    {
        return new static($this->innerCollection->zip(...$iterables));
    }
}
