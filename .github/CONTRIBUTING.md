# CONTRIBUTING

We're using [GitHub Actions](https://docs.github.com/en/actions) as a continuous integration system.
 
For details, see the workflows in [.github/workflows](../.github/workflows). 
 
## Tests

We're using [`grumphp/grumphp`](https://github.com/phpro/grumphp) to drive the development.

Run

```bash
./vendor/bin/grumphp run
```

to run all the tests.

## Coding Standards

We are using [`drupol/php-conventions`](https://github.com/drupol/php-conventions) to enforce coding standards.

Run

```bash
./vendor/bin/grumphp run
```

to automatically detect/fix coding standard violations.
