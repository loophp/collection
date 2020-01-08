<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Apply.
 */
final class Apply implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Apply constructor.
     *
     * @param callable ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $callbacks = $this->callbacks;

        return static function () use ($callbacks, $collection): Generator {
            foreach ($collection as $key => $value) {
                foreach ($callbacks as $callback) {
                    $callback($value, $key);
                }

                yield $key => $value;
            }
        };
    }
}
