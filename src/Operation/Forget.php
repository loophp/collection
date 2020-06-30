<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

use function array_key_exists;

final class Forget extends AbstractOperation implements Operation
{
    /**
     * Forget constructor.
     *
     * @param mixed ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage['keys'] = $keys;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, mixed> $keys
             * @param iterable $collection
             */
            static function (iterable $collection, array $keys): Generator {
                $keys = array_flip($keys);

                foreach ($collection as $key => $value) {
                    if (false === array_key_exists($key, $keys)) {
                        yield $key => $value;
                    }
                }
            };
    }
}
