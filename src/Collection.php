<?php

declare(strict_types=1);

namespace loophp\collection;

use Generator;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\Range;
use loophp\collection\Operation\Times;
use loophp\collection\Operation\Unfold;
use loophp\iterators\ClosureIteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\ResourceIteratorAggregate;
use loophp\iterators\StringIteratorAggregate;
use NoRewindIterator;
use Traversable;

use const INF;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 *
 * @extends \loophp\collection\AbstractCollection<TKey, T>
 */
final class Collection extends AbstractCollection
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

    /**
     * @template UKey
     * @template U
     *
     * @return self<UKey, U>
     */
    public static function empty(): CollectionInterface
    {
        return new self(static fn (): Generator => yield from []);
    }

    /**
     * @template UKey
     * @template U
     *
     * @param callable(mixed ...$parameters): iterable<UKey, U> $callable
     * @param iterable<int, mixed> $parameters
     *
     * @return self<UKey, U>
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
     * @template UKey
     * @template U
     *
     * @return self<UKey, U>
     */
    public static function fromGenerator(Generator $generator): self
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

    /**
     * @return Traversable<TKey, T>
     */
    public function getIterator(): Traversable
    {
        yield from $this->innerIterator->getIterator();
    }

    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return new self((new Range())()($start)($end)($step));
    }

    public static function times(int $number = 0, ?callable $callback = null): CollectionInterface
    {
        return new self((new Times())()($number)($callback));
    }

    public static function unfold(callable $callback, ...$parameters): CollectionInterface
    {
        return new self((new Unfold())()(...$parameters)($callback));
    }
}
