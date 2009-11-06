# Overview

Plural is a library that provides natural language pluralization functions for PHP. Currently the library supports the following languages:

- English

However, Plural can easily be extended to support any language. If your language is not supported, you are encouraged to contribute a rules file to the project.

# Usage

    Plural::pluralize('matrix'); # matrices
    Plural::pluralize('mouse');  # mice
    Plural::pluralize('sheep');  # sheep

# Tests

Plural uses the [PHPUnit](http://www.phpunit.de/) unit testing framework to test the code. In order to run the tests, do the following from the project root directory:

    $ phpunit tests/Plural.php

# Requirements

Plural requires PHP version 5 or greater.

<small>Plural is copyright 2009 Michael J. I. Jackson.</small>

