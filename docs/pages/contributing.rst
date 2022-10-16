Contributing
============

Feel free to contribute by sending pull requests. We are a usually very
responsive team and we will help you going through your pull request from the
beginning to the end.

The developers team is always more than happy to receive feedback and pull
requests in this project. Discussions, bug reports, feedback, everything is ok
as long as it is polite and respectful.

The process to contribute is clear and open, everything **must** done on GitHub.

You are more than welcome to contribute to this library for any kind of
modification, as long as they make sense.

If you prefer, you can start by `creating an issue`_ and discuss with us what
you want to do in ``loophp/collection``.

Development environment
-----------------------

This library provides a reproducible development environment based on Nix_.

There are many operating systems, too many Linux distributions and too many
different ways to install the development requirements in this project. If
someone wants to contribute to this project, they either need to be using the
same operating system or they need to spend time figuring out how to install all
the required dependencies, if they exists.

Given that, the best way to build the book is using the Nix_ universal package
manager.

Nix is a tool that takes a unique approach to package management and system
configuration. Nix is platform-agnostic: it runs on any Linux distro and macOS.
Nix can therefore be used as a truly universal package manager.

On top of that, Nix will ensure reproducibility by pinning the dependencies
needed to build the document in the `flake.lock` file. As long as this file stay
the same, we have the guarantee that anyone will be able to contribute to this
library without any trouble.

After `installing Nix`_, if you're using a non-NixOS operating system, you need
to install `nix` in your environment following the steps described on the
`Nix wiki`_ and enable the upcoming Nix `commands` and `flake` support.

Once this is done, you can optionally install `nix-direnv`_ to automatically
load the PHP environment upon directory change, thanks to the file ``.envrc``
available at the root of this project.

The ``.envrc`` file will make sure that the tools you need to develop and
contribute to this projects are available in your shell without typing any
command to install them. The provided developments tools are:

* `php`_ for developing and running the tests,
* `auto-changelog`_ for generating the changelog,
* `sphinx`_ to generate the documentation.

If you're not using `nix-direnv`, you just have to run the following commands to
create a shell containing all the tools you need to develop:

.. code-block:: bash

    nix shell github:loophp/nix-shell#env-php81-nts --impure
    nix shell github:loophp/nix-auto-changelog
    nix shell github:loophp/nix-sphinx

Sponsoring
----------

For some reasons, if you can't contribute to the code and willing to help,
sponsoring is a good, sound and safe way to show us some gratitude for the hours
we invested in this package.

Sponsor any of `the contributors`_ through GitHub.

.. _creating an issue: https://github.com/loophp/collection/issues/new/choose
.. _Nix: https://nixos.org/nix/
.. _installing Nix: https://nixos.org/download.html
.. _Nix wiki: https://nixos.wiki/wiki/Flakes
.. _nix-direnv: https://github.com/nix-community/nix-direnv
.. _the contributors: https://github.com/loophp/collection/graphs/contributors
.. _php: https://www.php.net/
.. _auto-changelog: https://www.npmjs.com/package/auto-changelog
.. _Sphinx: https://www.sphinx-doc.org/
