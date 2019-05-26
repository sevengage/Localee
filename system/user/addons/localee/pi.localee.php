<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Localee Class
 *
 * @package     ExpressionEngine
 * @category    Plugin
 * @author      Sevengage, Inc. - Special thanks to Daniel Strunk for the assist
 * @copyright   MIT License 2019
 * @link        https://github.com/sevengage
 */
class Localee
{
    const MONTHS = [
        'January' => [
            'de' => 'Januar',
            'fr' => 'janvier',
            'nl' => 'januari',
            'pl' => 'Styczeń',
            'cz' => 'Leden',
        ],

        'February' => [
            'de' => 'Februar',
            'fr' => 'février',
            'nl' => 'februari',
            'pl' => 'Luty',
            'cz' => 'Únor',
        ],

        'March' => [
            'de' => 'März',
            'fr' => 'mars',
            'nl' => 'maart',
            'pl' => 'Marzec',
            'cz' => 'Březen',
        ],

        'April' => [
            'de' => 'April',
            'fr' => 'avril',
            'nl' => 'april',
            'pl' => 'Kwiecień',
            'cz' => 'Duben',
        ],

        'May' => [
            'de' => 'Mai',
            'fr' => 'mai',
            'nl' => 'mei',
            'pl' => 'Maj',
            'cz' => 'Květen',
        ],

        'June' => [
            'de' => 'Juni',
            'fr' => 'juin',
            'nl' => 'juni',
            'pl' => 'Czerwiec',
            'cz' => 'Červen',
        ],

        'July' => [
            'de' => 'Juli',
            'fr' => 'juillet',
            'nl' => 'juli',
            'pl' => 'Lipiec',
            'cz' => 'Červenec',
        ],

        'August' => [
            'de' => 'August',
            'fr' => 'aout',
            'nl' => 'augustus',
            'pl' => 'Sierpień',
            'cz' => 'Srpen',
        ],

        'September' => [
            'de' => 'September',
            'fr' => 'septembre',
            'nl' => 'september',
            'pl' => 'Wrzesień',
            'cz' => 'Září',
        ],

        'October' => [
            'de' => 'Oktober',
            'fr' => 'octobre',
            'nl' => 'oktober',
            'pl' => 'Październik',
            'cz' => 'Říjen',
        ],

        'November' => [
            'de' => 'November',
            'fr' => 'novembre',
            'nl' => 'november',
            'pl' => 'Listopad',
            'cz' => 'Listopad',
        ],

        'December' => [
            'de' => 'Dezember',
            'fr' => 'décembre',
            'nl' => 'december',
            'pl' => 'Grudzień',
            'cz' => 'Prosinec',
        ],
    ];


    public static $name         = 'Localee';
    public static $version      = '1.0';
    public static $author       = 'Sevengage';
    public static $author_url   = 'http://sevengage.com';
    public static $description  = 'Convert an EE date variable text in to the language of a given locale.';
    public static $typography   = FALSE;

    public $return_data = "";

 
    /**
     * Localee
     *
     * This is a refactor for EE v5 of Date Time Converter by Made By Hippo
     *
     * @access  public
     * @return  string
    */

     public function __construct() {

        $language = ee()->TMPL->fetch_param('language') ?? 'de';
        $format = ee()->TMPL->fetch_param('format');
        $date = ee()->TMPL->tagdata;


        if (! is_numeric($date)) {
            $date = strtotime($date);
        }

        if (isset($language)) {
            setlocale(LC_ALL, $language);
        }

        $date = ee()->localize->format_date($format, $date);

        $this->return_data = $this->getFullMonthByLocale($date, $language);
    }


    /**
     * Get a month for a given language. Currently supports English, German, French, Dutch, Polish and Czech.
     * If a locale does not exist, the month provided in the first param will be returned.
     *
     * @param string $date
     * @param string $locale
     * @return string
     */
    private function getFullMonthByLocale($date, $locale = 'de')
    {
        preg_match('/[a-z]+/i', strtolower($date), $matches);

        if (! $matches[0]) {
            return $date;
        }

        $months = array_keys(self::MONTHS);
        $month = array_values(array_filter($months, function ($month) use ($date, $matches) {
            return preg_match("/${matches[0]}/", strtolower($month)) !== 0;
        }));

        if (! $month || count($month) !== 1) {
            return $date;
        }

        if (strpos($locale, '_')) {
            $locale = strtolower(explode('_', $locale)[0]);
        }

        $date = str_replace($matches[0], $month[0], strtolower($date));

        return str_replace($month[0], self::MONTHS[$month[0]][$locale], $date);
    }



    public static function usage(){
        ob_start();     ?>

        Wrap your ExpressionEngine Date Variable:

        {exp:localee
            language = ""               // Base locale ID of the given language
        }
            {entry_date format="%F %d %Y"}
        {/exp:localee}

        Passing the appropriate Language reference into the language="" parameter.

        * de : German
        * fr : French
        * nl : Dutch
        * pl : Polish
        * cz : Czech

        <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }

}
/* End of file pi.localee.php */ 
/* Location: ./system/user/addons/localee/pi.localee.php */