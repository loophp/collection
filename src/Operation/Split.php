<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Split.
 */
final class Split implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Split constructor.
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
            $carry = [];

            foreach ($collection as $key => $value) {
                $carry[] = $value;

                foreach ($callbacks as $callback) {
                    if (true !== $callback($value, $key)) {
                        continue;
                    }

                    yield $carry;

                    $carry = [];
                }
            }

            if ([] !== $carry) {
                yield $carry;
            }
        };
    }
}
