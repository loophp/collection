<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Explode extends AbstractOperation implements Operation
{
    /**
     * Explode constructor.
     *
     * @param float|int|string ...$explodes
     */
    public function __construct(...$explodes)
    {
        $this->storage['explodes'] = $explodes;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, array $explodes): Generator {
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
