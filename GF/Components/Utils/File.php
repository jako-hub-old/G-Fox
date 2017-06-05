<?php
/**
 * This class helps to manipulate files.
 *
 * @package GF\Components\Utils
 * @author Jorge Alejandro Quiroz Serna (Jako) <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017, Jakolab
 */

namespace GF\Components\Utils;

use \GF\System;

class File {

    /**
     * This function allows to create new files.
     *
     * @param string $path
     * @param string $content
     * @param bool $override
     * @return bool
     */
    public static function new(string $path, string $content, bool $override = true) : bool {
        if(System::exists($path) && !$override) return false;
        $handle = fopen($path, "w");
        fwrite($handle, $content);
        return fclose($handle);
    }
}