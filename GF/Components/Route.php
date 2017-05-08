<?php
/**
 * This class is the route builder, it allows to register routes and manipulate
 * the application url.
 * @package GF\Components
 * @author  Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017 Jakolab
 */

namespace GF\Components;

class Route {
    /**
     * Current route in the application.
     * @var string
     */
    private static $currentRoute;
    /**
     * Current action to be executed.
     * @var callable
     */
    private static $callable;
    /**
     * Route called in the routes.
     * @var string
     */
    private static $calledRoute = null;
    /**
     * Parameters passed to the called action.
     * @var array
     */
    private static $routeParams = [];
    /**
     * Type of the current request.
     * @var int
     */
    private static $typeOfRequest;

    /**
     * This function searches for the current route.
     */
    public static function readRoute(){
        $get = filter_input_array(INPUT_GET)?? [];
        $route = filter_input(INPUT_GET, 'r', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($route == "") $route = "/";
        unset($get['r']);
        self::$currentRoute = $route;
    }

    /**
     * This function defines a get route.
     * @param string $route
     * @param $params
     * @return bool
     */
    public static function get(string $route, $params){
        if(self::$calledRoute !== null && !self::compare(self::$currentRoute, $route))
            return false;
        self::$callable = $params;
        self::$calledRoute = $route;
        self::$typeOfRequest = \GF\Components\Request::GET;
    }

    /**
     *  This function builds the params to be passed to the invoked action.
     * @param $pattern string
     * @return bool
     */
    private static function buildParams(string $pattern) : bool{
        preg_match_all($pattern, self::$currentRoute, $matches);
        if(count($matches) > 1){
            $len = count($matches);
            for ($i = 1; $i < $len; $i ++) self::$routeParams[] = $matches[$i][0];
        }
        return true;
    }

    /**
     * This function compares two routes and returns if tey match.
     * @param string $current
     * @param string $requested
     * @return bool
     */
    private static function compare(string $current, string $requested){
        # We find all the params in the url.
        preg_match_all("|\/?[a-z]+:|", $requested, $matches, PREG_PATTERN_ORDER);
        $pattern = "|^" . self::buildRegEx($requested, $matches) . "$|";
        if($pattern == self::$currentRoute) return true;
        else if(preg_match($pattern, $current) != 0) return self::buildParams($pattern);
        else return false;
    }

    /**
     * This function builds and regular expression to be used comparing the routes.
     * @param string $route
     * @param array $matches
     * @return mixed|string
     */
    private static function buildRegEx(string $route, array $matches = []){
        if(!isset($matches[0]) || empty($matches[0])) return $route;
        $params = $matches[0];
        $pattern = $route;
        foreach($params AS $param){
            $rep =  is_int(strpos($param, "/"))? '\/(\w+)' : '(\w+)';
            $pattern = str_replace($params, $rep, $pattern);
        }
        return $pattern;
    }

    /**
     * This function returns the current invoked route in the browser.
     * @return string
     */
    public static function getCurrentRoute(){
        return self::$currentRoute;
    }

    /**
     * This function returns the route that matches with the current route.
     * @return string
     */
    public static function getInvokedRoute(){
        return self::$calledRoute;
    }

    /**
     * This function returns the route params added in the url.
     * @return array
     */
    public static function getRouteParams(){
        return self::$routeParams;
    }

    /**
     * This function returns the type of request.
     * @return int
     */
    public static function getTypeOfRequest(){
        return self::$typeOfRequest;
    }

    /**
     * This function returns the action assigned to the route.
     * @return callable
     */
    public static function getAction(){
        return self::$callable;
    }
}