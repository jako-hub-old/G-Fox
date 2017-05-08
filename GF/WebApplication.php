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
    /**
     * @var \GF\Components\Request
     */
    private $request;
    /**
     * @var \GF\Components\Response
     */
    private $response;

    private function __construct() { }
    public function init(){
        $this->initAutoload();
        $this->loadRouter();
        $this->loadRequest();
        $this->loadResponse();
    }
    public function start(){
        $this->request->dispatch();
        $this->response->dispatch();
    }

    /**
     * This function init the Autoload function.
     */
    private function initAutoload(){
        spl_autoload_register([$this, "autoLoadClass"]);
    }

    /**
     * This function is used by the autoload to load every invoked namespace.
     * @param string $className
     * @throws \Exception
     */
    private function autoLoadClass(string $className){
        $file = System::namespaceToDots($className);
        if(!System::exists($file)) throw new \Exception("Error, the class {$className} does not exists.");
        System::import($file);
    }

    /**
     * This function loads the router component.
     */
    private function loadRouter(){
        \GF\Components\Route::readRoute();
        System::import("Config.routes");
    }

    /**
     * This function loads the request component.
     */
    private function loadRequest(){
        $this->request = new \GF\Components\Request();
        $this->request->init();
    }

    /**
     * This function loads the response component.
     */
    private function loadResponse(){
        $this->response = new \GF\Components\Response($this->request);
        $this->response->init();
    }

    /**
     * @return WebApplication
     */
    public static function getInstance() : WebApplication{
        static $instance = null;
        if($instance === null) $instance = new WebApplication();
        return $instance;
    }
}