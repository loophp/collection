<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Limit.
 */
final class Limit extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
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
