<?php 
namespace FixMyApp;

/**
 * Configuration object
 */
class Config
{
    protected $_properties;

    /**
     * @param array $properties multi-level associative array storing the configuration options
     */
    public function __construct( $properties )
    {
        $this->_properties = $properties;
    }

    // Magic
    
    public function __get( $name )
    {
        if (isset($this->_properties[$name])) {
            if (is_array($this->_properties[$name])) {
                $props = new self($this->_properties[$name]);
                return $props;
            } else {
                return $this->_properties[$name];
            }
        } else {
            throw new \Exception("Property {$name} does not exists");
        }
    }

    public function __set($name, $value)
    {
        throw new \Exception("The configuration is read-only");
    }

    public function asArray()
    {
        if (is_array($this->_properties)) {
            return $this->_properties;
        } else {
            return array($this->_properties);
        }
    }
}
