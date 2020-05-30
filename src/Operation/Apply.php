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
    public function __invoke(): Closure
    {
        $callbacks = $this->callbacks;

        return static function (iterable $collection) use ($callbacks): Generator {
            foreach ($collection as $key => $value) {
                foreach ($callbacks as $callback) {
                    if (true === $callback($value, $key)) {
                        continue;
                    }

                    break;
                }

                yield $key => $value;
            }
        };
    }
}
