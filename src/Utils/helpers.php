<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Utils;

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

use function function_exists;

if (!function_exists('collectIterable')) {
    /**
     * @pure
     *
     * @template TKey
     * @template T
     *
     * @param iterable<TKey, T> $iterable
     *
     * @return CollectionInterface<TKey, T>
     */
    function collectIterable(iterable $iterable): CollectionInterface
    {
        return Collection::fromIterable($iterable);
    }
}
