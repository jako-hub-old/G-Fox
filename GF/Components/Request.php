<?php
/**
 * This class is the route represents the current request, it stores information about
 * the request.
 * @package GF\Components
 * @author  Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017 Jakolab
 */

namespace GF\Components;

class Request {
    const GET = 0;
    const POST = 1;
    const PUT = 2;
    const UPDATE = 3;
    const DELETE = 4;
    /**
     * Type of request.
     * @var int
     */
    private $type;
    /**
     * Invoked route.
     * @var
     */
    private $route;
    /**
     * The params passed to the current route.
     * @var array
     */
    private $params;
    /**
     * The action assigned to the route.
     * @var callable
     */
    private $requestedAction;

    /**
     * This function initializes the request component.
     */
    public function init(){
        $this->type = Route::getTypeOfRequest();
        $this->route = Route::getInvokedRoute();
        $this->params = Route::getRouteParams();
        $this->requestedAction = Route::getAction();
    }

    /**
     * This function dispatches the request.
     */
    public function dispatch(){}

    /**
     * This function returns the type of request executed.
     * @return int
     */
    public function getType(){
        return $this->type;
    }

    /**
     * This function returns the route assigned to the request.
     * @return mixed
     */
    public function getRoute(){
        return $this->route;
    }

    /**
     * This function returns the params assigned to the current route.
     * @return array
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * This function returns the action assigned to the current route.
     * @return callable
     */
    public function getRequestedAction(){
        return $this->requestedAction;
    }
}