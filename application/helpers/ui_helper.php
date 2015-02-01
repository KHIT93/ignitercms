<?php
// ------------------------------------------------------------------------

/**
 * Translation - Takes a string and translates it into the site language
 *
 * @access	public
 * @param	string
 * @param       array
 * @return	string
 */
if(!function_exists('t')) {
    function t($string, $args = array()) {
        $CI =& get_instance();
        $CI->load->database();
        $output = '';
        $lang = $CI->configuration->get('site_language');
        if($lang != 'en') {
            $query = $CI->db->select('string, translation')
                    ->from('translation')
                    ->where('language', $lang)
                    ->where('string', $string)
                    ->get()
                    ->result();
            $translation = (isset($query[0]) ? $query[0] : $query);
            if(isset($translation->string)) {
                if(!isset($translation->translation) || !$translation->translation || $translation->translation == '' || $lang == 'en') {
                    $output = $string;
                }
                else {
                    $output = $translation->translation;
                }
            }
            else {
                $CI->db->insert('translation', array('string' => $string, 'language' => $lang));
                $output = $string;
            }
        }
        else {
            $output = $string;
        }
        return string_format($output, $args);
    }
}
// ------------------------------------------------------------------------

/**
 * String formatting - Takes a string and formats it using the arguments
 * supplied as an array
 *
 * @access	public
 * @param	string
 * @param       array
 * @return	string
 */
if(!function_exists('string_format')) {
    function string_format($string, $args = array()) {
        // Transform arguments before inserting them.
        foreach ($args as $key => $value) {
            switch ($key[0]) {
                case '@':
                    // Escaped only.
                    $args[$key] = check_plain($value);
                    //$args[$key] = $value;
                break;

                case '%':
                default:
                // Escaped and placeholder.
                    //$args[$key] = Sanitize::stringPlaceholder($value);
                    $args[$key] = $value;
                break;

                case '!':
                    // Pass-through.
            }
        }
        return strtr($string, $args);
    }
}
// ------------------------------------------------------------------------

/**
 * Filer String to Plain Text - Takes a string and escapes any characters
 * to be rendered as text in the browser
 *
 * @access	public
 * @param	string
 * @return	string
 */
if(!function_exists('check_plain')) {
    function check_plain($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
// ------------------------------------------------------------------------

/**
 * Set Message - Takes a string and sets it as a custom message for display
 * on the next page load. Method accepts an error type
 *
 * @access	public
 * @param	string
 * @param       string
 * @return	string
 */
if(!function_exists('set_message')) {
    function set_message($message, $type) {
        
    }
}
// ------------------------------------------------------------------------

/**
 * Form Value From Database
 *
 * Grabs a value from the POST array for the specified field so you can
 * re-populate an input field or textarea.  If Form Validation
 * is active it retrieves the info from the validation class
 *
 * @access	public
 * @param	string
 * @return	mixed
 */
if ( ! function_exists('set_db_form_value'))
{
    function set_db_form_value($field = '', $table = '', $where = array(), $default = '')
    {
        if(count($_POST)) {
            return set_value($field);
        }
        else {
            $CI =& get_instance();
            return $CI->db->select($field)
                    ->from($table)
                    ->where($where)
                    ->get()->result()[0]->{$field};
        }
    }
}