<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection;

use Iterator;
use loophp\collection\Contract\CollectionT as CollectionTInterface;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Iterator\ResourceIterator;
use loophp\collection\Iterator\StringIterator;
use loophp\collection\Operation\Append;

/**
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 *
 * @implements CollectionTInterface<TKey, T>
 */
final class CollectionT implements CollectionTInterface
{
    /**
     * @var array<int, mixed>
     */
    private array $parameters;

    /**
     * @var callable(mixed ...$parameters): iterable<TKey, T>
     */
    private $source;

    /**
     * @param callable(mixed ...$parameters): iterable<TKey, T> $callable
     * @param mixed ...$parameters
     */
    public function __construct(callable $callable, ...$parameters)
    {
        $this->source = $callable;
        $this->parameters = $parameters;
    }

    public function all(): array
    {
        return iterator_to_array($this->getIterator());
    }

    public function append(...$items): CollectionTInterface
    {
        return new self(Append::of()(...$items), $this->getIterator());
    }

    /**
     * Create a new instance with no items.
     *
     * @template NewTKey
     * @template NewT
     *
     * @return self<NewTKey, NewT>
     */
    public static function empty(): self
    {
        /** @var array<NewTKey, NewT> $emptyArray */
        $emptyArray = [];

        return self::fromIterable($emptyArray);
    }

    /**
     * @template NewTKey
     * @template NewT
     *
     * @param callable(mixed ...$parameters): iterable<NewTKey, NewT> $callable
     * @param mixed ...$parameters
     *
     * @return self<NewTKey, NewT>
     */
    public static function fromCallable(callable $callable, ...$parameters): self
    {
        return new self($callable, ...$parameters);
    }

    /**
     * @return self<int, string>
     */
    public static function fromFile(string $filepath): self
    {
        return new self(
            static fn (string $filepath): Iterator => new ResourceIterator(fopen($filepath, 'rb'), true),
            $filepath
        );
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
        return new self(
            static fn (iterable $iterable): Iterator => new IterableIterator($iterable),
            $iterable
        );
    }

    /**
     * @param resource $resource
     *
     * @return self<int, string>
     */
    public static function fromResource($resource): self
    {
        return new self(
            /**
             * @param resource $resource
             */
            static fn ($resource): Iterator => new ResourceIterator($resource),
            $resource
        );
    }

    /**
     * @return self<int, string>
     */
    public static function fromString(string $string, string $delimiter = ''): self
    {
        return new self(
            static fn (string $string, string $delimiter): Iterator => new StringIterator($string, $delimiter),
            $string,
            $delimiter
        );
    }

    /**
     * @return Iterator<TKey, T>
     */
    public function getIterator(): Iterator
    {
        return new ClosureIterator($this->source, ...$this->parameters);
    }
}
