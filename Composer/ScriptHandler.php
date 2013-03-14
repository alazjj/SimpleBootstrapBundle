<?php

namespace Alazjj\SimpleBootstrapBundle\Composer;

use Composer\Script\Event;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class ScriptHandler
{
    const BUNDLE_NAME = 'SimpleBootstrapBundle';

    public static function getVendorDir()
    {
        return realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
        );
    }

    public static function getBundleCssDir()
    {
        return self::getBundleAssetDir('css');
    }

    public static function getBundleImgDir()
    {
        return self::getBundleAssetDir('img');
    }

    public static function installAssets()
    {
        $cssFinder = new Finder();
        $cssFinder->files()
            ->in(self::getVendorDir())
            ->name('/\.css$/')
            ->exclude(self::BUNDLE_NAME);

        self::symlinkAssets($cssFinder, 'css');

        $imgFinder = new Finder();
        $imgFinder->files()
            ->in(self::getVendorDir())
            ->name('/\.png$/')
            ->name('/\.gif$/')
            ->name('/\.jpg$/')
            ->name('/\.jpeg$/')
            ->exclude(self::BUNDLE_NAME);

        self::symlinkAssets($imgFinder, 'img');
    }

    /**
     * Creates a symlink for each asset into the public/$assetType directory of the bundle.
     */
    private static function symlinkAssets(Finder $finder, $assetType)
    {
        $getBundleAssetDir = "getBundle" . ucfirst($assetType) . "Dir";
        $bundleAssetDir    = self::$getBundleAssetDir() . DIRECTORY_SEPARATOR;
        $fs                = new Filesystem();

        /** @var $asset SplFileInfo */
        foreach ($finder as $asset) {
            try {
                $fs->symlink($asset->getPathname(), $bundleAssetDir . $asset->getBasename());
            } catch (IOException $e) {
                echo "An error occurred while symlinking the asset {$asset->getBasename()}.\n";
            }
        }
    }

    private static function getBundleAssetDir($assetType)
    {
        return realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $assetType . DIRECTORY_SEPARATOR
        );
    }
}
