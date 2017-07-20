<?php

/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/15/2017
 * Time: 2:02 PM
 */
class HTMLBuilder
{
    var $html;
    var $obj;

    /***
     * @param $obj
     *
     * obj structure:
     *  [
     *      headers: ["x","y","z"],
     *      data: [ <obj>, <obj>, <obj> ]
     *  ]
     *
     */
    function __construct($obj)
    {
        $this->obj = $obj;
    }

    function BuildTable($order = array(), $tableId = "", $oid = "") {
        $this->html = '<table class="standard_table" id="'.$tableId .'">';
        $this->BuildTableHeaders();
        $this->BuildTableRows($order, $oid);
        $this->html .= '</table>';
        $this->html .= '<div id="containerForTableLinkClicks"></div>';
    }

    function BuildTableHeaders() {
        $this->html .= '<tr>';
        foreach($this->obj as $items) {
            foreach($items["headers"] as $hdrs) {
                $this->html .= '<th>';
                $this->html .= $hdrs;
                $this->html .= '</th>';
            }
        }
        $this->html .= '</tr>';
    }

    function BuildTableRows($order = array(), $oid = "")
    {
        foreach ($this->obj as $object) {
            foreach ($object["data"] as $items) {

                $itemDataArr = json_decode(json_encode($items), True);
                $this->html .= '<tr>';
                if(count($order) > 0) {
                    if(!is_null($itemDataArr)) {
//                        var_dump($itemDataArr);
                        foreach ($order as $fieldName) {
                            $val = $itemDataArr["$fieldName"];
                            if ($fieldName == "empId") {
                                $this->html .= '<td>';
                                $this->html .= '<a ';
                                $this->html .= 'id="'.$val.'" href="#" class="details"';
                                $this->html .= ' data-oid="'.$itemDataArr["$oid"].'"';
//                                $this->html .= ' data-oid="'.$itemDataArr["$oid"].'"';
//                                $this->html .= ' data-oid="'.$itemDataArr["$oid"].'"';
//                                $this->html .= ' data-oid="'.$itemDataArr["$oid"].'"';
//                                $this->html .= ' data-oid="'.$itemDataArr["$oid"].'"';
                                $this->html .= '>';
                                $this->html .= $val;
                                $this->html .= '</a>';
                                $this->html .= '</td>';
                            } else if ($fieldName == "topic") {
                                $this->html .= '<td> - </td>';
                            }
                            else if (!empty($val)) {
                                $this->html .= '<td>';
                                $this->html .= $val;
                                $this->html .= '</td>';
                            } else {
                                $this->html .= '<td></td>';
                            }
                        }
                    }
                } else {
                    foreach ($items as $itemField) {
                        $this->html .= '<td>';
                        $this->html .= $itemField;
                        $this->html .= '</td>';
                    }
                }
                $this->html .= '</tr>';
            }
        }
    }

    function GetHTML() {
        return $this->html;
    }
}