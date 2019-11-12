<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Until.
 */
final class Until implements Operation
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * Until constructor.
     *
     * @param callable $until
     */
    public function __construct(callable $until)
    {
        $this->callable = $until;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $until = $this->callable;

        return static function () use ($until, $collection): Generator {
            foreach ($collection as $key => $value) {
                yield $key => $value;

                if (true === $until($value, $key)) {
                    break;
                }
            }
        };
    }
}
