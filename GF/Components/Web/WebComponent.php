<?php
/**
 * This class is the base for every application component.
 */

namespace GF\Components\Web;

abstract class WebComponent {
    /**
     * Component identifier.
     * @var string
     */
    protected $ID;
    /**
     * Component attributes.
     * @var array
     */
    protected $attributes = [];

    /**
     * This function initializes the component.
     * @return mixed
     */
    public abstract function init();

    /**
     * This function starts the component.
     * @return mixed
     */
    public abstract function start();

}