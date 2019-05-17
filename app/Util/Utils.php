<?php

namespace App\Util;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class Utils
{

    static function ensureDir(string $path): string
    {
        $path = preg_match('/\.\w+$/', $path) ? dirname($path) : $path;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return realpath($path);
    }

    /**
     * Gets the realpath of the provided combined paths. If a relative link, it will assume relative to the cwd.
     * @param string ...$paths
     * @return string
     */
    static function resolve(string ...$paths): string
    {
        return realpath(self::joinPaths(...$paths));
    }

    /**
     * @see https://stackoverflow.com/a/15575293
     * @param string ...$paths
     * @return string
     */
    static function joinPaths(string ...$paths): string {
        $filteredPaths = [];

        foreach ($paths as $path) {
            if ($path !== '') {
                $filteredPaths[] = $path;
            }
        }

        return preg_replace('#/+#', DIRECTORY_SEPARATOR, join(DIRECTORY_SEPARATOR, $filteredPaths));
    }

    static function find(string $folder, ?string $pattern = '/.*/')
    {
        $dir = new RecursiveDirectoryIterator($folder);
        $ite = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
        $fileList = [];
        $ignored = ['.', '..', '.gitignore'];
        foreach ($files as $file) {
            if (!in_array(basename($file[0]), $ignored)) {
                $fileList[] = self::resolve($file[0]);
            }
        }
        return $fileList;
    }

    /**
     * @param string $dir
     * @return bool
     * @throws \Throwable
     */
    static function rmDir(string $dir): bool
    {
        $dir = self::resolve($dir);

        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!self::rmDir($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
}