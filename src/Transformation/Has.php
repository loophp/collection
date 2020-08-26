<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Has implements Transformation
{
    public function __invoke()
    {
        return static function (callable $callback): Closure {
            return static function (Iterator $iterator) use ($callback): bool {
                foreach ($iterator as $key => $value) {
                    if ($callback($key, $value) === $value) {
                        return true;
                    }
                }

                return false;
            };
        };
    }
}
