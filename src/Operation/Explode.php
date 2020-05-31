<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\collection\Contract\Operation;

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
        return (new Split(
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
                $this->explodes
            )
        ))();
    }
}
