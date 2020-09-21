<?php

namespace App\Install;

class Installer
{
    public static function postInstall(\Composer\Script\Event $event): void
    {
        $vendorDir = $event->getComposer()->getConfig()->get('bin-dir');

        if (!file_exists($vendorDir)) {
            if (!mkdir($dir = $vendorDir) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }

        $source = 'console';
        $destination = $vendorDir . DIRECTORY_SEPARATOR . 'console';

        if (file_exists($source) && !file_exists($destination)) {
            rename($source, $destination);
        }
    }
}
