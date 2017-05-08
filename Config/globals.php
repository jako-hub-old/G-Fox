<?php
/**
 * This file contains all the constants needed in the application.
 * @package Config
 * @author Jorge Alejandro Quiroz Serna (Jako) <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017, Jakolab
 */
# This defines a shortcut to DIRECTORY_SEPARATOR
define("DS", DIRECTORY_SEPARATOR);
# Root directory.
define("ROOT_DIR", realpath(__DIR__ . '/../'));
# App folder.
define("APP_DIR", ROOT_DIR . DS . "App");
# Cache folder.
define("CACHE_DIR", ROOT_DIR . DS . "Cache");
# Config folder.
define("CONFIG_DIR", ROOT_DIR . DS . "Config");
# Framework folder.
define("KERNEL_DIR", ROOT_DIR . DS . "GF");
# Public folder.
define("PUBLIC_DIR", ROOT_DIR . DS . "Public");
# The vendors folder
define("VENDOR_DIR", ROOT_DIR . DS . "vendor");