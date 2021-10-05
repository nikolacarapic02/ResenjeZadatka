<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd42369f41957dbd017730c1cafe17cb5
{
    public static $files = array (
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
    );

    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'models\\' => 7,
        ),
        'i' => 
        array (
            'includes\\' => 9,
        ),
        'c' => 
        array (
            'config\\' => 7,
        ),
        'a' => 
        array (
            'api\\' => 4,
        ),
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'includes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
        'api\\' => 
        array (
            0 => __DIR__ . '/../..' . '/api',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fakerphp/faker/src/Faker',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd42369f41957dbd017730c1cafe17cb5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd42369f41957dbd017730c1cafe17cb5::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitd42369f41957dbd017730c1cafe17cb5::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd42369f41957dbd017730c1cafe17cb5::$classMap;

        }, null, ClassLoader::class);
    }
}
