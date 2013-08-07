<?php namespace FixMyApp;

class Config
{
    protected $_properties;

    public function __construct( $properties )
    {
        $this->_properties = $properties;
    }

    public function __get( $name )
    {
        if ( isset( $this->_properties[$name] ) )
        {
            if ( is_array( $this->_properties[$name] ) )
            {
                $props = new self( $this->_properties[$name] );

                return $props;
            }
            else
            {
                return $this->_properties[$name];
            }
        }
        else
        {
            throw new Exception("Property {$name} does not exists");
        }
    }
}
