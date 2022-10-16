Tests, code quality and code style
==================================

Workflow
--------

Every time changes are introduced into the library, `Github Actions`_
run the tests.

GitHub Actions uses a PHP quality tool, GrumPHP_, to orchestrate all these tasks
at each commit on the local machine, but also in GitHub actions.

This facilitate the job of the contributors, the command to run locally for the
tests is the same as the one that are triggered on the continuous integration.

The GrumPHP_ configuration is provided by the package `drupol/php-conventions`_
which configure a set of default tasks tailored for PHP projects.

To run all the tests tasks locally, do

.. code-block:: bash

    ./vendor/bin/grumphp run

Here's an example of output that shows all the tasks that are setup in GrumPHP_
and that will check your code

.. code-block:: bash

    $ ./vendor/bin/grumphp run
    GrumPHP is sniffing your code!
    Running task  1/13: license... ✔
    Running task  2/13: composer_require_checker... ✔
    Running task  3/13: composer... ✔
    Running task  4/13: composer_normalize... ✔
    Running task  5/13: yamllint... ✔
    Running task  6/13: jsonlint... ✔
    Running task  7/13: phplint... ✔
    Running task  8/13: twigcs... ✔
    Running task  9/13: phpcsfixer... ✔
    Running task 10/13: psalm... ✔
    Running task 11/13: phpstan... ✔
    Running task 12/13: phpunit... ✔
    Running task 13/13: infection... ✔

Static analysis tests
---------------------

Static analysis tests are achieved by running `PHPStan`_ and `PSalm`_ in the
directory ``tests/static-analysis``.

To run the static-analysis tests only, do:

.. code-block:: bash

    ./vendor/bin/grumphp run --tasks=phpstan,psalm

Unit tests
----------

Tests are written with `PHPUnit`_ and you can find the coverage percentage
on a badge on the README file.

`PHPInfection`_ is also triggered used to ensure that your code is properly
tested.

To run the unit tests only, do:

.. code-block:: bash

    ./vendor/bin/grumphp run --tasks=phpunit,infection

Code style
----------

The PHP code style in use is based on `PSR-12`_ plus a set of custom rules, the
rules are defined in the package `drupol/phpcsfixer-configs-php`_.

To run the code style tests only, do:

.. code-block:: bash

    ./vendor/bin/grumphp run --tasks=phpcsfixer

The check other files, we use `Prettier`_. To run ``Prettier`` across the whole
project, do:

.. code-block:: bash

    nix run nixpkgs#nodePackages.prettier --impure -- --write .

Documentation
-------------

The project's documentation is built with `Sphinx`_.
To run a local documentation server and check if your changes are fine, do:

.. code-block:: bash

    sphinx-autobuild ./docs build/docs

.. _PSR-12: https://www.php-fig.org/psr/psr-12/
.. _drupol/php-conventions: https://github.com/drupol/php-conventions
.. _drupol/phpcsfixer-configs-php: https://github.com/drupol/phpcsfixer-configs-php
.. _Github Actions: https://github.com/loophp/collection/actions
.. _PHPUnit: https://www.phpunit.de/
.. _PHPInfection: https://github.com/infection/infection
.. _GrumPHP: https://github.com/phpro/grumphp
.. _PHPStan: https://github.com/phpstan/phpstan
.. _PSalm: https://github.com/vimeo/psalm
.. _Prettier: https://prettier.io/
.. _Sphinx: https://www.sphinx-doc.org/
