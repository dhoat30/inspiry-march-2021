<?php

// autoload_static.php @generated by Composer

namespace TrsVendors\Composer\Autoload;

class ComposerStaticInit7bca41f0d91c8d3e82898a7499c6111f
{
    public static $files = array (
        'b411d774a68934fe83360f73e6fe640f' => __DIR__ . '/..' . '/dangoodman/composer-capsule-runtime/autoload.php',
        '49a1299791c25c6fd83542c6fedacddd' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v4p11.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Trs\\' => 4,
            'TrsVendors\\Dgm\\Shengine\\Woocommerce\\Model\\Item\\' => 47,
            'TrsVendors\\Dgm\\Shengine\\Woocommerce\\Converters\\' => 47,
            'TrsVendors\\Dgm\\Shengine\\Migrations\\' => 35,
            'TrsVendors\\Dgm\\Shengine\\' => 24,
            'TrsVendors\\Dgm\\Range\\' => 21,
            'TrsVendors\\Dgm\\PluginServices\\' => 30,
            'TrsVendors\\Dgm\\NumberUnit\\' => 26,
            'TrsVendors\\Dgm\\Comparator\\' => 26,
            'TrsVendors\\BoxPacking\\' => 22,
        ),
        'D' => 
        array (
            'Dgm\\Composer\\ForceExportIgnore\\' => 31,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Trs\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'TrsVendors\\Dgm\\Shengine\\Woocommerce\\Model\\Item\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/shengine-wc-item/src',
        ),
        'TrsVendors\\Dgm\\Shengine\\Woocommerce\\Converters\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/shengine-wc-converters/src',
        ),
        'TrsVendors\\Dgm\\Shengine\\Migrations\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/shengine-migrations/src',
        ),
        'TrsVendors\\Dgm\\Shengine\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/shengine/src',
        ),
        'TrsVendors\\Dgm\\Range\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/range/src',
        ),
        'TrsVendors\\Dgm\\PluginServices\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/wp-plugin-services/src',
        ),
        'TrsVendors\\Dgm\\NumberUnit\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/number-unit/src',
        ),
        'TrsVendors\\Dgm\\Comparator\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/comparator/src',
        ),
        'TrsVendors\\BoxPacking\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/boxpacking/src',
        ),
        'Dgm\\Composer\\ForceExportIgnore\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/composer-force-export-ignore',
        ),
    );

    public static $classMap = array (
        'TrsVendors\\Deferred\\Deferred' => __DIR__ . '/..' . '/dangoodman/deferred/Deferred.php',
        'TrsVendors\\Dgm\\Arrays\\Arrays' => __DIR__ . '/..' . '/dangoodman/arrays/Arrays.php',
        'TrsVendors\\Dgm\\ClassNameAware\\ClassNameAware' => __DIR__ . '/..' . '/dangoodman/class-name-aware/ClassNameAware.php',
        'TrsVendors\\Dgm\\SimpleProperties\\SimpleProperties' => __DIR__ . '/..' . '/dangoodman/simple-properties/SimpleProperties.php',
        'TrsVendors\\Dgm\\WcTools\\WcTools' => __DIR__ . '/..' . '/dangoodman/wc-tools/WcTools.php',
        'TrsVendors_DgmWpDismissibleNotices' => __DIR__ . '/..' . '/dangoodman/wp-plugin-bootstrap-guard/DgmWpDismissibleNotices.php',
        'TrsVendors_DgmWpPluginBootstrapGuard' => __DIR__ . '/..' . '/dangoodman/wp-plugin-bootstrap-guard/DgmWpPluginBootstrapGuard.php',
    );

    public static function getInitializer(\TrsVendors\Composer\Autoload\ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = \TrsVendors\Composer\Autoload\ComposerStaticInit7bca41f0d91c8d3e82898a7499c6111f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = \TrsVendors\Composer\Autoload\ComposerStaticInit7bca41f0d91c8d3e82898a7499c6111f::$prefixDirsPsr4;
            $loader->classMap = \TrsVendors\Composer\Autoload\ComposerStaticInit7bca41f0d91c8d3e82898a7499c6111f::$classMap;

        }, null, \TrsVendors\Composer\Autoload\ClassLoader::class);
    }
}
