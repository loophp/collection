<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use loophp\collection\Contract\Transformation;

/**
 * Class FoldLeft.
 */
final class FoldLeft implements Transformation
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var mixed
     */
    private $initial;

    /**
     * FoldLeft constructor.
     *
     * @param callable $callback
     * @param mixed|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->callback = $callback;
        $this->initial = $initial;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $callback = $this->callback;
        $initial = $this->initial;

        foreach ($collection as $key => $value) {
            $initial = $callback($initial, $value, $key);
        }

        return $initial;
    }
}
