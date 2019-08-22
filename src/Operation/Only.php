<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Only.
 */
final class Only extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$keys] = $this->parameters;

        return $collection::with(
            static function () use ($keys, $collection): \Generator {
                if ([] === $keys) {
                    yield from $collection;
                } else {
                    $keys = \array_flip($keys);

                    foreach ($collection as $key => $value) {
                        if (\array_key_exists($key, $keys)) {
                            yield $key => $value;
                        }
                    }
                }
            }
        );
    }
}
