<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Walk.
 */
final class Walk extends Operation
{
    /**
     * Walk constructor.
     *
     * @param callable ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        parent::__construct(...[$callbacks]);
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$callbacks] = $this->parameters;

        return $collection::with(
            static function () use ($callbacks, $collection): \Generator {
                $callback = static function ($carry, $callback) {
                    return $callback($carry);
                };

                foreach ($collection as $key => $value) {
                    yield $key => \array_reduce($callbacks, $callback, $value);
                }
            }
        );
    }
}
