<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita2bddc9ed1b0d179f2c5d81f110603ba
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInita2bddc9ed1b0d179f2c5d81f110603ba', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita2bddc9ed1b0d179f2c5d81f110603ba', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita2bddc9ed1b0d179f2c5d81f110603ba::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
