<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use InvalidArgumentException;

use function count;
use function gettype;
use function in_array;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class TypedIterator extends ProxyIterator
{
    /**
     * @param iterable<TKey, T> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            static function (iterable $iterator): Generator {
                $allowedTypes = ['NULL'];

                foreach ($iterator as $key => $value) {
                    $currentType = gettype($value);

                    if (count($allowedTypes) < 2) {
                        $allowedTypes[] = $currentType;
                    }

                    if (!in_array($currentType, $allowedTypes, true)) {
                        throw new InvalidArgumentException(
                            sprintf(
                                'Detected mixed types: %s and %s!',
                                $allowedTypes[1],
                                $currentType
                            )
                        );
                    }

                    yield $key => $value;
                }
            },
            $iterable
        );
    }
}
