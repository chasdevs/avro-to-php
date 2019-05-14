<?php

namespace AvroToPhp\Util;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class Utils
{

    /**
     * @param string $path
     * @throws \Throwable
     */
    static function ensureDir(string $path): void
    {
        $path = preg_match('/\.\w+$/', $path) ? dirname($path) : $path;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    /**
     * @see https://stackoverflow.com/a/15575293
     * @param string ...$paths
     * @return string
     */
    static function joinPaths(string ...$paths): string
    {
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
        $fileList = array();
        foreach ($files as $file) {
            $fileList = array_merge($fileList, $file);
        }
        return $fileList;
    }

    /**
     * @param string $path
     * @throws \Throwable
     */
    static function rmDir(string $path): void
    {
        if (file_exists($path)) {
            rmdir($path);
        }
    }
}