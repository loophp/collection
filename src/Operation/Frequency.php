<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, Generator<int, T>>
 * @implements Operation<TKey, T, Generator<int, T>>
 */
final class Frequency extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, T>
             */
            static function (Iterator $iterator): Generator {
                $storage = [];

                foreach ($iterator as $value) {
                    $added = false;

                    foreach ($storage as $key => $data) {
                        if ($data['value'] !== $value) {
                            continue;
                        }

                        ++$storage[$key]['count'];
                        $added = true;

                        break;
                    }

                    if (true === $added) {
                        continue;
                    }

                    $storage[] = [
                        'value' => $value,
                        'count' => 1,
                    ];
                }

                foreach ($storage as $value) {
                    yield $value['count'] => $value['value'];
                }
            };
    }
}
