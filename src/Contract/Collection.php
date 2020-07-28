<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use loophp\collection\Contract\Operation\Appendable;
use loophp\collection\Contract\Operation\Applyable;
use loophp\collection\Contract\Operation\Cacheable;
use loophp\collection\Contract\Operation\Chunkable;
use loophp\collection\Contract\Operation\Collapseable;
use loophp\collection\Contract\Operation\Columnable;
use loophp\collection\Contract\Operation\Combinateable;
use loophp\collection\Contract\Operation\Combineable;
use loophp\collection\Contract\Operation\Compactable;
use loophp\collection\Contract\Operation\Cycleable;
use loophp\collection\Contract\Operation\Diffable;
use loophp\collection\Contract\Operation\Diffkeysable;
use loophp\collection\Contract\Operation\Distinctable;
use loophp\collection\Contract\Operation\Explodeable;
use loophp\collection\Contract\Operation\Filterable;
use loophp\collection\Contract\Operation\Flattenable;
use loophp\collection\Contract\Operation\Flipable;
use loophp\collection\Contract\Operation\Forgetable;
use loophp\collection\Contract\Operation\Frequencyable;
use loophp\collection\Contract\Operation\Groupable;
use loophp\collection\Contract\Operation\Intersectable;
use loophp\collection\Contract\Operation\Intersectkeysable;
use loophp\collection\Contract\Operation\Intersperseable;
use loophp\collection\Contract\Operation\Iterateable;
use loophp\collection\Contract\Operation\Keysable;
use loophp\collection\Contract\Operation\Limitable;
use loophp\collection\Contract\Operation\Loopable;
use loophp\collection\Contract\Operation\Mapable;
use loophp\collection\Contract\Operation\Mergeable;
use loophp\collection\Contract\Operation\Normalizeable;
use loophp\collection\Contract\Operation\Nthable;
use loophp\collection\Contract\Operation\Onlyable;
use loophp\collection\Contract\Operation\Padable;
use loophp\collection\Contract\Operation\Permutateable;
use loophp\collection\Contract\Operation\Pluckable;
use loophp\collection\Contract\Operation\Prependable;
use loophp\collection\Contract\Operation\Productable;
use loophp\collection\Contract\Operation\Randomable;
use loophp\collection\Contract\Operation\Rangeable;
use loophp\collection\Contract\Operation\Reductionable;
use loophp\collection\Contract\Operation\Reverseable;
use loophp\collection\Contract\Operation\RSampleable;
use loophp\collection\Contract\Operation\Scaleable;
use loophp\collection\Contract\Operation\Shuffleable;
use loophp\collection\Contract\Operation\Sinceable;
use loophp\collection\Contract\Operation\Skipable;
use loophp\collection\Contract\Operation\Sliceable;
use loophp\collection\Contract\Operation\Sortable;
use loophp\collection\Contract\Operation\Splitable;
use loophp\collection\Contract\Operation\Tailable;
use loophp\collection\Contract\Operation\Timesable;
use loophp\collection\Contract\Operation\Transposeable;
use loophp\collection\Contract\Operation\Untilable;
use loophp\collection\Contract\Operation\Unwrapable;
use loophp\collection\Contract\Operation\Walkable;
use loophp\collection\Contract\Operation\Windowable;
use loophp\collection\Contract\Operation\Wrapable;
use loophp\collection\Contract\Operation\Zipable;
use loophp\collection\Contract\Transformation\Allable;
use loophp\collection\Contract\Transformation\Containsable;
use loophp\collection\Contract\Transformation\Falsyable;
use loophp\collection\Contract\Transformation\Firstable;
use loophp\collection\Contract\Transformation\FoldLeftable;
use loophp\collection\Contract\Transformation\FoldRightable;
use loophp\collection\Contract\Transformation\Getable;
use loophp\collection\Contract\Transformation\Implodeable;
use loophp\collection\Contract\Transformation\Lastable;
use loophp\collection\Contract\Transformation\Nullsyable;
use loophp\collection\Contract\Transformation\Reduceable;
use loophp\collection\Contract\Transformation\Runable;
use loophp\collection\Contract\Transformation\Transformable;
use loophp\collection\Contract\Transformation\Truthyable;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template V
 * @template-extends Allable<TKey, T>
 * @template-extends ArrayAccess<TKey, T>
 * @template-extends IteratorAggregate<TKey, T>
 * @template-extends Appendable<TKey, T>
 * @template-extends Applyable<TKey, T>
 * @template-extends Cacheable<TKey, T>
 * @template-extends Chunkable<T>
 * @template-extends Collapseable<TKey, T>
 * @template-extends Columnable<T>
 * @template-extends Combinateable<T>
 * @template-extends Combineable<TKey, T>
 * @template-extends Compactable<TKey, T>
 * @template-extends Cycleable<TKey, T>
 * @template-extends Diffable<TKey, T, U>
 * @template-extends Diffkeysable<TKey, T, U>
 * @template-extends Distinctable<TKey, T>
 * @template-extends Explodeable<TKey, T>
 * @template-extends Filterable<TKey, T>
 * @template-extends Flattenable<T>
 * @template-extends Flipable<TKey, T>
 * @template-extends Forgetable<TKey, T>
 * @template-extends Frequencyable<T>
 * @template-extends Getable<TKey, T>
 * @template-extends Groupable<TKey, T, U>
 * @template-extends Intersectable<TKey, T, U>
 * @template-extends Intersectkeysable<TKey, T, U>
 * @template-extends Intersperseable<TKey, T, U>
 * @template-extends Keysable<TKey, T>
 * @template-extends Limitable<TKey, T>
 * @template-extends Loopable<TKey, T>
 * @template-extends Mapable<TKey, T, U>
 * @template-extends Mergeable<TKey, T>
 * @template-extends Normalizeable<T>
 * @template-extends Nthable<TKey, T>
 * @template-extends Onlyable<TKey, T>
 * @template-extends Padable<TKey, T, U>
 * @template-extends Permutateable<T>
 * @template-extends Pluckable<T, U, V>
 * @template-extends Prependable<TKey, T>
 * @template-extends Productable<TKey, T>
 * @template-extends RSampleable<TKey, T>
 * @template-extends Randomable<TKey, T>
 * @template-extends Reductionable<TKey, T, U, V>
 * @template-extends Reverseable<TKey, T>
 * @template-extends Runable<TKey, T, U>
 * @template-extends Scaleable<TKey, T>
 * @template-extends Shuffleable<TKey, T>
 * @template-extends Sinceable<TKey, T>
 * @template-extends Skipable<TKey, T>
 * @template-extends Sliceable<TKey, T>
 * @template-extends Sortable<TKey, T>
 * @template-extends Splitable<TKey, T, U>
 * @template-extends Tailable<TKey, T>
 * @template-extends Transformable<TKey, T, U>
 * @template-extends Transposeable<TKey, T>
 * @template-extends Untilable<TKey, T>
 * @template-extends Unwrapable<TKey, T>
 * @template-extends Walkable<TKey, T, U>
 * @template-extends Windowable<TKey, T>
 * @template-extends Wrapable<TKey, T>
 * @template-extends Zipable<TKey, T, U, V>
 */
interface Collection extends
    Allable,
    Appendable,
    Applyable,
    ArrayAccess,
    Cacheable,
    Chunkable,
    Collapseable,
    Columnable,
    Combinateable,
    Combineable,
    Compactable,
    Containsable,
    Cycleable,
    Diffable,
    Diffkeysable,
    Distinctable,
    Explodeable,
    Falsyable,
    Filterable,
    Firstable,
    Flattenable,
    Flipable,
    FoldLeftable,
    FoldRightable,
    Forgetable,
    Frequencyable,
    Getable,
    Groupable,
    Implodeable,
    Intersectable,
    Intersectkeysable,
    Intersperseable,
    Iterateable,
    IteratorAggregate,
    JsonSerializable,
    Keysable,
    Lastable,
    Limitable,
    Loopable,
    Mapable,
    Mergeable,
    Normalizeable,
    Nthable,
    Nullsyable,
    Onlyable,
    Padable,
    Permutateable,
    Pluckable,
    Prependable,
    Productable,
    Randomable,
    Rangeable,
    Reduceable,
    Reductionable,
    Reverseable,
    RSampleable,
    Runable,
    Scaleable,
    Shuffleable,
    Sinceable,
    Skipable,
    Sliceable,
    Sortable,
    Splitable,
    Tailable,
    Timesable,
    Transformable,
    Transposeable,
    Truthyable,
    Untilable,
    Unwrapable,
    Walkable,
    Windowable,
    Wrapable,
    Zipable
{
    /**
     * @template NewT
     * @template NewTKey
     * @psalm-template NewTKey of array-key
     * @template NewU
     * @template NewV
     *
     * @return \loophp\collection\Contract\Collection<NewTKey, NewT, NewU, NewV>
     */
    public static function empty(): Collection;

    /**
     * @template NewT
     * @template NewTKey
     * @psalm-template NewTKey of array-key
     * @template NewU
     * @template NewV
     *
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Contract\Collection<NewTKey, NewT, NewU, NewV>
     */
    public static function fromCallable(callable $callable, ...$parameters): Collection;

    /**
     * @template NewT
     * @template NewTKey
     * @psalm-template NewTKey of array-key
     * @template NewU
     * @template NewV
     *
     * @param iterable<mixed> $iterable
     *
     * @return \loophp\collection\Contract\Collection<NewTKey, NewT, NewU, NewV>
     */
    public static function fromIterable(iterable $iterable): Collection;

    /**
     * @template NewT
     * @template NewTKey
     * @psalm-template NewTKey of array-key
     * @template NewU
     * @template NewV
     *
     * @param resource $resource
     *
     * @return \loophp\collection\Contract\Collection<NewTKey, NewT, NewU, NewV>
     */
    public static function fromResource($resource): Collection;

    /**
     * @template NewT
     * @template NewTKey
     * @psalm-template NewTKey of array-key
     * @template NewU
     * @template NewV
     *
     * @return \loophp\collection\Contract\Collection<NewTKey, NewT, NewU, NewV>
     */
    public static function fromString(string $string, string $delimiter = ''): Collection;

    /**
     * @template NewT
     * @template NewTKey
     * @psalm-template NewTKey of array-key
     * @template NewU
     * @template NewV
     *
     * @param mixed $data
     *
     * @return \loophp\collection\Contract\Collection<NewTKey, NewT, NewU, NewV>
     */
    public static function with($data = []): Collection;
}
