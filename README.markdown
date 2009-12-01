### Overview

Plural is a library that provides natural language pluralization functions for PHP. The library currently supports the following languages:

- English

However, Plural can easily be extended to support any language. If your language is not supported, you are encouraged to contribute a rules file to the project.

### Usage

    plural('dog');      # dogs
    plural('matrix');   # matrices
    plural('mouse');    # mice
    plural('person');   # people
    plural('sheep');    # sheep

### Tests

Plural uses the [PHPUnit](http://www.phpunit.de/) unit testing framework to test the code. In order to run the tests, do the following from the project root directory:

    $ phpunit tests/Plural.php

### Requirements

Plural requires PHP version 5 or greater.

### License

Plural is released under the terms of the MIT license. Please read the LICENSE file for further information.
