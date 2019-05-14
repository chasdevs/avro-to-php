<?php

namespace AvroToPhp\Util;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class Utils {

    /**
     * @param string $path
     * @throws \Throwable
     */
    static function ensureDir(string $path): void {
        try {
            mkdir(dirname($path), 0777, true);
        } catch (\Throwable $t) {
            if (!preg_match('/File exists/', $t->getMessage())) {
                throw $t;
            }
        }
    }

    /**
     * @see https://stackoverflow.com/a/15575293
     * @param string ...$paths
     * @return string
     */
    static function joinPaths(string ...$paths): string {
        $filteredPaths = [];

        foreach ($paths as $path) {
            if ($path !== '') { $filteredPaths[] = $path; }
        }

        return preg_replace('#/+#',DIRECTORY_SEPARATOR, join(DIRECTORY_SEPARATOR, $filteredPaths));
    }

    static function rsearch(string $folder, ?string $pattern = '/.*/') {
        $dir = new RecursiveDirectoryIterator($folder);
        $ite = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
        $fileList = array();
        foreach($files as $file) {
            $fileList = array_merge($fileList, $file);
        }
        return $fileList;
    }

}