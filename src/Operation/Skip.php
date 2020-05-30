<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

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
    public function __invoke(): Closure
    {
        $skip = $this->skip;

        return static function (iterable $collection) use ($skip): Generator {
            $skip = array_sum($skip);

            foreach ($collection as $key => $value) {
                if (0 < $skip--) {
                    continue;
                }

                yield $key => $value;
            }
        };
    }
}
