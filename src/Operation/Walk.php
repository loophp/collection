<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Walk.
 */
final class Walk implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Walk constructor.
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
    public function __invoke(): Closure
    {
        $callbacks = $this->callbacks;

        return static function (iterable $collection) use ($callbacks): Generator {
            foreach ($collection as $key => $value) {
                // Custom array_reduce function with the key passed in argument.
                foreach ($callbacks as $callback) {
                    $value = $callback($value, $key);
                }

                yield $key => $value;
            }
        };
    }
}
