<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation as CollectionOperation;

/**
 * Class Operation.
 */
abstract class Operation implements CollectionOperation
{
    /**
     * @var array|mixed[]
     */
    protected $parameters;

    /**
     * @param mixed ...$parameters
     *
     * @return \drupol\collection\Contract\Operation
     */
    public static function with(...$parameters): CollectionOperation
    {
        $instance = new static();

        $instance->parameters = $parameters;

        return $instance;
    }
}
