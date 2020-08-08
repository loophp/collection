<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

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
final class Get extends AbstractOperation implements Operation
{
    /**
     * @param int|string $key
     * @param mixed $default
     * @psalm-param T $default
     */
    public function __construct($key, $default)
    {
        $this->storage['key'] = $key;
        $this->storage['default'] = $default;
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $collection, $keyToGet, $default) {
            foreach ($collection as $key => $value) {
                if ($key === $keyToGet) {
                    return $value;
                }
            }

            return $default;
        };
    }
}
