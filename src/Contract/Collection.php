<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * @template-extends Allable<TKey, T>
 * @template-extends Appendable<TKey, T>
 * @template-extends Applyable<TKey, T>
 * @template-extends Associateable<TKey, T>
 * @template-extends AsyncMapable<TKey, T>
 * @template-extends AsyncMapNable<TKey, T>
 * @template-extends Averagesable<TKey, T>
 * @template-extends Cacheable<TKey, T>
 * @template-extends Chunkable<TKey, T>
 * @template-extends Coalesceable<TKey, T>
 * @template-extends Collapseable<TKey, T>
 * @template-extends Columnable<TKey, T>
 * @template-extends Combinateable<TKey, T>
 * @template-extends Combineable<TKey, T>
 * @template-extends Compactable<TKey, T>
 * @template-extends Comparable<TKey, T>
 * @template-extends Containsable<TKey, T>
 * @template-extends Currentable<TKey, T>
 * @template-extends Cycleable<TKey, T>
 * @template-extends Diffable<TKey, T>
 * @template-extends Diffkeysable<TKey, T>
 * @template-extends Distinctable<TKey, T>
 * @template-extends Dropable<TKey, T>
 * @template-extends DropWhileable<TKey, T>
 * @template-extends Dumpable<TKey, T>
 * @template-extends Duplicateable<TKey, T>
 * @template-extends Everyable<TKey, T>
 * @template-extends Explodeable<TKey, T>
 * @template-extends Falsyable<TKey, T>
 * @template-extends Filterable<TKey, T>
 * @template-extends Findable<TKey, T>
 * @template-extends Firstable<TKey, T>
 * @template-extends FlatMapable<TKey, T>
 * @template-extends Flattenable<TKey, T>
 * @template-extends Flipable<TKey, T>
 * @template-extends FoldLeftable<TKey, T>
 * @template-extends FoldLeft1able<TKey, T>
 * @template-extends FoldRightable<TKey, T>
 * @template-extends FoldRight1able<TKey, T>
 * @template-extends Forgetable<TKey, T>
 * @template-extends Frequencyable<TKey, T>
 * @template-extends Getable<TKey, T>
 * @template-extends Groupable<TKey, T>
 * @template-extends GroupByable<TKey, T>
 * @template-extends Hasable<TKey, T>
 * @template-extends Headable<TKey, T>
 * @template-extends IfThenElseable<TKey, T>
 * @template-extends Implodeable<TKey, T>
 * @template-extends Initable<TKey, T>
 * @template-extends Initsable<TKey, T>
 * @template-extends Intersectable<TKey, T>
 * @template-extends Intersectkeysable<TKey, T>
 * @template-extends Intersperseable<TKey, T>
 * @template-extends IsEmptyable<TKey, T>
 * @template-extends Keyable<TKey, T>
 * @template-extends Keysable<TKey, T>
 * @template-extends Lastable<TKey, T>
 * @template-extends Limitable<TKey, T>
 * @template-extends Linesable<TKey, T>
 * @template-extends Mapable<TKey, T>
 * @template-extends MapNable<TKey, T>
 * @template-extends Matchable<TKey, T>
 * @template-extends Matchingable<TKey, T>
 * @template-extends Maxable<TKey, T>
 * @template-extends Mergeable<TKey, T>
 * @template-extends Minable<TKey, T>
 * @template-extends Normalizeable<TKey, T>
 * @template-extends Nthable<TKey, T>
 * @template-extends Nullsyable<TKey, T>
 * @template-extends Packable<TKey, T>
 * @template-extends Padable<TKey, T>
 * @template-extends Pairable<TKey, T>
 * @template-extends Partitionable<TKey, T>
 * @template-extends Permutateable<TKey, T>
 * @template-extends Pipeable<TKey, T>
 * @template-extends Pluckable<TKey, T>
 * @template-extends Prependable<TKey, T>
 * @template-extends Productable<TKey, T>
 * @template-extends Randomable<TKey, T>
 * @template-extends Rangeable<TKey, T>
 * @template-extends Reduceable<TKey, T>
 * @template-extends Reductionable<TKey, T>
 * @template-extends Rejectable<TKey, T>
 * @template-extends Reverseable<TKey, T>
 * @template-extends RSampleable<TKey, T>
 * @template-extends Scaleable<TKey, T>
 * @template-extends ScanLeft1able<TKey, T>
 * @template-extends ScanLeftable<TKey, T>
 * @template-extends ScanRight1able<TKey, T>
 * @template-extends ScanRightable<TKey, T>
 * @template-extends Shuffleable<TKey, T>
 * @template-extends Sinceable<TKey, T>
 * @template-extends Sliceable<TKey, T>
 * @template-extends Sortable<TKey, T>
 * @template-extends Spanable<TKey, T>
 * @template-extends Splitable<TKey, T>
 * @template-extends Squashable<TKey, T>
 * @template-extends Strictable<TKey, T>
 * @template-extends Tailable<TKey, T>
 * @template-extends Tailsable<TKey, T>
 * @template-extends TakeWhileable<TKey, T>
 * @template-extends Transposeable<TKey, T>
 * @template-extends Truthyable<TKey, T>
 * @template-extends Unfoldable<TKey, T>
 * @template-extends Unlinesable<TKey, T>
 * @template-extends Unpackable<mixed, array{0: TKey, 1: T}>
 * @template-extends Unpairable<TKey, T>
 * @template-extends Untilable<TKey, T>
 * @template-extends Unwindowable<TKey, T>
 * @template-extends Unwordsable<TKey, T>
 * @template-extends Unwrapable<TKey, T>
 * @template-extends Unzipable<TKey, T>
 * @template-extends Whenable<TKey, T>
 * @template-extends Windowable<TKey, T>
 * @template-extends Wordsable<TKey, T>
 * @template-extends Wrapable<TKey, T>
 * @template-extends Zipable<TKey, T>
 * @template-extends IteratorAggregate<TKey, T>
 */
interface Collection extends
    Operation\Allable,
    Operation\Appendable,
    Operation\Applyable,
    Operation\Associateable,
    Operation\AsyncMapable,
    Operation\AsyncMapNable,
    Operation\Averagesable,
    Operation\Cacheable,
    Operation\Chunkable,
    Operation\Coalesceable,
    Operation\Collapseable,
    Operation\Columnable,
    Operation\Combinateable,
    Operation\Combineable,
    Operation\Compactable,
    Operation\Comparable,
    Operation\Containsable,
    Countable,
    Operation\Currentable,
    Operation\Cycleable,
    Operation\Diffable,
    Operation\Diffkeysable,
    Operation\Distinctable,
    Operation\Dropable,
    Operation\DropWhileable,
    Operation\Dumpable,
    Operation\Duplicateable,
    Operation\Equalsable,
    Operation\Everyable,
    Operation\Explodeable,
    Operation\Falsyable,
    Operation\Filterable,
    Operation\Findable,
    Operation\Firstable,
    Operation\FlatMapable,
    Operation\Flattenable,
    Operation\Flipable,
    Operation\FoldLeft1able,
    Operation\FoldLeftable,
    Operation\FoldRight1able,
    Operation\FoldRightable,
    Operation\Forgetable,
    Operation\Frequencyable,
    Operation\Getable,
    Operation\Groupable,
    Operation\GroupByable,
    Operation\Hasable,
    Operation\Headable,
    Operation\IfThenElseable,
    Operation\Implodeable,
    Operation\Initable,
    Operation\Initsable,
    Operation\Intersectable,
    Operation\Intersectkeysable,
    Operation\Intersperseable,
    Operation\IsEmptyable,
    IteratorAggregate,
    JsonSerializable,
    Operation\Keyable,
    Operation\Keysable,
    Operation\Lastable,
    Operation\Limitable,
    Operation\Linesable,
    Operation\Mapable,
    Operation\MapNable,
    Operation\Matchable,
    Operation\Matchingable,
    Operation\Maxable,
    Operation\Mergeable,
    Operation\Minable,
    Operation\Normalizeable,
    Operation\Nthable,
    Operation\Nullsyable,
    Operation\Packable,
    Operation\Padable,
    Operation\Pairable,
    Operation\Partitionable,
    Operation\Permutateable,
    Operation\Pipeable,
    Operation\Pluckable,
    Operation\Prependable,
    Operation\Productable,
    Operation\Randomable,
    Operation\Rangeable,
    Operation\Reduceable,
    Operation\Reductionable,
    Operation\Rejectable,
    Operation\Reverseable,
    Operation\RSampleable,
    Operation\Sameable,
    Operation\Scaleable,
    Operation\ScanLeft1able,
    Operation\ScanLeftable,
    Operation\ScanRight1able,
    Operation\ScanRightable,
    Operation\Shuffleable,
    Operation\Sinceable,
    Operation\Sliceable,
    Operation\Sortable,
    Operation\Spanable,
    Operation\Splitable,
    Operation\Squashable,
    Operation\Strictable,
    Operation\Tailable,
    Operation\Tailsable,
    Operation\TakeWhileable,
    Operation\Timesable,
    Operation\Transposeable,
    Operation\Truthyable,
    Operation\Unfoldable,
    Operation\Unlinesable,
    Operation\Unpackable,
    Operation\Unpairable,
    Operation\Untilable,
    Operation\Unwindowable,
    Operation\Unwordsable,
    Operation\Unwrapable,
    Operation\Unzipable,
    Operation\Whenable,
    Operation\Windowable,
    Operation\Wordsable,
    Operation\Wrapable,
    Operation\Zipable
{
    /**
     * @return Traversable<TKey, T>
     */
    public function getIterator(): Traversable;
}
