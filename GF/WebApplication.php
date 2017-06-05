<?php
/**
 * This class represents the running application in the system
 * @package GF
 * @author  Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017 Jakolab
 */

namespace GF;


final class WebApplication
{
    # ID: mi-g-fox-app
    private $ID = "9aa4bb2cf631ec483b33321e4541da769b5f813a";
    /**
     * @var \GF\Components\Request
     */
    private $Request;
    /**
     * @var \GF\Components\Response
     */
    private $Response;
    /**
     * @var \GF\Components\Web\Server
     */
    private $Server;

    ## Web components
    /**
     * @var \GF\Components\Web\Session
     */
    private $Session;
    /**
     * @var \GF\Components\Route
     */
    private $Router;
    /**
     * @var \GF\Components\Web\Controller
     */
    private $Controller;

    private $webComponents = [];
    /**
     * @var \Howl\DBManager
     */
    private $DB;
    /**
     * @var \GF\Components\Utils\AssetManager
     */
    private $AssetManager;
    /**
     * @var string
     */
    private $action;
    /**
     * @var bool
     */
    private $ctrlSendResponse = false;
    /**
     * @var array
     */
    private $config = [];

    private function __construct() { }

    /**
     * This function initializes the application.
     */
    public function init(){
        # Importing the howl auto-loader
        System::import("Vendor.jakolab.howl-orm.Howl.HowlAutoload");
        \Howl\HowlAutoload::initAutoload();
        $this->loadComponents();
        $this->loadRouter();
        $this->loadRequest();
        $this->loadResponse();
    }

    /**
     * This function loads the configured components.
     * @throws \Exception
     */
    private function loadComponents(){
        $this->webComponents = System::import("Config.components");
        foreach($this->webComponents AS $name=>$namespace){
            $this->$name = new $namespace();
            if(!$this->$name instanceof \GF\Components\Web\WebComponent)
                throw new \Exception("{$name} Is not a valid component");
            $this->$name->init();
        }
    }

    /**
     * This function starts the application.
     */
    public function start(){
        $this->Request->init();
        $this->Request->dispatch();
        $this->Response->init();
        $this->Response->dispatch();
    }

    /**
     * This function loads the router component.
     */
    private function loadRouter(){
        \GF\Components\Route::readRoute();
        System::import("Config.routes");
        $this->Router = new \GF\Components\Route($this);
    }

    /**
     * This function loads the request component.
     */
    private function loadRequest(){
        $this->Request = new \GF\Components\Request($this);
    }

    /**
     * This function loads the response component.
     */
    private function loadResponse(){
        $this->Response = new \GF\Components\Response($this);
    }

    /**
     * This function sets the current controller to the application.
     * @param string $namespace
     * @param string $action
     */
    public function loadController(string $namespace, string $action){
        $path = System::namespaceToDots($namespace);
        System::import($path);
        $this->Controller = new $namespace($this->Response);
        $this->action = $action;
        $this->Controller->init();
    }

    /**
     * This function allows to create a route.
     * @param string $route
     * @param array $params
     * @return string
     */
    public function createRoute(string $route, array $params = []) : string{
        return \GF\Components\Route::create($route, $params);
    }

    /************************************************************************
     ****                            Getters                            *****
     ************************************************************************/

    /**
     * This function returns the server component.
     * @return Components\Web\Server
     */
    public function Server() : \GF\Components\Web\Server{
        return $this->Server;
    }

    /**
     * This function returns the request component.
     * @return Components\Request
     */
    public function Request() : \GF\Components\Request {
        return $this->Request;
    }

    /**
     * This function returns the running application action.
     * @return string
     */
    public function Action() : string{
        return $this->action;
    }

    /**
     * This function allows to get the DBManager from Howl-orm.
     * @return \Howl\DBManager
     */
    public function DB() : \Howl\DBManager {
        $this->initDB();
        return $this->DB;
    }

    /**
     * This function allows to initialize the db component
     */
    public function initDB(){
        if($this->DB !== null) return;
        $config = System::readConfig("database")['default'];
        $driver = arrayPop($config, "driver");
        $this->DB = \Howl\DBManager::getInstance();
        $this->DB->loadDriver($this->getDriverName($driver), $config);
    }

    /**
     * This function allows to get the driver name accepted by howl-orm.
     * @param string $driver
     * @return string
     */
    private function getDriverName(string $driver){
        switch ($driver){
            case 'mysql' : return \Howl\DBManager::MYSQL_DRIVER;
            default : return \Howl\DBManager::MYSQL_DRIVER;
        }
    }

    /**
     * This function returns the current controller.
     * @return Components\Web\Controller
     */
    public function Controller() : \GF\Components\Web\Controller{
        return $this->Controller;
    }

    /**
     * This function returns the application ID.
     * @return string
     */
    public function getID() : string{
        return $this->ID;
    }

    /**
     * This function returns the Session component.
     * @return Components\Web\Session
     */
    public function Session() : \GF\Components\Web\Session{
        return $this->Session;
    }

    /**
     * This function returns the application instance.
     * @return WebApplication
     */
    public static function getInstance() : WebApplication{
        static $instance = null;
        if($instance === null) $instance = new WebApplication();
        return $instance;
    }
}