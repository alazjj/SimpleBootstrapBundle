<?php

namespace Alazjj\SimpleBootstrapBundle\Composer;

use Composer\Script\Event;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class ScriptHandler
{
    private static $VENDOR_DIR;
    private static $BUNDLE_CSS_DIR;

    public static function getVendorDir()
    {
        if (is_null(self::$VENDOR_DIR))
        {
            self::$VENDOR_DIR = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
        }

        return self::$VENDOR_DIR;
    }

    public static function getBundleCssDir()
    {
        if (is_null(self::$BUNDLE_CSS_DIR))
        {
            self::$BUNDLE_CSS_DIR = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR);
        }

        return self::$BUNDLE_CSS_DIR;
    }

    public static function buildCssSymlink()
    {
        $fs = new Filesystem();

        self::getVendorDir();
        self::getBundleCssDir();

        $finder = new Finder();
        $finder->files()
            ->in(self::getVendorDir())
            ->name('/\.css$/')
            ->exclude('SimpleBootstrapBundle');

        /** @var $css SplFileInfo */
        foreach ($finder as $css) {
            try {
                $fs->symlink($css->getPathname(), self::getBundleCssDir() . DIRECTORY_SEPARATOR . $css->getBasename());
            } catch (IOException $e) {
                echo "An error occurred while symlinking the css {$css->getBasename()}.\n";
            }
        }
    }
}
