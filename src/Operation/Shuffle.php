<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Shuffle extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            $data = iterator_to_array((new Run(new Wrap()))($iterator));

            while ([] !== $data) {
                $randomKey = array_rand($data);

                yield key($data[$randomKey]) => current($data[$randomKey]);
                unset($data[$randomKey]);
            }
        };
    }
}
