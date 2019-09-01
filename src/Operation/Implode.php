<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Implode.
 */
final class Implode implements Operation
{
    /**
     * @var string
     */
    private $glue;

    /**
     * Implode constructor.
     *
     * @param string $glue
     */
    public function __construct(string $glue = '')
    {
        $this->glue = $glue;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): string
    {
        return \implode($this->glue, (new All())->on($collection));
    }
}
