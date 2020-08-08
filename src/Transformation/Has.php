<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;
use loophp\collection\Transformation\AbstractTransformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Has extends AbstractTransformation implements Transformation
{
    /**
     * @psalm-param callable(TKey, T):(bool) $callback
     */
    public function __construct(callable $callback)
    {
        $this->storage['callback'] = $callback;
    }

    public function __invoke()
    {
        return static function (Iterator $collection, callable $callback) {
            foreach ($collection as $key => $value) {
                if ($callback($key, $value) === $value) {
                    return true;
                }
            }

            return false;
        };
    }
}
