<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Explode.
 */
final class Explode implements Operation
{
    /**
     * @var string[]
     */
    private $explodes;

    /**
     * Explode constructor.
     *
     * @param string ...$explodes
     */
    public function __construct(string ...$explodes)
    {
        $this->explodes = $explodes;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $callbacks = \array_map(
            static function ($explode) {
                return static function ($value) use ($explode) {
                    return $value === $explode;
                };
            },
            $this->explodes
        );

        return (new Split(...$callbacks))->on($collection);
    }
}
