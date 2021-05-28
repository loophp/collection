<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract;

use Countable;
use Iterator;
use IteratorAggregate;
use JsonSerializable;
use loophp\collection\Contract\Operation\Allable;
use loophp\collection\Contract\Operation\Appendable;
use loophp\collection\Contract\Operation\Applyable;
use loophp\collection\Contract\Operation\Associateable;
use loophp\collection\Contract\Operation\AsyncMapable;
use loophp\collection\Contract\Operation\Cacheable;
use loophp\collection\Contract\Operation\Chunkable;
use loophp\collection\Contract\Operation\Coalesceable;
use loophp\collection\Contract\Operation\Collapseable;
use loophp\collection\Contract\Operation\Columnable;
use loophp\collection\Contract\Operation\Combinateable;
use loophp\collection\Contract\Operation\Combineable;
use loophp\collection\Contract\Operation\Compactable;
use loophp\collection\Contract\Operation\Containsable;
use loophp\collection\Contract\Operation\Currentable;
use loophp\collection\Contract\Operation\Cycleable;
use loophp\collection\Contract\Operation\Diffable;
use loophp\collection\Contract\Operation\Diffkeysable;
use loophp\collection\Contract\Operation\Distinctable;
use loophp\collection\Contract\Operation\Dropable;
use loophp\collection\Contract\Operation\DropWhileable;
use loophp\collection\Contract\Operation\Dumpable;
use loophp\collection\Contract\Operation\Duplicateable;
use loophp\collection\Contract\Operation\Everyable;
use loophp\collection\Contract\Operation\Explodeable;
use loophp\collection\Contract\Operation\Falsyable;
use loophp\collection\Contract\Operation\Filterable;
use loophp\collection\Contract\Operation\Firstable;
use loophp\collection\Contract\Operation\Flattenable;
use loophp\collection\Contract\Operation\Flipable;
use loophp\collection\Contract\Operation\FoldLeft1able;
use loophp\collection\Contract\Operation\FoldLeftable;
use loophp\collection\Contract\Operation\FoldRight1able;
use loophp\collection\Contract\Operation\FoldRightable;
use loophp\collection\Contract\Operation\Forgetable;
use loophp\collection\Contract\Operation\Frequencyable;
use loophp\collection\Contract\Operation\Getable;
use loophp\collection\Contract\Operation\Groupable;
use loophp\collection\Contract\Operation\GroupByable;
use loophp\collection\Contract\Operation\Hasable;
use loophp\collection\Contract\Operation\Headable;
use loophp\collection\Contract\Operation\IfThenElseable;
use loophp\collection\Contract\Operation\Implodeable;
use loophp\collection\Contract\Operation\Initable;
use loophp\collection\Contract\Operation\Initsable;
use loophp\collection\Contract\Operation\Intersectable;
use loophp\collection\Contract\Operation\Intersectkeysable;
use loophp\collection\Contract\Operation\Intersperseable;
use loophp\collection\Contract\Operation\Keyable;
use loophp\collection\Contract\Operation\Keysable;
use loophp\collection\Contract\Operation\Lastable;
use loophp\collection\Contract\Operation\Limitable;
use loophp\collection\Contract\Operation\Linesable;
use loophp\collection\Contract\Operation\Mapable;
use loophp\collection\Contract\Operation\Matchable;
use loophp\collection\Contract\Operation\Mergeable;
use loophp\collection\Contract\Operation\Normalizeable;
use loophp\collection\Contract\Operation\Nthable;
use loophp\collection\Contract\Operation\Nullsyable;
use loophp\collection\Contract\Operation\Packable;
use loophp\collection\Contract\Operation\Padable;
use loophp\collection\Contract\Operation\Pairable;
use loophp\collection\Contract\Operation\Partitionable;
use loophp\collection\Contract\Operation\Permutateable;
use loophp\collection\Contract\Operation\Pipeable;
use loophp\collection\Contract\Operation\Pluckable;
use loophp\collection\Contract\Operation\Prependable;
use loophp\collection\Contract\Operation\Productable;
use loophp\collection\Contract\Operation\Randomable;
use loophp\collection\Contract\Operation\Rangeable;
use loophp\collection\Contract\Operation\Reductionable;
use loophp\collection\Contract\Operation\Reverseable;
use loophp\collection\Contract\Operation\RSampleable;
use loophp\collection\Contract\Operation\Scaleable;
use loophp\collection\Contract\Operation\ScanLeft1able;
use loophp\collection\Contract\Operation\ScanLeftable;
use loophp\collection\Contract\Operation\ScanRight1able;
use loophp\collection\Contract\Operation\ScanRightable;
use loophp\collection\Contract\Operation\Shuffleable;
use loophp\collection\Contract\Operation\Sinceable;
use loophp\collection\Contract\Operation\Sliceable;
use loophp\collection\Contract\Operation\Sortable;
use loophp\collection\Contract\Operation\Spanable;
use loophp\collection\Contract\Operation\Splitable;
use loophp\collection\Contract\Operation\Squashable;
use loophp\collection\Contract\Operation\Tailable;
use loophp\collection\Contract\Operation\Tailsable;
use loophp\collection\Contract\Operation\TakeWhileable;
use loophp\collection\Contract\Operation\Timesable;
use loophp\collection\Contract\Operation\Transposeable;
use loophp\collection\Contract\Operation\Truthyable;
use loophp\collection\Contract\Operation\Unfoldable;
use loophp\collection\Contract\Operation\Unlinesable;
use loophp\collection\Contract\Operation\Unpackable;
use loophp\collection\Contract\Operation\Unpairable;
use loophp\collection\Contract\Operation\Untilable;
use loophp\collection\Contract\Operation\Unwindowable;
use loophp\collection\Contract\Operation\Unwordsable;
use loophp\collection\Contract\Operation\Unwrapable;
use loophp\collection\Contract\Operation\Unzipable;
use loophp\collection\Contract\Operation\Windowable;
use loophp\collection\Contract\Operation\Wordsable;
use loophp\collection\Contract\Operation\Wrapable;
use loophp\collection\Contract\Operation\Zipable;

/**
 * @template TKey
 * @template T
 *
 * @template-extends Allable<TKey, T>
 */
interface CollectionT extends
    Allable
{
    /**
     * @return Iterator<TKey, T>
     */
    public function getIterator(): Iterator;
}
