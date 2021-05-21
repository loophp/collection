<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use InvalidArgumentException;
use loophp\collection\Iterator\ResourceIterator;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use function is_resource;

class ResourceIteratorSpec extends ObjectBehavior
{
    public function it_can_iterate(): void
    {
        $this->beConstructedWith(fopen('data://text/plain,ABCD', 'rb'));

        $this->getInnerIterator()->shouldIterateAs(['A', 'B', 'C', 'D']);
    }

    public function it_closes_opened_file(): void
    {
        $file = fopen(__DIR__ . '/../../../fixtures/sample.txt', 'rb');

        $this->beConstructedWith($file);

        $this->getInnerIterator()->shouldIterateAs(['a', 'b', 'c']);

        if (is_resource($file)) {
            throw new FailureException('Failed to close resource!');
        }
    }

    public function it_does_not_allow_non_resource(): void
    {
        $this->beConstructedWith(false);

        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_does_not_allow_unsupported_resource(): void
    {
        $this->beConstructedWith(imagecreate(100, 100));

        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_is_initializable(): void
    {
        $file = fopen(__DIR__ . '/../../../fixtures/sample.txt', 'rb');

        $this->beConstructedWith($file);

        $this->shouldHaveType(ResourceIterator::class);
    }
}
