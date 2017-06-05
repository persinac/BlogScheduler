<?php
/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/11/2017
 * Time: 3:45 PM
 */


$root = realpath($_SERVER["DOCUMENT_ROOT"]);
//require $root . '/External Libraries/PHPExcel-1.8/Classes/PHPExcel.php';
//require 'mailer.php';
require $root . '/mongo/CRUD/classes/MongoUtility.php';
require $root . '/CRUD/classes/Employee.php';
//require $root . '/CRUD/classes/MonthData.php';
require $root . '/CRUD/classes/MonthDataEmployeeView.php';
require $root . '/CRUD/general/dateUtilities.php';
require $root . '/CRUD/general/mailer.php';

$monthData = GetMongoData();

$emailData = array();
echo "</br>";
echo "</br>";
$listOfMonthDataVW = array();
foreach($monthData as $doc) {
    if(!empty($doc->empId)) {
        $mdev = new MonthDataEmployeeView(
            (string)$doc->_id,-1,"","","","","");
        $result = GetEmployeeRecord($doc->empId);
        foreach($result as $empRecord) {
            $mdev->SetMonthDataEmployeeId($doc->empId);
            $mdev->SetMonthDataEmployeeEmail($doc->empEmail);
            $mdev->SetMonthDataBlogDate($doc->date);
            $mdev->SetMonthDataBlogStatus($doc->status);
            $mdev->SetMonthDataBlogTopic($doc->topic);
            $mdev->SetEmployeeName($empRecord->firstName);
        }
        if($mdev->GetMonthDataEmployeeId() > -1) {
            $emailData[] = $mdev;
        }
    }
}

foreach($emailData as $sendTo) {
    if(strlen($sendTo->empEmail) > 0) {
        sendMail($sendTo);
    }
}

function GetMongoData() {
    $lowHigh = GenerateLowHighDateRange();

    $mongoObj = new MongoUtility();
    $mongoObj->SelectDBToUse("test");
    $collectionName = GetCurrentMonth() . GetCurrentYear();
    $mongoObj->SelectCollection($collectionName);

    /* $gt = greater than */
    $filter = [
        'date' => ['$gt' => $lowHigh->low]
    ];
    $options = [];
    $result = $mongoObj->FindSpecific($filter, $options);
    $dataInRange[] = array();
    $lowFormatted = date('m/d/Y',strtotime($lowHigh->low));
    $highFormatted = date('m/d/Y',strtotime($lowHigh->high));
    foreach($result as $var) {

        if(is_object($var)) {
            $monthData = $var;
//            var_dump($monthData);
            $time = strtotime($monthData->date);
            $newformat = date('m/d/Y', $time);
            if ($newformat > $lowFormatted) {
                $newDateGreaterThanLowRange = 1;
            } else {
                $newDateGreaterThanLowRange = 0;
            }
            if ($highFormatted > $newformat) {
                $newDateLessThanHighRange = 1;
            } else {
                $newDateLessThanHighRange = 0;
            }
            if ($newDateGreaterThanLowRange == 1
                && $newDateLessThanHighRange == 1) {
                $dataInRange[] = $monthData;
            }
        }
    }
//    var_dump($dataInRange);
    return $dataInRange;
}

function GetEmployeeRecord($id) {
    $mongoObj = new MongoUtility();
    $mongoObj->SelectDBToUse("test");
    $collectionName = "Employees";
    $mongoObj->SelectCollection($collectionName);

    /* $gt = greater than */
    $filter = ['employee.id' => $id];
    $options = [
        'projection' => ['_id' => 0]
    ];
    $result = $mongoObj->FindSpecific($filter, $options);
//    var_dump($result);
    return $result;
}

function GetServiceAccount($email) {
    $mongoObj = new MongoUtility();
    $mongoObj->SelectDBToUse("test");
    $collectionName = "SERVICE_ACCOUNT";
    $mongoObj->SelectCollection($collectionName);

    /* $gt = greater than */
    $filter = ['email' => $email];
    $options = [
//        'projection' => ['_id' => 0]
    ];
    $result = $mongoObj->FindSpecific($filter, $options);
//    var_dump($result);
    return $result;
}
