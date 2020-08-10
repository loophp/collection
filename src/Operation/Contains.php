<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Contains extends AbstractOperation implements Operation
{
    /**
     * @param mixed ...$values
     * @psalm-param T ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = new ArrayIterator($values);
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $collection
             */
            static function (Iterator $collection, ArrayIterator $values): bool {
                return (new Run())()(
                    $values,
                    new FoldLeft(
                        /**
                         * @psalm-param T $item
                         * @psalm-param TKey $key
                         *
                         * @param mixed $item
                         * @param mixed $key
                         */
                        static function (bool $carry, $item, $key) use ($collection): bool {
                            $hasCallback =
                                /**
                                 * @psalm-param TKey $k
                                 * @psalm-param T $v
                                 *
                                 * @psalm-return T
                                 *
                                 * @param mixed $k
                                 * @param mixed $v
                                 *
                                 * @return mixed
                                 */
                                static function ($k, $v) use ($item) {
                                    return $item;
                                };

                            /** @psalm-var bool $return */
                            $return = ((new Run()))()($collection, new Has($hasCallback));

                            return $return ?
                                $carry :
                                false;
                        },
                        true
                    )
                );
            };
    }
}
