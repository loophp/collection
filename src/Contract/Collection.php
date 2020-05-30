<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use loophp\collection\Contract\Operation\Appendable;
use loophp\collection\Contract\Operation\Applyable;
use loophp\collection\Contract\Operation\Chunkable;
use loophp\collection\Contract\Operation\Collapseable;
use loophp\collection\Contract\Operation\Combinateable;
use loophp\collection\Contract\Operation\Combineable;
use loophp\collection\Contract\Operation\Cycleable;
use loophp\collection\Contract\Operation\Distinctable;
use loophp\collection\Contract\Operation\Explodeable;
use loophp\collection\Contract\Operation\Filterable;
use loophp\collection\Contract\Operation\Flattenable;
use loophp\collection\Contract\Operation\Flipable;
use loophp\collection\Contract\Operation\Forgetable;
use loophp\collection\Contract\Operation\Intersperseable;
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
use loophp\collection\Contract\Operation\Reductionable;
use loophp\collection\Contract\Operation\Reverseable;
use loophp\collection\Contract\Operation\RSampleable;
use loophp\collection\Contract\Operation\Scaleable;
use loophp\collection\Contract\Operation\Shuffleable;
use loophp\collection\Contract\Operation\Skipable;
use loophp\collection\Contract\Operation\Sliceable;
use loophp\collection\Contract\Operation\Sortable;
use loophp\collection\Contract\Operation\Splitable;
use loophp\collection\Contract\Operation\Tailable;
use loophp\collection\Contract\Operation\Untilable;
use loophp\collection\Contract\Operation\Walkable;
use loophp\collection\Contract\Operation\Windowable;
use loophp\collection\Contract\Operation\Zipable;
use loophp\collection\Contract\Transformation\Allable;
use loophp\collection\Contract\Transformation\Containsable;
use loophp\collection\Contract\Transformation\Firstable;
use loophp\collection\Contract\Transformation\FoldLeftable;
use loophp\collection\Contract\Transformation\FoldRightable;
use loophp\collection\Contract\Transformation\Getable;
use loophp\collection\Contract\Transformation\Implodeable;
use loophp\collection\Contract\Transformation\Lastable;
use loophp\collection\Contract\Transformation\Reduceable;

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
    Shuffleable,
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
