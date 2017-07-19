<?php

/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 7/19/2017
 * Time: 11:23 AM
 */
class History
{
    public $event;
    public $value;
    public $createdOn;
    public $actor;

    function __construct($event, $val, $createdOn, $actor)
    {
        $this->event = $event;
        $this->value = $val;
        $this->createdOn = $createdOn;
        $this->actor = $actor;
    }

    /**
     * SETTERS
     */

    /**
     * @param $val
     */
    function SetEvent($val) {
        $this->event = $val;
    }

    function SetValue($val) {
        $this->value = $val;
    }

    function SetCreatedOn($val) {
        $this->createdOn = $val;
    }

    function SetActor($val) {
        $this->actor = $val;
    }

    /**
     * GETTERS
     */

    function GetEvent($val) {
        return $this->event;
    }

    function GetValue($val) {
        return $this->value;
    }

    function GetCreatedOn($val) {
        return $this->createdOn;
    }

    function GetActor($val) {
        return $this->actor;
    }


}