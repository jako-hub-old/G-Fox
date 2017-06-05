<?php
/**
 * Created by PhpStorm.
 * User: jako
 * Date: 29/05/2017
 * Time: 8:26 PM
 */

namespace GF\DB;

class Model extends  \Howl\Model {
    /**
     * We override the constructor so we can load the database
     * settings when a model is instance.
     */
    public function __construct(){
        \GF\System::app()->initDB();
        parent::__construct();
    }
}