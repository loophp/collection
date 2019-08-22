<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation as CollectionOperation;

/**
 * Class Operation.
 */
abstract class Operation implements CollectionOperation
{
    /**
     * @var mixed
     */
    protected $parameters;

    /**
     * Operation constructor.
     *
     * @param mixed ...$parameters
     */
    public function __construct(...$parameters)
    {
        $this->parameters = $parameters;
    }
}
