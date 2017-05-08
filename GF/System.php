<?php
/**
 * This class represents the system, it contains the running application and initializes
 * all the basic logic that every gf-web-application needs.
 *
 * @package GF
 * @author  Jorge Alejandro Quiroz Serna (Jako) <alejo.jko@gmail.com>
 * @version  1.0.0
 * @copyright (c) 2017, Jakolab
 */

namespace GF;

class System {
    /**
     * Contains all the aliases defined for the application.
     * @var array
     */
    private static $aliases = [];
    /**
     * The unique instance of the application.
     * @var \GF\WebApplication
     */
    private static $application = null;
    /**
     * The current system version.
     * @var string
     */
    private static $version = "1.0.0";

    /**
     * Creates the instance of the Web application.
     * @version 1.0
     * @return WebApplication
     */
    public static function createApp() : WebApplication{
        self::loadUtilities();
        self::import("GF.WebApplication");
        self::$application = WebApplication::getInstance();
        self::$application->init();
        return self::$application;
    }

    /**
     * This function loads common utilities for the System.
     * @version 1.0
     * @throws \Exception
     */
    public static function loadUtilities(){
        # First we load the aliases.
        $aliases = KERNEL_DIR . DS . "Utilities" . DS . "aliases.php";
        if(!file_exists($aliases)) throw new \Exception("Error loading the aliases.");
        self::$aliases = include_once $aliases;
        # Then we load the common functions
        $functions = KERNEL_DIR . DS . "Utilities" . DS . "functions.php";
        if(!file_exists($functions)) throw new \Exception("Error loading the functions.");
        include_once $functions;
    }

    /**
     * Import a file using the dots notation
     * @version 1.0
     * @param $resources
     * @param bool $isFile
     * @return null|mixed
     */
    public static function import($resources, $usingAlias = true, bool $once = true){
        if(is_string($resources)) return self::importSingle($resources, $usingAlias, $once);
        else if(is_array($resources)) return self::importMultiple($resources, $usingAlias, $once);
        else return null;
    }

    /**
     * Returns the result of requiring a file.
     * @version 1.0
     * @param string $resource
     * @param bool $usingAlias
     * @param bool $once
     * @return mixed
     * @throws \Exception
     */
    private static function importSingle(string $resource, bool $usingAlias, bool $once){
        if($usingAlias) $resource = self::resolvePath($resource, true);
        if(!file_exists($resource)) throw new \Exception("The file {$resource} doesn't exists.");
        return $once? require_once $resource : require $resource;
    }

    /**
     * Import multiple files (this function does not returns the require of the file).
     * @version 1.0
     * @param array $resources
     * @param bool $usingAlias
     * @param bool $once
     * @return bool
     */
    private static function importMultiple(array $resources, bool $usingAlias, bool $once) : bool{
        $error = false;
        foreach($resources AS $resource){
            if(!self::importSingle($resource, $usingAlias, $once)) return false;
        }
        return true;
    }

    /**
     * Turns a dot notation syntax into an absolute path, the first word in the path
     * should be an alias (See GF/Utilities/aliases)
     * @version 1.0
     * @param string $path
     * @param bool $isFile
     * @param string $extension
     * @return string
     */
    public static function resolvePath(string $path, $isFile = false, $extension = "php") : string{
        $parts = explode('.', $path);
        $lastPart = end($parts);
        $alias = reset($parts);
        if(key_exists($alias, self::$aliases)){
            $alias = self::$aliases[$alias];
            unset($parts[0]);
        }
        $finalPath = $alias;
        foreach($parts AS $dir) $finalPath .= DS . $dir;
        return $finalPath . ($isFile? ".{$extension}" : "");
    }

    /**
     * This function converts a dots notation string to a namespace.
     * @param string $path
     * @return bool|string
     */
    public static function toNamespace(string $path){
        if(!strpos($path, ".")) return false;
        $path = str_replace(".", "\\", $path);
        return "\\" . ucfirst($path);
    }

    /**
     * This function transforms from a namespace syntax to a dots notation syntax.
     * @param string $namespace
     * @return bool|mixed
     */
    public static function namespaceToDots(string $namespace){
        if(!strpos($namespace, "\\")) return false;
        return str_replace("\\", ".", $namespace);
    }

    /**
     * Returns the application running instance.
     * @return WebApplication
     */
    public static function app() : WebApplication{
        return self::$application;
    }

    /**
     * Checks if a file or directory exists.
     * @param string $path
     * @param bool $isFile
     * @param string $ext
     * @return bool
     */
    public static function exists(string $path, bool $isFile = true, string $ext = "php"){
        if(strpos($path, ".") != false) $path = self::resolvePath($path, $isFile, $ext);
        return file_exists($path);
    }

    /**
     * Checks if the folder exists, if not, it creates it.
     * @param string $path
     * @return bool
     */
    public static function dir(string $path){
        if(!self::exists($path, false)) return mkdir(self::resolvePath($path, false));
        else return false;
    }

    /**
     * Returns the current system version.
     * @return string
     */
    public static function version(){
        return self::$version;
    }

}