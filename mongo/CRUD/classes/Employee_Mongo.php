<?php

/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/26/2017
 * Time: 11:20 AM
 */
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root . '/mongo/CRUD/classes/MongoUtility.php';
require_once $root . '/CRUD/general/dateUtilities.php';

class Employee_Mongo
{
    var $mongoObj;

    public function __construct($dbName, $collection)
    {
        $this->mongoObj = new MongoUtility();
        if(empty($dbName) || strlen($dbName) == 0) {
            $this->mongoObj->SelectDBToUse("test");
        } else {
            $this->mongoObj->SelectDBToUse($dbName);
        }

        if(empty($collection) || strlen($collection) == 0) {
            $this->mongoObj->SelectDBToUse("Employees");
        } else {
            $this->mongoObj->SelectCollection($collection);
        }
    }

    public function GetAllEmployees() {
        $filter = [];
        $options = [];
        $result = $this->mongoObj->FindSpecific($filter, $options);
        return $result;
    }

    public function GetEmployeeById($id) {
        $filter = ['employee.id' => $id];
        $options = [];
        $result = $this->mongoObj->FindSpecific($filter, $options);
        return $result;
    }
}