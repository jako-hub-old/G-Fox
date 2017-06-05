<?php
/**
 * This class helps to manipulate the session variables.
 *
 * @package GF\Components\Web
 * @author Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017, Jakolab
 */

namespace GF\Components\Web;

use GF\System;

class Session extends WebComponent {
    /**
     * Session content.
     * @var array
     */
    protected $session;

    public function __destruct() {}

    public function init(){
        $this->serialize();
    }

    public function start(){}

    /**
     * This function allows to put the sessions into a unique position that belongs to the application.
     */
    private function serialize(){
        $this->ID = System::app()->getID();
        if(!isset($_SESSION[$this->ID])) $this->push();
        else $this->pull();
    }

    /**
     * This function allows to store session variables.
     */
    private function push(){
        $_SESSION[$this->ID] = $this->session;
    }

    /**
     * This function takes the the session variables into this component.
     */
    private function pull(){
        $this->session = $_SESSION[$this->ID]?? [];
    }

    /**
     * This function returns a session variable for the current application.
     * @param string $name
     * @return string|mixed
     */
    public function getAttribute(string $name) : string{
        return $this->session[$name]?? null;
    }

    /**
     * This function allows to set a new variable into session.
     * @param string $name
     * @param $value mixed
     */
    public function setAttribute(string $name, $value){
        $this->session[$name] = $value;
        $this->push();
    }

    /**
     * This function allows to remove a session variable.
     * @param string $name
     */
    public function removeAttribute(string $name){
        unset($this->session[$name]);
        $this->push();
    }

    /**
     * This function allows to get a session variable (shortcut)
     * @param string $name
     * @return string
     */
    public static function getAttr(string $name) : string{
        return System::app()->Session()->getAttribute($name);
    }

    /**
     * This function allows to set a session variable (shortcut).
     * @param string $name
     * @param $value mixed
     */
    public function setAttr(string $name, $value){
        System::app()->Session()->setAttribute($name, $value);
    }

    /**
     * This function allows to remove a session variable (shortcut).
     * @param string $name
     */
    public function removeAttr(string $name){
        System::app()->Session()->removeAttribute($name);
    }
}