<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;

/**
 * Class Implode.
 */
final class Implode implements Transformation
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
        $result = '';

        foreach ($collection as $value) {
            $result .= $value . $this->glue;
        }

        return \rtrim($result, $this->glue);
    }
}
