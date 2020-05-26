<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use loophp\collection\Contract\Transformation;

/**
 * Class FoldRight.
 */
final class FoldRight implements Transformation
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
     * FoldRight constructor.
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

        foreach ((new Reverse())->on($collection)() as $key => $value) {
            $initial = $callback($initial, $value, $key);
        }

        return $initial;
    }
}
