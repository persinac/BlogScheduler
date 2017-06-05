<?php
/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/10/2017
 * Time: 2:53 PM
 */

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/connections/ld_connection.php");
require_once ("$root/settings/settings.php");

class Employee
{
    var $id;
    var $firstName;
    var $lastName;
    var $email;
    var $phone;
    var $oid;

    function __construct($oid, $id, $firstName, $lastName, $email, $phone)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }

    /* Getters */
    function GetEmployeeOID() {
        return $this->id;
    }
    function GetEmployeeId() {
        return $this->id;
    }
    function GetEmployeeFirstName() {
        return $this->firstName;
    }
    function GetEmployeeLastName() {
        return $this->lastName;
    }
    function GetEmployeeName() {
        return $this->GetEmployeeFirstName() . $this->GetEmployeeLastName();
    }
    function GetEmployeeEmail() {
        return $this->email;
    }
    function GetEmployeePhone() {
        return $this->phone;
    }

    /* Setters */
    function SetEmployeeOID($val) {
        $this->oid = $val;
    }
    function SetEmployeeId($val) {
        $this->id = $val;
    }
    function SetEmployeeFirstName($val) {
        $this->firstName = $val;
    }
    function SetEmployeeLastName($val) {
        $this->lastName = $val;
    }
    function SetEmployeeEmail($val) {
        $this->email = $val;
    }
    function SetEmployeePhone($val) {
        $this->phone = $val;
    }
}