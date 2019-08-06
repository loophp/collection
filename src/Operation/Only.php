<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Only.
 */
final class Only extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $keys = $this->parameters;

        return $collection::withClosure(
            static function () use ($keys, $collection) {
                if ([] === $keys) {
                    yield from $collection;
                } else {
                    $keys = array_flip($keys);

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
