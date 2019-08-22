<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Contains.
 */
final class Contains extends Operation
{
    /**
     * Contains constructor.
     *
     * @param mixed $key
     */
    public function __construct($key)
    {
        parent::__construct(...[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection)
    {
        [$key] = $this->parameters;

        if (!\is_string($key) && \is_callable($key)) {
            $placeholder = new \stdClass();

            return (new First($key, $placeholder))->run($collection) !== $placeholder;
        }

        foreach ($collection as $value) {
            if ($value === $key) {
                return true;
            }
        }

        return false;
    }
}
