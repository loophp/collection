<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Forget.
 */
final class Forget extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $keys = $this->parameters;

        return $collection::withClosure(
            static function () use ($keys, $collection) {
                $keys = array_flip($keys);

                foreach ($collection->getIterator() as $key => $value) {
                    if (!\array_key_exists($key, $keys)) {
                        yield $key => $value;
                    }
                }
            }
        );
    }
}
