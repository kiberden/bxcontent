<?php

namespace marvin255\bxcontent;

/**
 * Автозагрузчик для классов модуля.
 */
class Autoloader
{
    /**
     * @param string
     */
    protected static $path = null;

    /**
     * Регистрирует автозагрузчик для библиотеки.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function register($path = null)
    {
        self::$path = $path ?: __DIR__;

        return spl_autoload_register([__CLASS__, 'load'], true, true);
    }

    /**
     * Непосредственно алгоритм для автозагрузки.
     *
     * @param string $class
     */
    public static function load($class)
    {
        $prefix = __NAMESPACE__ . '\\';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }
        $relative_class = substr($class, $len);
        $file = self::$path . '/' . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
}

Autoloader::register(dirname(__FILE__));
