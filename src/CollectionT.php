<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Iterator;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Contract\CollectionT as CollectionTInterface;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Iterator\ResourceIterator;
use loophp\collection\Iterator\StringIterator;
use loophp\collection\Operation\Append;
use loophp\collection\Operation\Apply;
use loophp\collection\Operation\Associate;
use loophp\collection\Operation\AsyncMap;
use loophp\collection\Operation\Cache;
use loophp\collection\Operation\Chunk;
use loophp\collection\Operation\Coalesce;
use loophp\collection\Operation\Collapse;
use loophp\collection\Operation\Column;
use loophp\collection\Operation\Combinate;
use loophp\collection\Operation\Combine;
use loophp\collection\Operation\Compact;
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
use loophp\collection\Operation\Every;
use loophp\collection\Operation\Explode;
use loophp\collection\Operation\Falsy;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\First;
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
use loophp\collection\Operation\Key;
use loophp\collection\Operation\Keys;
use loophp\collection\Operation\Last;
use loophp\collection\Operation\Limit;
use loophp\collection\Operation\Lines;
use loophp\collection\Operation\Map;
use loophp\collection\Operation\MatchOne;
use loophp\collection\Operation\Merge;
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
use loophp\collection\Operation\Reduction;
use loophp\collection\Operation\Reverse;
use loophp\collection\Operation\RSample;
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
use loophp\collection\Operation\Window;
use loophp\collection\Operation\Words;
use loophp\collection\Operation\Wrap;
use loophp\collection\Operation\Zip;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

use const INF;
use const PHP_INT_MAX;
use const PHP_INT_MIN;

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

    /**
     * @template NewTKey of array-key
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
     * Create a new instance with no items.
     *
     * @template NewTKey of array-key
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
     * @template NewTKey of array-key
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
