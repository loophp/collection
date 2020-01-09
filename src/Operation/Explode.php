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
     * @var array<mixed>
     */
    private $explodes;

    /**
     * Explode constructor.
     *
     * @param mixed ...$explodes
     */
    public function __construct(...$explodes)
    {
        $this->explodes = $explodes;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $callbacks = array_map(
            static function ($explode) {
                return static function ($value) use ($explode): bool {
                    return $value === $explode;
                };
            },
            $this->explodes
        );

        return (new Split(...$callbacks))->on($collection);
    }
}
