<?php

/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/26/2017
 * Time: 11:32 AM
 */
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root . '/mongo/CRUD/classes/MongoUtility.php';
require_once $root . '/CRUD/general/dateUtilities.php';

class BlogData_Mongo
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
            $this->mongoObj->SelectDBToUse(GetCurrentMonth() . GetCurrentYear());
        } else {
            $this->mongoObj->SelectCollection($collection);
        }
    }

    public function GetAllBlogData() {
        $filter = [];
        $options = [
            //'projection' => ['_id' => 0]
        ];

        $result = $this->mongoObj->FindSpecific($filter, $options);
        return $result;
    }
}