<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract;

use Iterator;
use loophp\collection\Contract\Operation\AllableT;
use loophp\collection\Contract\Operation\AppendableT;

/**
 * @template TKey
 * @template T
 *
 * @template-extends AllableT<TKey, T>
 * @template-extends AppendableT<TKey, T>
 */
interface CollectionT extends
    AllableT,
    AppendableT
{
    /**
     * @return Iterator<TKey, T>
     */
    public function getIterator(): Iterator;
}
