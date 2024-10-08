<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit431b696c7b642b6e4db8a0afd3f566fc
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit431b696c7b642b6e4db8a0afd3f566fc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit431b696c7b642b6e4db8a0afd3f566fc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit431b696c7b642b6e4db8a0afd3f566fc::$classMap;

        }, null, ClassLoader::class);
    }
}
