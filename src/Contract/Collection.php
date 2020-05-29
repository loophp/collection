<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use const INF;

/**
 * Interface Collection.
 */
interface Collection extends
    Allable,
    Appendable,
    Applyable,
    Base,
    Chunkable,
    Collapseable,
    Combinateable,
    Combineable,
    Containsable,
    Cycleable,
    Distinctable,
    Explodeable,
    Filterable,
    Firstable,
    Flattenable,
    Flipable,
    FoldLeftable,
    FoldRightable,
    Forgetable,
    Getable,
    Implodeable,
    Intersperseable,
    Keysable,
    Lastable,
    Limitable,
    Loopable,
    Mapable,
    Mergeable,
    Normalizeable,
    Nthable,
    Onlyable,
    Padable,
    Permutateable,
    Pluckable,
    Prependable,
    Productable,
    Reduceable,
    Reductionable,
    Reverseable,
    RSampleable,
    Scaleable,
    Skipable,
    Sliceable,
    Sortable,
    Splitable,
    Tailable,
    Untilable,
    Walkable,
    Windowable,
    Zipable
{
    /**
     * Create a new instance with no items.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function empty(): Collection;

    /**
     * @param callable $callback
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function iterate(callable $callback, ...$parameters): Collection;

    /**
     * Create a new with a range of number.
     *
     * @param float $start
     * @param float $end
     * @param float $step
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function range(float $start = 0.0, float $end = INF, float $step = 1.0): Collection;

    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @param float|int $number
     * @param callable $callback
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function times($number = INF, ?callable $callback = null): Collection;

    /**
     * Create a collection with the data.
     *
     * @param mixed $data
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function with($data = [], ...$parameters): Collection;
}
