<?php

/**
 * Created by PhpStorm.
 * User: apfba
 * Date: 5/4/2017
 * Time: 1:29 PM
 */
class CreateCollection
{
    protected $cmd = array();

    function __construct($collectionName) {
        $this->cmd["create"] = (string)$collectionName;
    }
    function setAutoIndexId($bool) {
        $this->cmd["autoIndexId"] = (bool)$bool;
    }
    function setCappedCollection($capped, $maxBytes = null, $maxDocuments = false) {
        $this->cmd["capped"] = $capped;
        $this->cmd["size"]   = (int)$maxBytes;

        if ($maxDocuments) {
            $this->cmd["max"] = (int)$maxDocuments;
        }
    }
    function usePowerOf2Sizes($bool) {
        if ($bool) {
            $this->cmd["flags"] = 1;
        } else {
            $this->cmd["flags"] = 0;
        }
    }
    function setFlags($flags) {
        $this->cmd["flags"] = (int)$flags;
    }
    function getCommand() {
        return new MongoDB\Driver\Command($this->cmd);
    }
    function getCollectionName() {
        return $this->cmd["create"];
    }
}