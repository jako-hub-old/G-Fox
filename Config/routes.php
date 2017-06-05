<?php
/**
 * This file contains the application components to be loaded.
 * @package Configs
 * @author Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0
 * @copyright (c) 2017, Jakolab
 */
use \GF\Components\Route;

Route::get("/", "\Controllers\Main", "Home");


