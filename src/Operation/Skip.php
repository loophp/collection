<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

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
    public function on(iterable $collection): \Closure
    {
        [$counts] = $this->parameters;

        return static function () use ($counts, $collection): \Generator {
            $counts = \array_sum($counts);

            foreach ($collection as $key => $value) {
                if (0 < $counts--) {
                    continue;
                }

                yield $key => $value;
            }
        };
    }
}
