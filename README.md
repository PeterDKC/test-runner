# Test Runners

Test Runners provides a consistent set of composer commands to run, filter, and view coverage on your project's PHPUnit test suite.

## Installation

Install the package via `composer`:

```bash
composer require peterdkc/test-runners
```

Add the following as desired to your project's `composer.json` file in the `scripts` section:

```json
"scripts": {
    "test": "PeterDKC\\TestRunner::test",
    "repeat": "PeterDKC\\TestRunner::repeatTest",
    "filter": "PeterDKC\\TestRunner::filterTests",
    "coverage-text": "PeterDKC\\TestRunner::coverageText",
    "coverage-clover": "PeterDKC\\TestRunner::coverageClover",
    "coverage-full": "PeterDKC\\TestRunner::coverageFull",
    "filter-coverage": "PeterDKC\\TestRunner::filterCoverage"
}
```

Install `pcov` according to the [instructions found here](https://github.com/krakjoe/pcov) in order to run test coverage.

## Usage

Testing and running coverage normally can be run like any other composer scripts.

```bash
composer test
```

or

```bash
composer coverage-full
```

However, `filter` and `repeat` require arguments

```bash
composer filter aTestNameOrClassToFilterTo
```

```bash
compsoer repeat 30 aTestFilterToRunThirtyTimes
```
