<?php
/**
 * This is the main controller for the application.
 */
namespace Controllers;

use \GF\Components\Web\Controller;

class Main extends Controller {
    /**
     * This is the home action, it renders the home view.
     * @return string
     */
    public function Home(){
        return $this->render("home");
    }
}