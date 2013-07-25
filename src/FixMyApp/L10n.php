<?php 

namespace FixMyApp;

class L10n implements \ArrayAccess
{
    private $_lang = array(), $langPath;

    public function __construct( $langPath )
    {
        $this->langPath = $langPath;
    }

    public function load( $language )
    {
        $_lang = array();

        if ( file_exists("{$this->langPath}/{$language}.lang.php") )
        {
            include "{$this->langPath}/{$language}.lang.php";
        }

        array_merge( $this->_lang, $_lang );
    }

    public function offsetSet($offset, $value) 
    {
        if (is_null($offset)) 
        {
            $this->_lang[] = $value;
        } 
        else 
        {
            $this->_lang[$offset] = $value;
        }
    }

    public function offsetExists($offset) 
    {
        return isset($this->_lang[$offset]);
    }

    public function offsetUnset($offset) 
    {
        unset($this->_lang[$offset]);
    }

    public function offsetGet($offset) 
    {
        // here we change the behaviour because __ returns the string if no translation exists
        return isset( $this->_lang[$offset] ) ? $this->_lang[$offset] : $offset;
    }
}
