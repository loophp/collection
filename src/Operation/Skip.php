<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Skip.
 */
final class Skip implements Operation
{
    /**
     * @var int[]
     */
    private $skip;

    /**
     * Skip constructor.
     *
     * @param int ...$skip
     */
    public function __construct(int ...$skip)
    {
        $this->skip = $skip;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $skip = $this->skip;

        return static function () use ($skip, $collection): \Generator {
            $skip = \array_sum($skip);

            foreach ($collection as $key => $value) {
                if (0 < $skip--) {
                    continue;
                }

                yield $key => $value;
            }
        };
    }
}
