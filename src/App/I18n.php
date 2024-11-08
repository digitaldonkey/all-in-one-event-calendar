<?php

namespace Osec\App;

/**
 * Internationalization layer.
 *
 * @since      2.0
 * @replaces Ai1ec_I18n
 * @author     Time.ly Network, Inc.
 */
class I18n
{

    /**
     * Translates string. Wrapper for WordPress `__()` function.
     *
     * @param  string  $term  Message to translate.
     *
     * @return string Translated string representation.
     */
    static public function __($term)
    {
        return __($term, OSEC_TXT_DOM);
    }

    /**
     * Translates string in context. Wrapper for WordPress `_x()` function.
     *
     * @param  string  $term  Message to translate.
     * @param  string  $ctxt  Translation context for message.
     *
     * @return string Translated string representation.
     */
    static public function _x($term, $ctxt)
    {
        return _x($term, $ctxt, OSEC_TXT_DOM);
    }

}
