<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit077946b03f70cfffb866cb0d6efa6e3c
{
    public static $files = array (
        'b33e3d135e5d9e47d845c576147bda89' => __DIR__ . '/..' . '/php-di/php-di/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'M' => 
        array (
            'MyApp\\' => 6,
            'Medoo\\' => 6,
        ),
        'L' => 
        array (
            'Laravel\\SerializableClosure\\' => 28,
        ),
        'I' => 
        array (
            'Invoker\\' => 8,
        ),
        'D' => 
        array (
            'DI\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'MyApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
        'Laravel\\SerializableClosure\\' => 
        array (
            0 => __DIR__ . '/..' . '/laravel/serializable-closure/src',
        ),
        'Invoker\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/invoker/src',
        ),
        'DI\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/php-di/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit077946b03f70cfffb866cb0d6efa6e3c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit077946b03f70cfffb866cb0d6efa6e3c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit077946b03f70cfffb866cb0d6efa6e3c::$classMap;

        }, null, ClassLoader::class);
    }
}
