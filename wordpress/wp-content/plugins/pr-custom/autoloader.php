<?php

class Autoloader
{
    /**
     * Singleton property
     *
     */
    public static $_instance = null;

    /**
     * Private Construct
     *
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'load'));
    }

    /**
     * Singleton method
     *
     */
    public static function instance()
    {
        return ! self::$_instance ? new self : self::$_instance;
    }

    /**
     * Class Loader
     *
     * @param string $class_name - class namespace to load
     * @return void
     */
    public function load($class)
    {
        $class = str_replace('Plugin\\', '', $class);
        $class = str_replace("\\", "/", $class);
        $class = lcfirst($class);

        if (is_readable(trailingslashit(plugin_dir_path(__FILE__)).$class.'.php')) {
            include_once trailingslashit(plugin_dir_path(__FILE__)).$class.'.php';
        }
    }

}
