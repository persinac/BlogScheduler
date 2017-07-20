<?php

/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 7/19/2017
 * Time: 2:24 PM
 */

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root . '/connections/mongo_connection.php';
require_once $root . '/mongo/CRUD/classes/CreateCollection.php';
require_once $root . '/CRUD/classes/History.php';

class History_Mongo extends History
{
    var $mongoObj;

    public function __construct($dbName = "", $collection = "")
    {
        $this->mongoObj = new MongoUtility();
        if(empty($dbName) || strlen($dbName) == 0) {
            $this->mongoObj->SelectDBToUse("test");
        } else {
            $this->mongoObj->SelectDBToUse($dbName);
        }

        if(empty($collection) || strlen($collection) == 0) {
            $this->mongoObj->SelectCollection("HISTORY");
        } else {
            $this->mongoObj->SelectCollection($collection);
        }
    }

    public function InsertIntoHistory($historyObj) {

//        var_dump($historyObj);
        $result = $this->mongoObj->InsertIntoCollection($historyObj);
        return $result;
    }

    public function GetAllHistory() {
        $result = $this->mongoObj->FindAll();
        return $result;
    }

    public function GetHistoryByEvent($eventId) {
        $filter = ['event' => $eventId];
        $options = [];
        $result = $this->mongoObj->FindSpecific($filter, $options);
        return $result;
    }
}