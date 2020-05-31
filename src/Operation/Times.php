<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use loophp\collection\Contract\Operation;

/**
 * Class Times.
 */
final class Times implements Operation
{
    /**
     * @var callable
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
        if (1 > $number) {
            throw new InvalidArgumentException('Invalid parameter. $number must be greater than 1.');
        }

        $this->number = $number;

        $this->callback = $callback ?? static function (int $value): int {
            return $value;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $number = $this->number;
        $callback = $this->callback;

        return static function () use ($number, $callback): Generator {
            for ($current = 1; $current <= $number; ++$current) {
                yield $callback($current);
            }
        };
    }
}
