<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use InvalidArgumentException;
use Iterator;

use function get_class;
use function gettype;
use function is_object;

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
     * @param Iterator<TKey, T> $iterator
     * @param null|callable(mixed): string $getType
     */
    public function __construct(Iterator $iterator, ?callable $getType = null)
    {
        $getType ??=
            /**
             * @param mixed $variable
             */
            static function ($variable): string {
                if (!is_object($variable)) {
                    return gettype($variable);
                }

                $interfaces = class_implements($variable);

                if ([] === $interfaces || false === $interfaces) {
                    return get_class($variable);
                }

                sort($interfaces);

                return implode(',', $interfaces);
            };

        $this->iterator = new ClosureIterator(
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T|null>
             */
            static function (Iterator $iterator) use ($getType): Generator {
                $previousType = null;

                foreach ($iterator as $key => $value) {
                    if (null === $value) {
                        yield $key => $value;

                        continue;
                    }

                    $currentType = $getType($value);
                    $previousType ??= $currentType;

                    if ($currentType !== $previousType) {
                        throw new InvalidArgumentException(
                            sprintf(
                                "Detected mixed types: '%s' and '%s' !",
                                $previousType,
                                $currentType
                            )
                        );
                    }

                    yield $key => $value;
                }
            },
            [$iterator]
        );
    }
}
