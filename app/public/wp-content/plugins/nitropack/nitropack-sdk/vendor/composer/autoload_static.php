<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8fcbb1a5ffa2542d92b974779798cb81
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'NitroPack\\SDK\\' => 14,
            'NitroPack\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'NitroPack\\SDK\\' => 
        array (
            0 => __DIR__ . '/../..' . '/NitroPack/SDK',
        ),
        'NitroPack\\' => 
        array (
            0 => __DIR__ . '/..' . '/isenselabs/httpclient/src',
            1 => __DIR__ . '/..' . '/isenselabs/url/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8fcbb1a5ffa2542d92b974779798cb81::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8fcbb1a5ffa2542d92b974779798cb81::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
