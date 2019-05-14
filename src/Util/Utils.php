<?php

namespace AvroToPhp\Util;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class Utils {

    static function rsearch(string $folder, string $pattern) {
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