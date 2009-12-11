<?php
class AppModel extends Model {
    /**
     * Modified version of Validation::postal - allows for multiple
     * countries to be specified as an array.
     */
    function postal($check, $regex = null, $country = null) {
        // List of regular expressions to use, if a custom one isn't specified.
        $countryRegs = array(
            'uk' => '/\\A\\b[A-Z]{1,2}[0-9][A-Z0-9]? [0-9][ABD-HJLNP-UW-Z]{2}\\b\\z/i',
            'ca' => '/\\A\\b[ABCEGHJKLMNPRSTVXY][0-9][A-Z][ ]?[0-9][A-Z][0-9]\\b\\z/i',
            'it' => '/^[0-9]{5}$/i',
            'de' => '/^[0-9]{5}$/i',
            'be' => '/^[1-9]{1}[0-9]{3}$/i',
            'us' => '/\\A\\b[0-9]{5}(?:-[0-9]{4})?\\b\\z/i',
            'default' => '/\\A\\b[0-9]{5}(?:-[0-9]{4})?\\b\\z/i' // Same as US.
        );

        $value = array_values($check);
        $value = $value[0];
        if ($regex) {
            return preg_match($regex, $value);
        } else if (!is_array($country)) {
            return preg_match($countryRegs[$country], $value);
        }

        foreach ($country as $check) {
            if (!isset($countryRegs[$check]) && preg_match($countryRegs['default'], $value)) {
                return true;
            } else if (preg_match($countryRegs[$check], $value)) {
                return true;
            }
        }

        return false;
    }    
}
?>