<?php
/**
 * This file contains the application databases configuration.
 *
 * @package Configs
 * @author Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0
 * @copyright (c) 2017, Jakolab
 */

return [
    'default' => [
        'driver' 	=> 'mysql',
        'host'		=> 'localhost',
        'database' 	=> 'test',
        'user' 		=> 'root',
        'password'	=> 'jko123',
        'charset' 	=> 'utf8',
        'prefix'	=> false,
        'port'		=> 3306,
        #'collation'	=> 'utf8mb4_unicode_ci',
    ],
];