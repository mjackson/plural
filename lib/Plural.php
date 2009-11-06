<?php

/**
 * Contains functions that may be used to pluralize words according to the
 * pluralization rules of a given language.
 *
 * @author      Michael J. I. Jackson <michael@mjijackson.com>
 */
class Plural
{

    protected static $_rules = array();
    protected static $_currentLanguage;

    /**
     * Tells the pluralizer to use a certain set of rules. In order to use this
     * function, the appropriate rules file must be found in the rules directory.
     *
     * @param   string  $lang   The language to use
     * @return  bool            True on success, false on failure
     */
    public static function setLanguage($language)
    {
        if (!isset(self::$_rules[$language])) {
            self::$_rules[$language] = array(
                'plurals'       => array(),
                'irregulars'    => array(),
                'uncountables'  => array()
            );

            $oldLanguage = self::$_currentLanguage;
            self::$_currentLanguage = $language;

            $langFile = dirname(__FILE__) . "/rules/$language.php";
            if ((@include_once $langFile) === false) {
                self::$_currentLanguage = $oldLanguage;
                return false;
            }
        }

        return true;
    }

    /**
     * Adds a plural rule to the inflector's internal array of plural rules.
     * May be used to add rules one at a time:
     *
     * <code>
     * Inflector::addPlural('/(quiz)$/i', '\1zes');
     * </code>
     *
     * or all at once:
     *
     * <code>
     * Inflector::addPlural(array(
     *     '/(quiz)$/i'            => '\1zes',
     *     '/(ss|sh|ch|x|z)$/i'    => '\1es',
     * ));
     * </code>
     *
     * @param   mixed   $rules          An array of rules ($re => $replace) or
     *                                  a regular expression string
     * @param   string  $replacement    If rules is a string, the replacement
     *                                  to use in case of a match
     * @return  void
     */
    public static function addPlural($rules, $replacement='')
    {
        if (!is_array($rules)) {
            $rules = array($rules => $replacement);
        }
        foreach ($rules as $regex => $replace) {
            self::$_rules[self::$_currentLanguage]['plurals'][$regex] = $replace;
        }
    }

    /**
     * Adds an irregular plural rule to the inflector's internal array of
     * plural rules. May be used to add rules one at a time:
     *
     * <code>
     * Inflector::addIrregular('man', 'men');
     * </code>
     *
     * or all at once:
     *
     * <code>
     * Inflector::addIrregular(array(
     *     'man'       => 'men',
     *     'person'    => 'people'
     * ));
     * </code>
     *
     * @param   mixed   $rules  The singular form of the noun or an array of irregular nouns
     * @param   string  $plural The plural form of the noun
     * @return  void
     */
    public static function addIrregular($words, $plural = '')
    {
        if (!is_array($words)) {
            $words = array($words => $plural);
        }
        foreach ($words as $singular => $plural) {
            self::$_rules[self::$_currentLanguage]['irregulars'][$singular] = $plural;
        }
    }

    /**
     * Marks a word as uncountable, meaning that the plural form of the word
     * is the same as its singular form.
     *
     * @param   mixed   $word   The word (or an array of words) to mark as uncountable
     * @return  void
     */
    public static function addUncountable($words)
    {
        if (!is_array($words)) {
            $words = array($words);
        }
        foreach ($words as $word) {
            self::$_rules[self::$_currentLanguage]['uncountables'][] = trim($word);
        }
    }

    /**
     * Converts a singular noun to its plural form.
     *
     * @param   string  $word   The singular word
     * @return  string          The word pluralized
     */
    public static function pluralize($word)
    {
        $word = trim($word);
        $rules = self::$_rules[self::$_currentLanguage];

        if (in_array($word, $rules['uncountables'])) {
            return $word;
        }
        if (isset($rules['irregulars'][$word])) {
            return $rules['irregulars'][$word];
        }
        foreach ($rules['plurals'] as $regex => $replace) {
            $word = preg_replace($regex, $replace, $word, 1, $count);
            if ($count) {
                return $word;
            }
        }
    }

}

// use English as the default language
Plural::setLanguage('en');

