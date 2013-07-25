<?php

/**
 * L10N function helper : returns a translation of the given string. if no translation available, returns the string itself
 * @param string $str string to translate
 * @return string translated string or the string itself if no translation available
 */
function __($str)
{
    return $GLOBALS['_LANG'][$str];
}
