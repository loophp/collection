Tests, code quality and code style
==================================

Every time changes are introduced into the library, `Github Actions`_
run the tests.

Tests are written with `PHPSpec`_ and you can find the coverage percentage on a badge on the README file.

`PHPInfection`_ is also triggered used to ensure that your code is properly tested.

The code style is based on `PSR-12`_ plus a set of custom rules.
Find more about the code style in use in the package `drupol/php-conventions`_.

A PHP quality tool, Grumphp_, is used to orchestrate all these tasks at each commit
on the local machine, but also on the continuous integration tools.

To run the whole tests tasks locally, do

.. code-block:: bash

    composer grumphp

or

.. code-block:: bash

    ./vendor/bin/grumphp run

Here's an example of output that shows all the tasks that are setup in Grumphp and that
will check your code

.. code-block:: bash

    $ ./vendor/bin/grumphp run
    GrumPHP is sniffing your code!
    Running task  1/14: SecurityChecker... ✔
    Running task  2/14: Composer... ✔
    Running task  3/14: ComposerNormalize... ✔
    Running task  4/14: YamlLint... ✔
    Running task  5/14: JsonLint... ✔
    Running task  6/14: PhpLint... ✔
    Running task  7/14: TwigCs... ✔
    Running task  8/14: PhpCsAutoFixerV2... ✔
    Running task  9/14: PhpCsFixerV2... ✔
    Running task 10/14: Phpcs... ✔
    Running task 11/14: Psalm... ✔
    Running task 12/14: PhpStan... ✔
    Running task 13/14: Phpspec... ✔
    Running task 14/14: Infection... ✔
    $

.. _PSR-12: https://www.php-fig.org/psr/psr-12/
.. _drupol/php-conventions: https://github.com/drupol/php-conventions
.. _Github Actions: https://github.com/loophp/collection/actions
.. _PHPSpec: http://www.phpspec.net/
.. _PHPInfection: https://github.com/infection/infection
.. _Grumphp: https://github.com/phpro/grumphp