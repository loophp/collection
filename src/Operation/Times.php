<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Times.
 */
final class Times implements Operation
{
    /**
     * @var callable|null
     */
    private $callback;

    /**
     * @var float|int
     */
    private $number;

    /**
     * Times constructor.
     *
     * @param float|int $number
     * @param callable|null $callback
     */
    public function __construct($number, ?callable $callback = null)
    {
        $this->number = $number;
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $number = $this->number;
        $callback = $this->callback;

        return static function (iterable $collection) use ($number, $callback): Generator {
            if (1 > $number) {
                return;
            }

            if (null === $callback) {
                $callback = static function (int $value): int {
                    return $value;
                };
            }

            for ($current = 1; $current <= $number; ++$current) {
                yield $callback($current);
            }
        };
    }
}
