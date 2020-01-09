<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Until.
 */
final class Until implements Operation
{
    /**
     * @var array<callable>
     */
    private $callbacks;

    /**
     * Until constructor.
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
                yield $key => $value;

                $result = true;

                foreach ($callbacks as $callback) {
                    $result &= $callback($value, $key);
                }

                if (1 === $result) {
                    break;
                }
            }
        };
    }
}
