<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Implode.
 */
final class Implode extends Operation
{
    /**
     * Implode constructor.
     *
     * @param string $glue
     */
    public function __construct(string $glue = '')
    {
        parent::__construct(...[$glue]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): string
    {
        [$glue] = $this->parameters;

        return \implode($glue, (new All())->on($collection));
    }
}
