Tests, code quality and code style
==================================

Every time changes are introduced into the library, `Github Actions`_
run the tests.

Tests are written with `PHPSpec`_.

`PHPInfection`_ is also triggered used to ensure that your code is properly
tested.

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
    Running task  1/13: SecurityChecker... ✔
    Running task  2/13: Composer... ✔
    Running task  3/13: ComposerNormalize... ✔
    Running task  4/13: YamlLint... ✔
    Running task  5/13: JsonLint... ✔
    Running task  6/13: PhpLint... ✔
    Running task  7/13: TwigCs... ✔
    Running task  8/13: PhpCsAutoFixerV2... ✔
    Running task  9/13: PhpCsFixerV2... ✔
    Running task 10/13: Phpcs... ✔
    Running task 11/13: PhpStan... ✔
    Running task 12/13: Phpspec... ✔
    Running task 13/13: Infection... ✔
    $


.. _PSR-12: https://www.php-fig.org/psr/psr-12/
.. _drupol/php-conventions: https://github.com/drupol/php-conventions
.. _Github Actions: https://github.com/drupol/collection/actions
.. _PHPSpec: http://www.phpspec.net/
.. _PHPInfection: https://github.com/infection/infection
.. _Grumphp: https://github.com/phpro/grumphp