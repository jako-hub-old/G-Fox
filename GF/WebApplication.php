<?php
/**
 * This class represents the running application in the system
 * @package GF
 * @author  Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017 Jakolab
 */

namespace GF;


final class WebApplication {
    private function __construct() { }
    public function init(){}
    public function start(){ echo "Web application started"; }

    /**
     * @return WebApplication
     */
    public static function getInstance() : WebApplication{
        static $instance = null;
        if($instance === null) $instance = new WebApplication();
        return $instance;
    }
}