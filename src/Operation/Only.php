<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Only.
 */
final class Only extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$keys] = $this->parameters;

        return Collection::with(
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
