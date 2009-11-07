<?php

Plural::setLanguage(basename(__FILE__, '.php'));

// plural word rules. each rule is a regular expression and its replacement
// note: order here is important!
Plural::addRules(array(
    '/(matr|vert|ind)(ix|ex)$/i'    => '\1ices',    // matrix, vertex, index
    '/(ss|sh|ch|x|z)$/i'            => '\1es',      // sibilant rule (no ending e)
    '/([^aeiou])o$/i'               => '\1oes',     // -oes rule
    '/([^aeiou]|qu)y$/i'            => '\1ies',     // -ies rule
    '/sis$/i'                       => 'ses',       // synopsis, diagnosis
    '/(m|l)ouse$/i'                 => '\1ice',     // mouse, louse
    '/(t|i)um$/i'                   => '\1a',       // datum, medium
    '/([li])fe?$/i'                 => '\1ves',     // knife, life, shelf
    '/(octop|vir)us$/i'             => '\1i',       // octopus, virus
    '/(ax|test)is$/i'               => '\1es',      // axis, testis
    '/([a-rt-z])$/i'                => '\1s'        // not ending in s
));

// words that don't follow any pluralization rules
Plural::addIrregulars(array(
    'child'         => 'children',
    'man'           => 'men',
    'person'        => 'people',
    'quiz'          => 'quizzes',
    'syllabus'      => 'syllabi',
    // words whose singular and plural forms are the same
    'equipment'     => 'equipment',
    'fish'          => 'fish',
    'information'   => 'information',
    'money'         => 'money',
    'moose'         => 'moose',
    'news'          => 'news',
    'rice'          => 'rice',
    'series'        => 'series',
    'sheep'         => 'sheep',
    'species'       => 'species'
));

