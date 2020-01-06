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
    Permutateable,
    Pluckable,
    Prependable,
    Productable,
    Rebaseable,
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
     * @param int $start
     * @param float|int $end
     * @param int $step
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function range(int $start = 0, $end = INF, $step = 1): Collection;

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
     * TODO.
     *
     * @param mixed $data
     * @param mixed ...$parameters
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public static function with($data = [], ...$parameters): Collection;
}
