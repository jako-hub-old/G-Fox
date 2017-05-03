<?php
/**
 * This file contains the aliases used in the application to resolve paths.
 *
 * @package GF/utilities
 * @author  Jorge Alejandro Quiroz Serna (Jako) <alejo.jko@gmail.com>
 * @version  1.0.0
 * @copyright (c) 2017, Jakolab
 */
return [
    'App' => APP_DIR,
    'Cache' => CACHE_DIR,
    'Config' => CONFIG_DIR,
    'Models' => APP_DIR . DS . "Models",
    'Controllers' => APP_DIR . DS . "Controllers",
    'Views' => APP_DIR . DS . "Views",
    'Modules' => APP_DIR . DS . "Modules",
    'DB' => KERNEL_DIR . DS . "DB",
    'GF' => KERNEL_DIR,
    'Public' => PUBLIC_DIR,
    'Vendor' => VENDOR_DIR,
    'Components' => APP_DIR . DS . "Components",
    'Layouts' => APP_DIR . DS . "Views" . DS . "Layouts",
    'Root' => ROOT_DIR,
];
