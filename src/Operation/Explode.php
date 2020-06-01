<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * Class Explode.
 */
final class Explode implements Operation
{
    /**
     * @var array<float|int|string>
     */
    private $explodes;

    /**
     * Explode constructor.
     *
     * @param float|int|string ...$explodes
     */
    public function __construct(...$explodes)
    {
        $this->explodes = $explodes;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $explodes = $this->explodes;

        return static function (iterable $collection) use ($explodes): Generator {
            yield from (new Run(
                new Split(
                    ...array_map(
                        /**
                         * @param float|int|string $explode
                         */
                        static function ($explode) {
                            return
                                /** @param mixed $value */
                                static function ($value) use ($explode): bool {
                                    return $value === $explode;
                                };
                        },
                        $explodes
                    )
                )
            ))($collection);
        };
    }
}
