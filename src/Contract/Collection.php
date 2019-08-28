<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Collection.
 */
interface Collection extends
    Allable,
    Appendable,
    Applyable,
    BaseCollection,
    Chunkable,
    Collapseable,
    Combineable,
    Containsable,
    Filterable,
    Firstable,
    Flattenable,
    Flipable,
    Forgetable,
    Getable,
    Implodeable,
    Intersperseable,
    Keysable,
    Lastable,
    Limitable,
    Mapable,
    Mergeable,
    Normalizeable,
    Nthable,
    Onlyable,
    Padable,
    Pluckable,
    Prependable,
    Rebaseable,
    Reduceable,
    Skipable,
    Sliceable,
    Sortable,
    Walkable,
    Zipable
{
    /**
     * Create a new instance with no items.
     */
    public static function empty(): self;

    /**
     * Create a new with a range of number.
     *
     * @param int $start
     * @param float|int $end
     * @param int $step
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function range(int $start = 0, $end = \INF, $step = 1): Collection;

    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @param int $number
     * @param callable $callback
     *
     * @return \drupol\collection\Contract\Collection
     */
    public static function times($number, callable $callback = null): Collection;
}
