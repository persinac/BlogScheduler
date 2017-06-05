<?php
/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/11/2017
 * Time: 10:16 AM
 */

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/connections/ld_connection.php");
require_once ("$root/settings/settings.php");

class MonthData
{
//    var $monthData;
    var $blogOid;
    var $empId;
    var $empEmail;
    var $date;
    var $topic;
    var $status;

    function __construct($blogOid, $empId, $empEmail, $date, $topic, $status)
    {
        $this->blogOid = $blogOid;
        $this->empId = $empId;
        $this->empEmail = $empEmail;
        $this->date = $date;
        $this->topic = $topic;
        $this->status = $status;
    }

    /* Getters */
    function GetMonthDataBlogOID() {
        return $this->blogOid;
    }
    function GetMonthDataEmployeeId() {
        return $this->empId;
    }
    function GetMonthDataEmployeeEmail() {
        return $this->empEmail;
    }
    function GetMonthDataBlogDate() {
        return $this->date;
    }
    function GetMonthDataBlogTopic() {
        return $this->topic;
    }
    function GetMonthDataBlogStatus() {
        return $this->status;
    }

    /* Setters */
    function SetMonthDataBlogOID($val) {
        $this->blogOid = $val;
    }
    function SetMonthDataEmployeeId($val) {
        $this->empId = $val;
    }
    function SetMonthDataEmployeeEmail($val) {
        $this->empEmail = $val;
    }
    function SetMonthDataBlogDate($val) {
        $this->date = $val;
    }
    function SetMonthDataBlogTopic($val) {
        $this->topic = $val;
    }
    function SetMonthDataBlogStatus($val) {
        $this->status = $val;
    }
}