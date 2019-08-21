<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Limit.
 */
final class Limit extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$limit] = $this->parameters;

        return Collection::with(
            static function () use ($limit, $collection): \Generator {
                $i = 0;

                foreach ($collection as $key => $value) {
                    yield $key => $value;

                    if (++$i === $limit) {
                        break;
                    }
                }
            }
        );
    }
}
