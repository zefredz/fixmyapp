<?php 

// added this custom autoloader because composer does not seems to be able to see my classes in FixMyApp
class MyCustomAutoloader
{
    public static function load( $className )
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;
    }

    public static function register()
    {
        spl_autoload_register( array('MyCustomAutoloader', 'load' ) );
    }
}

MyCustomAutoloader::register();