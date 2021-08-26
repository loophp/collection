<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\ClosureExpressionVisitor;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation\Sortable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Matching extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Criteria): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (Criteria $criteria): Closure {
                $expr = $criteria->getWhereExpression();
                $pipes = [];

                if (null !== $expr) {
                    $pipes[] = (new Filter())()((new ClosureExpressionVisitor())->dispatch($expr));
                }

                $orderings = $criteria->getOrderings();

                if ([] !== $orderings) {
                    $next = null;

                    foreach (array_reverse($orderings) as $field => $ordering) {
                        $next = ClosureExpressionVisitor::sortByField($field, Criteria::DESC === $ordering ? -1 : 1, $next);
                    }

                    $pipes[] = Sort::of()(Sortable::BY_VALUES)($next);
                }

                $offset = $criteria->getFirstResult();
                $length = $criteria->getMaxResults();

                if (null !== $offset || null !== $length) {
                    $pipes[] = Limit::of()($length)((int) $offset);
                }

                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                $pipe = Pipe::of()(...$pipes);

                // Point free style.
                return $pipe;
            };
    }
}
