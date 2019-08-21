<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Manipulator;

/**
 * Class Operation.
 */
abstract class Operation implements Manipulator
{
    /**
     * @var array|mixed[]
     */
    protected $parameters;

    /**
     * @param mixed ...$parameters
     *
     * @return \drupol\collection\Operation\Operation
     */
    public static function with(...$parameters): Manipulator
    {
        $instance = new static();

        $instance->parameters = $parameters;

        return $instance;
    }
}
