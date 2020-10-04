<?php

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Generator;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Iterator\ResourceIterator;
use loophp\collection\Iterator\StringIterator;
use loophp\collection\Operation\Append;
use loophp\collection\Operation\Apply;
use loophp\collection\Operation\Associate;
use loophp\collection\Operation\Cache;
use loophp\collection\Operation\Chunk;
use loophp\collection\Operation\Collapse;
use loophp\collection\Operation\Column;
use loophp\collection\Operation\Combinate;
use loophp\collection\Operation\Combine;
use loophp\collection\Operation\Compact;
use loophp\collection\Operation\Compose;
use loophp\collection\Operation\Contains;
use loophp\collection\Operation\Current;
use loophp\collection\Operation\Cycle;
use loophp\collection\Operation\Diff;
use loophp\collection\Operation\DiffKeys;
use loophp\collection\Operation\Distinct;
use loophp\collection\Operation\Drop;
use loophp\collection\Operation\DropWhile;
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
use loophp\collection\Operation\Merge;
use loophp\collection\Operation\Normalize;
use loophp\collection\Operation\Nth;
use loophp\collection\Operation\Nullsy;
use loophp\collection\Operation\Pack;
use loophp\collection\Operation\Pad;
use loophp\collection\Operation\Pair;
use loophp\collection\Operation\Permutate;
use loophp\collection\Operation\Pluck;
use loophp\collection\Operation\Prepend;
use loophp\collection\Operation\Product;
use loophp\collection\Operation\Random;
use loophp\collection\Operation\Range;
use loophp\collection\Operation\Reduce;
use loophp\collection\Operation\Reduction;
use loophp\collection\Operation\Reverse;
use loophp\collection\Operation\RSample;
use loophp\collection\Operation\Run;
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

use function is_callable;
use function is_resource;
use function is_string;

use const INF;
use const PHP_INT_MAX;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements \loophp\collection\Contract\Collection<TKey, T>
 */
final class Collection implements CollectionInterface
{
    /**
     * @var mixed[]
     * @psalm-var array<int, Closure|callable|iterable|mixed|resource|scalar|T>
     */
    private $parameters;

    /**
     * @var Closure
     * @psalm-var Closure((Closure|callable|iterable|mixed|resource|scalar|T)...):Generator
     */
    private $source;

    /**
     * @param callable|Closure|iterable|mixed|resource|scalar $data
     * @param callable|Closure|iterable|mixed|resource|scalar|T ...$parameters
     */
    public function __construct($data = [], ...$parameters)
    {
        switch (true) {
            case is_resource($data) && 'stream' === get_resource_type($data):
                $this->source =
                    /**
                     * @psalm-param resource $data
                     *
                     * @param mixed $data
                     */
                    static function ($data): Generator {
                        while (false !== $chunk = fgetc($data)) {
                            yield $chunk;
                        }
                    };
                $this->parameters = [
                    $data,
                ];

                break;
            case is_callable($data):
                $this->source =
                    /**
                     * @psalm-var callable(mixed...):(T)
                     * @psalm-var array<int, mixed>
                     */
                    static function (callable $data, array $parameters): Generator {
                        return yield from $data(...$parameters);
                    };
                $this->parameters = [
                    $data,
                    $parameters,
                ];

                break;
            case is_iterable($data):
                $this->source = static function (iterable $data): Generator {
                    foreach ($data as $key => $value) {
                        yield $key => $value;
                    }
                };
                $this->parameters = [
                    $data,
                ];

                break;
            case is_string($data):
                /** @psalm-var array{scalar} $parameters */
                $parameters += [0 => null];
                $separator = (string) $parameters[0];

                $this->source = static function (string $data, string $separator): Generator {
                    $offset = 0;

                    $nextOffset = '' !== $separator ?
                        mb_strpos($data, $separator, $offset) :
                        1;

                    while (mb_strlen($data) > $offset && false !== $nextOffset) {
                        yield mb_substr($data, $offset, $nextOffset - $offset);
                        $offset = $nextOffset + mb_strlen($separator);

                        $nextOffset = '' !== $separator ?
                            mb_strpos($data, $separator, $offset) :
                            $nextOffset + 1;
                    }

                    if ('' !== $separator) {
                        yield mb_substr($data, $offset);
                    }
                };
                $this->parameters = [
                    $data,
                    $separator,
                ];

                break;

            default:
                $this->source =
                    /**
                     * @psalm-param mixed|scalar $data
                     *
                     * @param mixed $data
                     */
                    static function ($data): Generator {
                        foreach ((array) $data as $key => $value) {
                            yield $key => $value;
                        }
                    };
                $this->parameters = [
                    $data,
                ];
        }
    }

    public function all(): array
    {
        return iterator_to_array($this);
    }

    public function append(...$items): CollectionInterface
    {
        return $this->run(Append::of()(...$items));
    }

    public function apply(callable ...$callables): CollectionInterface
    {
        return $this->run(Apply::of()(...$callables));
    }

    public function associate(
        ?callable $callbackForKeys = null,
        ?callable $callbackForValues = null
    ): CollectionInterface {
        $defaultCallback =
            /**
             * @param mixed $carry
             * @psalm-param T|TKey $carry
             *
             * @param mixed $key
             * @psalm-param TKey $key
             *
             * @param mixed $value
             * @psalm-param T $value
             *
             * @psalm-return TKey|T
             */
            static function ($carry, $key, $value) {
                return $carry;
            };

        $callbackForKeys = $callbackForKeys ?? $defaultCallback;
        $callbackForValues = $callbackForValues ?? $defaultCallback;

        return $this->run(Associate::of()($callbackForKeys)($callbackForValues));
    }

    public function cache(?CacheItemPoolInterface $cache = null): CollectionInterface
    {
        return $this->run(Cache::of()($cache ?? new ArrayAdapter()));
    }

    public function chunk(int ...$sizes): CollectionInterface
    {
        return $this->run(Chunk::of()(...$sizes));
    }

    public function collapse(): CollectionInterface
    {
        return $this->run(Collapse::of());
    }

    public function column($column): CollectionInterface
    {
        return $this->run(Column::of()($column));
    }

    public function combinate(?int $length = null): CollectionInterface
    {
        return $this->run(Combinate::of()($length));
    }

    public function combine(...$keys): CollectionInterface
    {
        return $this->run(Combine::of()(...$keys));
    }

    public function compact(...$values): CollectionInterface
    {
        return $this->run(Compact::of()(...$values));
    }

    public function contains(...$value): bool
    {
        return $this->run(Contains::of()(...$value))->getIterator()->current();
    }

    public function count(): int
    {
        return iterator_count($this);
    }

    public function current(int $index = 0)
    {
        return $this->run(Current::of()($index))->getIterator()->current();
    }

    public function cycle(): CollectionInterface
    {
        return $this->run(Cycle::of());
    }

    public function diff(...$values): CollectionInterface
    {
        return $this->run(Diff::of()(...$values));
    }

    public function diffKeys(...$values): CollectionInterface
    {
        return $this->run(DiffKeys::of()(...$values));
    }

    public function distinct(): CollectionInterface
    {
        return $this->run(Distinct::of());
    }

    public function drop(int ...$counts): CollectionInterface
    {
        return $this->run(Drop::of()(...$counts));
    }

    public function dropWhile(callable $callback): CollectionInterface
    {
        return $this->run(DropWhile::of()($callback));
    }

    public function duplicate(): CollectionInterface
    {
        return $this->run(Duplicate::of());
    }

    public static function empty(): CollectionInterface
    {
        return new self();
    }

    public function every(callable $callback): CollectionInterface
    {
        return $this->run(Every::of()($callback));
    }

    public function explode(...$explodes): CollectionInterface
    {
        return $this->run(Explode::of()(...$explodes));
    }

    public function falsy(): bool
    {
        return $this->run(Falsy::of())->getIterator()->current();
    }

    public function filter(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Filter::of()(...$callbacks));
    }

    public function first(): CollectionInterface
    {
        return $this->run(First::of());
    }

    public function flatten(int $depth = PHP_INT_MAX): CollectionInterface
    {
        return $this->run(Flatten::of()($depth));
    }

    public function flip(): CollectionInterface
    {
        return $this->run(Flip::of());
    }

    public function foldLeft(callable $callback, $initial = null)
    {
        return $this->run(FoldLeft::of()($callback)($initial))->getIterator()->current();
    }

    public function foldLeft1(callable $callback)
    {
        return $this->run(FoldLeft1::of()($callback))->getIterator()->current();
    }

    public function foldRight(callable $callback, $initial = null)
    {
        return $this->run(Foldright::of()($callback)($initial))->getIterator()->current();
    }

    public function foldRight1(callable $callback)
    {
        return $this->run(FoldRight1::of()($callback))->getIterator()->current();
    }

    public function forget(...$keys): CollectionInterface
    {
        return $this->run(Forget::of()(...$keys));
    }

    public function frequency(): CollectionInterface
    {
        return $this->run(Frequency::of());
    }

    public static function fromCallable(callable $callable, ...$parameters): CollectionInterface
    {
        return new self(
            static function (callable $callable, array $parameters): Generator {
                return yield from new ClosureIterator($callable, ...$parameters);
            },
            $callable,
            $parameters
        );
    }

    public static function fromFile(string $filepath): CollectionInterface
    {
        return new self(
            static function (string $filepath): Generator {
                return yield from new ResourceIterator(fopen($filepath, 'rb'));
            },
            $filepath
        );
    }

    public static function fromIterable(iterable $iterable): CollectionInterface
    {
        return new self(
            static function (iterable $iterable): Generator {
                return yield from new IterableIterator($iterable);
            },
            $iterable
        );
    }

    public static function fromResource($resource): CollectionInterface
    {
        return new self(
            /**
             * @psalm-param resource $resource
             *
             * @param mixed $resource
             */
            static function ($resource): Generator {
                return yield from new ResourceIterator($resource);
            },
            $resource
        );
    }

    public static function fromString(string $string, string $delimiter = ''): CollectionInterface
    {
        return new self(
            /**
             * @psalm-return Generator<int, string>
             */
            static function (string $string, string $delimiter): Generator {
                return yield from new StringIterator($string, $delimiter);
            },
            $string,
            $delimiter
        );
    }

    public function get($key, $default = null)
    {
        return $this->run(Get::of()($key)($default))->getIterator()->current();
    }

    public function getIterator(): ClosureIterator
    {
        return new ClosureIterator($this->source, ...$this->parameters);
    }

    public function groupBy(?callable $callable = null): CollectionInterface
    {
        return $this->run(GroupBy::of()($callable));
    }

    public function has(callable $callback): bool
    {
        return $this->run(Has::of()($callback))->getIterator()->current();
    }

    public function head(): CollectionInterface
    {
        return $this->run(Head::of());
    }

    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): CollectionInterface
    {
        $else = $else ??
            /**
             * @psalm-param T $value
             * @psalm-param TKey $key
             *
             * @psalm-return T
             *
             * @param mixed $value
             * @param mixed $key
             */
            static function ($value, $key) {
                return $value;
            };

        return $this->run(IfThenElse::of()($condition)($then)($else));
    }

    public function implode(string $glue = ''): string
    {
        return $this->run(Implode::of()($glue))->getIterator()->current();
    }

    public function init(): CollectionInterface
    {
        return $this->run(Init::of());
    }

    public function inits(): CollectionInterface
    {
        return $this->run(Inits::of());
    }

    public function intersect(...$values): CollectionInterface
    {
        return $this->run(Intersect::of()(...$values));
    }

    public function intersectKeys(...$values): CollectionInterface
    {
        return $this->run(IntersectKeys::of()(...$values));
    }

    public function intersperse($element, int $every = 1, int $startAt = 0): CollectionInterface
    {
        return $this->run(Intersperse::of()($element)($every)($startAt));
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->all();
    }

    public function key(int $index = 0)
    {
        return $this->run(Key::of()($index))->getIterator()->current();
    }

    public function keys(): CollectionInterface
    {
        return $this->run(Keys::of());
    }

    public function last(): CollectionInterface
    {
        return $this->run(Last::of());
    }

    public function limit(int $count = -1, int $offset = 0): CollectionInterface
    {
        return $this->run(Limit::of()($count)($offset));
    }

    public function lines(): CollectionInterface
    {
        return $this->run(Lines::of());
    }

    public function map(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Map::of()(...$callbacks));
    }

    public function merge(iterable ...$sources): CollectionInterface
    {
        return $this->run(Merge::of()(...$sources));
    }

    public function normalize(): CollectionInterface
    {
        return $this->run(Normalize::of());
    }

    public function nth(int $step, int $offset = 0): CollectionInterface
    {
        return $this->run(Nth::of()($step)($offset));
    }

    public function nullsy(): bool
    {
        return $this->run(Nullsy::of())->getIterator()->current();
    }

    public function pack(): CollectionInterface
    {
        return $this->run(Pack::of());
    }

    public function pad(int $size, $value): CollectionInterface
    {
        return $this->run(Pad::of()($size)($value));
    }

    public function pair(): CollectionInterface
    {
        return $this->run(Pair::of());
    }

    public function permutate(): CollectionInterface
    {
        return $this->run(Permutate::of());
    }

    public function pluck($pluck, $default = null): CollectionInterface
    {
        return $this->run(Pluck::of()($pluck)($default));
    }

    public function prepend(...$items): CollectionInterface
    {
        return $this->run(Prepend::of()(...$items));
    }

    public function product(iterable ...$iterables): CollectionInterface
    {
        return $this->run(Product::of()(...$iterables));
    }

    public function random(int $size = 1): CollectionInterface
    {
        return $this->run(Random::of()($size));
    }

    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): CollectionInterface
    {
        return (new self())->run(Range::of()($start)($end)($step));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return $this->run(Reduce::of()($callback)($initial))->getIterator()->current();
    }

    public function reduction(callable $callback, $initial = null): CollectionInterface
    {
        return $this->run(Reduction::of()($callback)($initial));
    }

    public function reverse(): CollectionInterface
    {
        return $this->run(Reverse::of());
    }

    public function rsample(float $probability): CollectionInterface
    {
        return $this->run(RSample::of()($probability));
    }

    public function run(callable ...$operations): CollectionInterface
    {
        return self::fromCallable(
            Compose::of()(...$operations),
            $this->getIterator()
        );
    }

    public function scale(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ): CollectionInterface {
        return $this->run(Scale::of()($lowerBound)($upperBound)($wantedLowerBound)($wantedUpperBound)($base));
    }

    public function scanLeft(callable $callback, $initial = null): CollectionInterface
    {
        return $this->run(ScanLeft::of()($callback)($initial));
    }

    public function scanLeft1(callable $callback): CollectionInterface
    {
        return $this->run(ScanLeft1::of()($callback));
    }

    public function scanRight(callable $callback, $initial = null): CollectionInterface
    {
        return $this->run(ScanRight::of()($callback)($initial));
    }

    public function scanRight1(callable $callback): CollectionInterface
    {
        return $this->run(ScanRight1::of()($callback));
    }

    public function shuffle(): CollectionInterface
    {
        return $this->run(Shuffle::of());
    }

    public function since(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Since::of()(...$callbacks));
    }

    public function slice(int $offset, int $length = -1): CollectionInterface
    {
        return $this->run(Slice::of()($offset)($length));
    }

    public function sort(int $type = Operation\Sortable::BY_VALUES, ?callable $callback = null): CollectionInterface
    {
        return $this->run(Sort::of()($type)($callback));
    }

    public function span(callable $callback): CollectionInterface
    {
        return $this->run(Span::of()($callback));
    }

    public function split(int $type = Operation\Splitable::BEFORE, callable ...$callbacks): CollectionInterface
    {
        return $this->run(Split::of()($type)(...$callbacks));
    }

    public function tail(): CollectionInterface
    {
        return $this->run(Tail::of());
    }

    public function tails(): CollectionInterface
    {
        return $this->run(Tails::of());
    }

    public function takeWhile(callable $callback): CollectionInterface
    {
        return $this->run(TakeWhile::of()($callback));
    }

    public static function times(int $number = 0, ?callable $callback = null): CollectionInterface
    {
        return (new self())->run(Times::of()($number)($callback));
    }

    public function transpose(): CollectionInterface
    {
        return $this->run(Transpose::of());
    }

    public function truthy(): bool
    {
        return $this->run(Truthy::of())->getIterator()->current();
    }

    public static function unfold(callable $callback, ...$parameters): CollectionInterface
    {
        return (new self())->run(Unfold::of()(...$parameters)($callback));
    }

    public function unlines(): CollectionInterface
    {
        return $this->run(Unlines::of());
    }

    public function unpack(): CollectionInterface
    {
        return $this->run(Unpack::of());
    }

    public function unpair(): CollectionInterface
    {
        return $this->run(Unpair::of());
    }

    public function until(callable ...$callbacks): CollectionInterface
    {
        return $this->run(Until::of()(...$callbacks));
    }

    public function unwindow(): CollectionInterface
    {
        return $this->run(Unwindow::of());
    }

    public function unwords(): CollectionInterface
    {
        return $this->run(Unwords::of());
    }

    public function unwrap(): CollectionInterface
    {
        return $this->run(Unwrap::of());
    }

    public function unzip(): CollectionInterface
    {
        return $this->run(Unzip::of());
    }

    public function window(int $size): CollectionInterface
    {
        return $this->run(Window::of()($size));
    }

    public static function with($data = [], ...$parameters): CollectionInterface
    {
        return new self($data, ...$parameters);
    }

    public function words(): CollectionInterface
    {
        return $this->run(Words::of());
    }

    public function wrap(): CollectionInterface
    {
        return $this->run(Wrap::of());
    }

    public function zip(iterable ...$iterables): CollectionInterface
    {
        return $this->run(Zip::of()(...$iterables));
    }
}
