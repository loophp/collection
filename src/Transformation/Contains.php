<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use stdClass;

use function is_callable;
use function is_string;

final class Contains implements Transformation
{
    /**
     * @var mixed
     */
    private $key;

    /**
     * Contains constructor.
     *
     * @param mixed $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection)
    {
        $key = $this->key;

        if ((false === is_string($key)) && (true === is_callable($key))) {
            $placeholder = new stdClass();

            return (new First($key, $placeholder))($collection) !== $placeholder;
        }

        foreach ($collection as $value) {
            if ($value === $key) {
                return true;
            }
        }

        return false;
    }
}
