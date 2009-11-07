<?php

require_once 'PHPUnit/Framework.php';

require_once dirname(dirname(__FILE__)) . '/lib/Plural.php';

class PluralTest extends PHPUnit_Framework_TestCase
{

    public function testPlurals()
    {
        $this->assertEquals(Plural::pluralize('matrix'), 'matrices');
        $this->assertEquals(Plural::pluralize('quiz'), 'quizzes');
        $this->assertEquals(Plural::pluralize('glass'), 'glasses');
        $this->assertEquals(Plural::pluralize('match'), 'matches');
        $this->assertEquals(Plural::pluralize('hero'), 'heroes');
        $this->assertEquals(Plural::pluralize('cherry'), 'cherries');
        $this->assertEquals(Plural::pluralize('diagnosis'), 'diagnoses');
        $this->assertEquals(Plural::pluralize('mouse'), 'mice');
        $this->assertEquals(Plural::pluralize('medium'), 'media');
        $this->assertEquals(Plural::pluralize('knife'), 'knives');
        $this->assertEquals(Plural::pluralize('shelf'), 'shelves');
        $this->assertEquals(Plural::pluralize('syllabus'), 'syllabi');
        $this->assertEquals(Plural::pluralize('octopus'), 'octopi');
        $this->assertEquals(Plural::pluralize('axis'), 'axes');
        $this->assertEquals(Plural::pluralize('dogs'), 'dogs');
        $this->assertEquals(Plural::pluralize('dog'), 'dogs');
    }

    public function testIrregulars()
    {
        $this->assertEquals(Plural::pluralize('bus'), 'busses');
        $this->assertEquals(Plural::pluralize('child'), 'children');
        $this->assertEquals(Plural::pluralize('man'), 'men');
        $this->assertEquals(Plural::pluralize('person'), 'people');
        $this->assertEquals(Plural::pluralize('news'), 'news');
        $this->assertEquals(Plural::pluralize('money'), 'money');
        $this->assertEquals(Plural::pluralize('rice'), 'rice');
        $this->assertEquals(Plural::pluralize('sheep'), 'sheep');
        $this->assertEquals(Plural::pluralize('fish'), 'fish');
        $this->assertEquals(Plural::pluralize('species'), 'species');
    }

}

