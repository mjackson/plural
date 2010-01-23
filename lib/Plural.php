<?php

/**
 * Contains functions that may be used to pluralize words according to the
 * pluralization rules of a given language.
 *
 * @author  Michael J. I. Jackson <mjijackson@gmail.com>
 */
class Plural
{

    /**
     * The current version of Plural.
     *
     * @var string
     */
    const VERSION = '0.3';

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
     * Loads the language file for the language with the given language code
     * from the rules directory.
     *
     * @param   string  $language   The language code
     * @return  bool                True on success, false on failure
     */
    public static function loadLanguage($language)
    {
        if (!isset(self::$_rules[$language])) {
            self::$_rules[$language] = array(
                'plural'        => array(),
                'irregular'     => array()
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
     * Adds a plural rule to the internal array of plural rules.
     *
     * @param   string  $regex      The regular expression to match
     * @param   string  $replace    The replacement string to use
     * @return  void
     */
    public static function addRule($regex, $replace)
    {
        self::$_rules[self::$_currentLanguage]['plural'][$regex] = $replace;
    }

    /**
     * Adds many plural rules at once. The $rules array should contain regular
     * expression to replacement value pairs.
     *
     * @param   array
     * @return  void
     * @see     Plural::addRule()
     */
    public static function addRules($rules)
    {
        foreach ($rules as $regex => $replace) {
            self::addRule($regex, $replace);
        }
    }

    /**
     * Adds an irregular plural rule to the internal array of plural rules.
     *
     * @param   string  $singular   The singular form of the word
     * @param   string  $plural     The plural form of the word
     * @return  void
     */
    public static function addIrregular($singular, $plural)
    {
        self::$_rules[self::$_currentLanguage]['irregular'][$singular] = $plural;
    }

    /**
     * Adds many irregular plural rules at once. The $rules array should contain
     * regular expression to replacement value pairs.
     *
     * @param   array
     * @return  void
     * @see     Plural::addIrregular()
     */
    public static function addIrregulars($rules)
    {
        foreach ($rules as $singular => $plural) {
            self::addIrregular($singular, $plural);
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

        if (isset($rules['irregular'][$word])) {
            return $rules['irregular'][$word];
        }
        foreach ($rules['plural'] as $regex => $replace) {
            $word = preg_replace($regex, $replace, $word, 1, $count);
            if ($count) {
                return $word;
            }
        }

        return $word;
    }

}

/**
 * Convenience function for getting the plural form of a singular word.
 *
 * @param   string  $word   The singular word
 * @return  string          The word pluralized
 * @see     Plural::pluralize()
 */
function plural($word)
{
    return Plural::pluralize($word);
}

// load the English language by default
Plural::loadLanguage('en');
