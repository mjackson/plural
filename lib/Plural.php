<?php

/**
 * Contains functions that may be used to pluralize words according to the
 * pluralization rules of a given language.
 *
 * @author      Michael J. I. Jackson <michael@mjijackson.com>
 */
class Plural
{

    /**
     * An array of all rules that have been loaded, keyed by language code.
     *
     * @var array
     */
    protected static $_rules = array();

    /**
     * The code of the language currently being used.
     *
     * @var string
     */
    protected static $_currentLanguage;

    /**
     * Tells the pluralizer to use a certain set of rules. In order to use this
     * function, the appropriate rules file must be found in the rules directory.
     *
     * @param   string  $language   The language code
     * @return  bool                True on success, false on failure
     */
    public static function loadLanguage($language)
    {
        if (!isset(self::$_rules[$language])) {
            self::$_rules[$language] = array(
                'plurals'       => array(),
                'irregulars'    => array(),
                'uncountables'  => array()
            );

            $langFile = dirname(__FILE__) . "/rules/$language.php";
            if ((@include_once $langFile) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Sets the {@link Plural::$_currentLanguage current language code}.
     *
     * @param   string  $language   The language code
     * @return  void
     */
    public static function setLanguage($language)
    {
        self::$_currentLanguage = $language;
    }

    /**
     * Adds a plural rule to the internal array of plural rules. May be used to
     * add rules one at a time:
     *
     * <code>
     * Plural::addPlural('/(quiz)$/i', '\1zes');
     * </code>
     *
     * or all at once:
     *
     * <code>
     * Plural::addPlural(array(
     *     '/(quiz)$/i'            => '\1zes',
     *     '/(ss|sh|ch|x|z)$/i'    => '\1es',
     * ));
     * </code>
     *
     * @param   mixed   $rules          An array of rules ($regex => $replace) or
     *                                  a regular expression
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
     * Plural::addIrregular('man', 'men');
     * </code>
     *
     * or all at once:
     *
     * <code>
     * Plural::addIrregular(array(
     *     'man'       => 'men',
     *     'person'    => 'people'
     * ));
     * </code>
     *
     * @param   mixed   $words      The singular form of the irregular noun(s)
     * @param   string  $plural     The plural form of the noun
     * @return  void
     */
    public static function addIrregular($words, $plural='')
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
     * @param   mixed   $words  The word(s) to mark as uncountable
     * @return  void
     */
    public static function addUncountable($words)
    {
        if (!is_array($words)) {
            $words = array($words);
        }
        foreach ($words as $word) {
            self::$_rules[self::$_currentLanguage]['uncountables'][] = $word;
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
        if (!isset(self::$_rules[self::$_currentLanguage])) {
            return $word;
        }

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

        return $word;
    }

}

// load the English language by default
Plural::loadLanguage('en');

