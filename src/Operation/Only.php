<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

use function array_key_exists;

final class Only extends AbstractOperation implements Operation
{
    /**
     * Only constructor.
     *
     * @param mixed ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage = [
            'keys' => $keys,
        ];
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, array $keys): Generator {
            if ([] === $keys) {
                return yield from $collection;
            }

            $keys = array_flip($keys);

            foreach ($collection as $key => $value) {
                if (true === array_key_exists($key, $keys)) {
                    yield $key => $value;
                }
            }
        };
    }
}
