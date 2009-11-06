<?php

Plural::setLanguage(basename(__FILE__, '.php'));

// plural word rules. each rule is a regular expression and its replacement
// note: order here is important!
Plural::addPlural(array(
    '/(matr|vert|ind)(ix|ex)$/i'    => '\1ices',    // matrix, vertex, index
    '/(quiz)$/i'                    => '\1zes',     // quiz
    '/(ss|sh|ch|x|z)$/i'            => '\1es',      // sibilant rule (no ending e)
    '/([^aeiou])o$/i'               => '\1oes',     // -oes rule
    '/([^aeiou]|qu)y$/i'            => '\1ies',     // -ies rule
    '/sis$/i'                       => 'ses',       // synopsis, diagnosis
    '/(m|l)ouse$/i'                 => '\1ice',     // mouse, louse
    '/(t|i)um$/i'                   => '\1a',       // datum, medium
    '/([li])fe?$/i'                 => '\1ves',     // knife, life, shelf
    '/(octop|vir)us$/i'             => '\1i',       // octopus, virus
    '/(ax|test)is$/i'               => '\1es',      // axis, testis
    '/s$/i'                         => 's',         // all other s
    '/$/'                           => 's'          // catch all
));

// words that don't follow any pluralization rules
Plural::addIrregular(array(
    'man'       => 'men',
    'person'    => 'people',
    'child'     => 'children'
));

// words whose singular and plural forms are the same
Plural::addUncountable(array(
    'news',
    'money',
    'equipment',
    'information',
    'rice',
    'species',
    'series',
    'fish',
    'sheep',
    'moose'
));

