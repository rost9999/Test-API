<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc2738620d17240ecfb7a17ed7d9ab513
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/src',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInitc2738620d17240ecfb7a17ed7d9ab513::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInitc2738620d17240ecfb7a17ed7d9ab513::$classMap;

        }, null, ClassLoader::class);
    }
}
