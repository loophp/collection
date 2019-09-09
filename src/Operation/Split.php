<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

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
    public function on(iterable $collection): \Closure
    {
        $callbacks = $this->callbacks;

        return static function () use ($callbacks, $collection): \Generator {
            $carry = new \ArrayIterator();

            foreach ($collection as $key => $value) {
                $carry->append($value);

                foreach ($callbacks as $callback) {
                    if (true !== $callback($value, $key)) {
                        continue;
                    }

                    yield $carry;

                    $carry = new \ArrayIterator();
                }
            }

            if ($carry->count() !== 0) {
                yield $carry;
            }
        };
    }
}
