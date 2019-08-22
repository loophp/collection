<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Skip.
 */
final class Skip extends Operation
{
    /**
     * Skip constructor.
     *
     * @param int ...$skip
     */
    public function __construct(int ...$skip)
    {
        parent::__construct(...[$skip]);
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$counts] = $this->parameters;

        return static function () use ($counts, $collection): \Generator {
            $iterator = $collection->getIterator();
            $counts = \array_sum($counts);

            foreach ($iterator as $key => $item) {
                if (0 < $counts--) {
                    continue;
                }

                break;
            }

            if ($iterator->valid()) {
                yield from $iterator;
            }
        };
    }
}
