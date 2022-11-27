<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use IteratorAggregate;
use Traversable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * @template-extends Operation\Allable<TKey, T>
 * @template-extends Operation\Appendable<TKey, T>
 * @template-extends Operation\Applyable<TKey, T>
 * @template-extends Operation\Associateable<TKey, T>
 * @template-extends Operation\AsyncMapable<TKey, T>
 * @template-extends Operation\AsyncMapNable<TKey, T>
 * @template-extends Operation\Averagesable<TKey, T>
 * @template-extends Operation\Cacheable<TKey, T>
 * @template-extends Operation\Chunkable<TKey, T>
 * @template-extends Operation\Coalesceable<TKey, T>
 * @template-extends Operation\Collapseable<TKey, T>
 * @template-extends Operation\Columnable<TKey, T>
 * @template-extends Operation\Combinateable<TKey, T>
 * @template-extends Operation\Combineable<TKey, T>
 * @template-extends Operation\Compactable<TKey, T>
 * @template-extends Operation\Comparable<TKey, T>
 * @template-extends Operation\Containsable<TKey, T>
 * @template-extends Operation\Currentable<TKey, T>
 * @template-extends Operation\Cycleable<TKey, T>
 * @template-extends Operation\Diffable<TKey, T>
 * @template-extends Operation\Diffkeysable<TKey, T>
 * @template-extends Operation\Distinctable<TKey, T>
 * @template-extends Operation\Dropable<TKey, T>
 * @template-extends Operation\DropWhileable<TKey, T>
 * @template-extends Operation\Dumpable<TKey, T>
 * @template-extends Operation\Duplicateable<TKey, T>
 * @template-extends Operation\Everyable<TKey, T>
 * @template-extends Operation\Explodeable<TKey, T>
 * @template-extends Operation\Falsyable<TKey, T>
 * @template-extends Operation\Filterable<TKey, T>
 * @template-extends Operation\Findable<TKey, T>
 * @template-extends Operation\Firstable<TKey, T>
 * @template-extends Operation\FlatMapable<TKey, T>
 * @template-extends Operation\Flattenable<TKey, T>
 * @template-extends Operation\Flipable<TKey, T>
 * @template-extends Operation\FoldLeftable<TKey, T>
 * @template-extends Operation\FoldLeft1able<TKey, T>
 * @template-extends Operation\FoldRightable<TKey, T>
 * @template-extends Operation\FoldRight1able<TKey, T>
 * @template-extends Operation\Forgetable<TKey, T>
 * @template-extends Operation\Frequencyable<TKey, T>
 * @template-extends Operation\Getable<TKey, T>
 * @template-extends Operation\Groupable<TKey, T>
 * @template-extends Operation\GroupByable<TKey, T>
 * @template-extends Operation\Hasable<TKey, T>
 * @template-extends Operation\Headable<TKey, T>
 * @template-extends Operation\IfThenElseable<TKey, T>
 * @template-extends Operation\Implodeable<TKey, T>
 * @template-extends Operation\Initable<TKey, T>
 * @template-extends Operation\Initsable<TKey, T>
 * @template-extends Operation\Intersectable<TKey, T>
 * @template-extends Operation\Intersectkeysable<TKey, T>
 * @template-extends Operation\Intersperseable<TKey, T>
 * @template-extends Operation\IsEmptyable<TKey, T>
 * @template-extends Operation\Keyable<TKey, T>
 * @template-extends Operation\Keysable<TKey, T>
 * @template-extends Operation\Lastable<TKey, T>
 * @template-extends Operation\Limitable<TKey, T>
 * @template-extends Operation\Linesable<TKey, T>
 * @template-extends Operation\Mapable<TKey, T>
 * @template-extends Operation\MapNable<TKey, T>
 * @template-extends Operation\Matchable<TKey, T>
 * @template-extends Operation\Matchingable<TKey, T>
 * @template-extends Operation\Maxable<TKey, T>
 * @template-extends Operation\Mergeable<TKey, T>
 * @template-extends Operation\Minable<TKey, T>
 * @template-extends Operation\Normalizeable<TKey, T>
 * @template-extends Operation\Nthable<TKey, T>
 * @template-extends Operation\Nullsyable<TKey, T>
 * @template-extends Operation\Packable<TKey, T>
 * @template-extends Operation\Padable<TKey, T>
 * @template-extends Operation\Pairable<TKey, T>
 * @template-extends Operation\Partitionable<TKey, T>
 * @template-extends Operation\Permutateable<TKey, T>
 * @template-extends Operation\Pipeable<TKey, T>
 * @template-extends Operation\Pluckable<TKey, T>
 * @template-extends Operation\Prependable<TKey, T>
 * @template-extends Operation\Productable<TKey, T>
 * @template-extends Operation\Randomable<TKey, T>
 * @template-extends Operation\Reduceable<TKey, T>
 * @template-extends Operation\Reductionable<TKey, T>
 * @template-extends Operation\Rejectable<TKey, T>
 * @template-extends Operation\Reverseable<TKey, T>
 * @template-extends Operation\RSampleable<TKey, T>
 * @template-extends Operation\Scaleable<TKey, T>
 * @template-extends Operation\ScanLeft1able<TKey, T>
 * @template-extends Operation\ScanLeftable<TKey, T>
 * @template-extends Operation\ScanRight1able<TKey, T>
 * @template-extends Operation\ScanRightable<TKey, T>
 * @template-extends Operation\Shuffleable<TKey, T>
 * @template-extends Operation\Sinceable<TKey, T>
 * @template-extends Operation\Sliceable<TKey, T>
 * @template-extends Operation\Sortable<TKey, T>
 * @template-extends Operation\Spanable<TKey, T>
 * @template-extends Operation\Splitable<TKey, T>
 * @template-extends Operation\Squashable<TKey, T>
 * @template-extends Operation\Strictable<TKey, T>
 * @template-extends Operation\Tailable<TKey, T>
 * @template-extends Operation\Tailsable<TKey, T>
 * @template-extends Operation\TakeWhileable<TKey, T>
 * @template-extends Operation\Transposeable<TKey, T>
 * @template-extends Operation\Truthyable<TKey, T>
 * @template-extends Operation\Unlinesable<TKey, T>
 * @template-extends Operation\Unpackable<mixed, array{0: TKey, 1: T}>
 * @template-extends Operation\Unpairable<TKey, T>
 * @template-extends Operation\Untilable<TKey, T>
 * @template-extends Operation\Unwindowable<TKey, T>
 * @template-extends Operation\Unwordsable<TKey, T>
 * @template-extends Operation\Unwrapable<TKey, T>
 * @template-extends Operation\Unzipable<TKey, T>
 * @template-extends Operation\Whenable<TKey, T>
 * @template-extends Operation\Windowable<TKey, T>
 * @template-extends Operation\Wordsable<TKey, T>
 * @template-extends Operation\Wrapable<TKey, T>
 * @template-extends Operation\Zipable<TKey, T>
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
