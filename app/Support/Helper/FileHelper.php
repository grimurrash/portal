<?php

namespace App\Support\Helper;

use ZipArchive;

readonly class FileHelper
{
    /**
     * @param string $dir
     * @return string[]
     */
    public static function getDirectories(string $dir): array
    {
        $dirs = scandir($dir);
        if ($dirs === false) {
            return [];
        }
        $paths = [$dir];
        $migrationDirs = array_diff($dirs, ['..', '.']);
        $migrationDirPaths = array_map(static function ($path) use ($dir) {
            return $dir . DIRECTORY_SEPARATOR . $path;
        }, $migrationDirs);
        return array_merge($paths, $migrationDirPaths);
    }

    public static function fileArchivingToZip(string $zipPath, string $fileName, string $filePath): bool
    {
        $zip = new ZipArchive();

        if (!$zip->open($zipPath, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $zip->addFile($filePath, $fileName);

        $zip->close();
        return true;
    }

}
