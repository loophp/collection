<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;

use function array_slice;
use function count;
use function is_array;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Convolve extends AbstractOperation
{
    /**
     * @template UKey
     * @template U
     */
    public function __invoke(): Closure
    {
        return
            static fn (callable $mult): Closure =>
            static fn (callable $add): Closure =>
            static fn (array $kernel): Closure =>
            static function (iterable $iterable) use ($kernel, $mult, $add) {
                $callable = static fn (array $a, array $b): int =>
                    (
                        (new Reduce())()($add)(0)(
                            (new Map())()(static fn (array $a): int => array_reduce($a, $mult, 1))(
                                (new Zip())()($b)($a)
                            )
                        )
                    )->current();

                $kernelSize = count($kernel) - 1;
                $window = (new Window())()($kernelSize);

                $zip = (new Zip())()($window($kernel))($window($iterable));

                $lastRight = null;
                $left = [];

                foreach ($zip as [$left, $right]) {
                    if (!is_array($right) && (null !== $lastRight)) {
                        $right = $lastRight;
                    }

                    yield $callable($left, array_reverse($right));

                    $lastRight = $right;
                }

                for ($i = 1; $i <= $kernelSize; ++$i) {
                    yield $callable(array_slice($left, $i), array_slice(array_reverse($lastRight), 0, -1 * $i));
                }
            };
    }
}
