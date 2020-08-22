<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class First extends AbstractOperation implements Operation
{
    /**
     * @var callable
     * @psalm-var callable(T, TKey):(bool)
     */
    private $callback;

    /**
     * @psalm-param callable(T, TKey):(bool)|null $callback
     *
     * @psalm-param T|null $default
     */
    public function __construct(?callable $callback = null, int $size = 1)
    {
        $defaultCallback =
            /**
             * @param mixed $value
             * @param mixed $key
             * @psalm-param T $value
             * @psalm-param TKey $key
             * @psalm-param Iterator<TKey, T> $iterator
             */
            static function ($value, $key, Iterator $iterator): bool {
                return true;
            };

        $this->storage = [
            'callback' => $callback ?? $defaultCallback,
            'size' => $size,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, callable $callback, int $size): Generator {
                $callback =
                    /**
                     * @param mixed $value
                     * @param mixed $key
                     * @psalm-param T $value
                     * @psalm-param TKey $key
                     * @psalm-param Iterator<TKey, T> $iterator
                     */
                    static function ($value, $key, Iterator $iterator) use ($callback): bool {
                        return true === $callback($value, $key, $iterator);
                    };

                return yield from (new Run(new Filter($callback), new Limit($size)))($iterator);
            };
    }
}
