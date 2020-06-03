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
    public function __invoke(): Closure
    {
        $callbacks = $this->callbacks;

        return static function (iterable $collection) use ($callbacks): Generator {
            foreach ($collection as $key => $value) {
                yield $key => $value;

                $result = 1;

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
