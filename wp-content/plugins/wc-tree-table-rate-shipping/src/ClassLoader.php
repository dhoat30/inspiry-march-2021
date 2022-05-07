<?php
namespace Trs;


class ClassLoader
{
    public function setup(PluginMeta $pluginMeta)
    {
        /** @var \TrsVendors\Composer\Autoload\ClassLoader $autoloader */
        $autoloader = include($pluginMeta->getLibsPath('autoload.php'));

        // This fixes the following issue:
        // 1. Activate the 'Real Cookie Banner (Free)' plugin (probably any plugin with plugin-update-checker "scoped" with php-scoper).
        // 2. Activate this plugin.
        // 3. Notice the fatal error saying Puc_v4_Factory class not found in the UpdateService.
        //
        // The issue happens because composers' "files" autoload type includes an only autoload file out of all
        // available having the same hash. The hash is based on package name and file path.
        //
        // "Scoping" plugin-update-checker with composer-capsule breaks it since PUC depends on the class name structure
        // which is changed due to the way CC handles classes in the root namespace.
        if (!class_exists('Puc_v4_Factory')) {
            require($pluginMeta->getLibsPath('yahnis-elsts/plugin-update-checker/load-v4p11.php'));
        }

        // tree_table_rate alias class
        $autoloader->addClassMap(array('tree_table_rate' => $pluginMeta->getPath('tree_table_rate.php')));

        // Migrations
        $migrationsPath = $pluginMeta->getMigrationsPath();
        spl_autoload_register(static function($class) use($migrationsPath) {
            if (preg_match('/Trs\\\\Migration\\\\Migration((_\d+)+)$/', $class, $matches)) {
                require($migrationsPath.'/'.str_replace('_', '.', ltrim($matches[1], '_')).'.php');
            }
        });

        return $autoloader;
    }
}