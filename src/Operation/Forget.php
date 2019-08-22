<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Forget.
 */
final class Forget extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$keys] = $this->parameters;

        return static function () use ($keys, $collection): \Generator {
            $keys = \array_flip($keys);

            foreach ($collection as $key => $value) {
                if (!\array_key_exists($key, $keys)) {
                    yield $key => $value;
                }
            }
        };
    }
}
