<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0bcb8bdec6860b14b43426298afb2ebc
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Orhanerday\\OpenAi\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Orhanerday\\OpenAi\\' => 
        array (
            0 => __DIR__ . '/..' . '/orhanerday/open-ai/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0bcb8bdec6860b14b43426298afb2ebc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0bcb8bdec6860b14b43426298afb2ebc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0bcb8bdec6860b14b43426298afb2ebc::$classMap;

        }, null, ClassLoader::class);
    }
}
