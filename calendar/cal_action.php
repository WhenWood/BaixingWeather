<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/14
 * Time: 13:53
 */
require_once "basic-views.php";
require_once "calenders_action.php";

function obj2arr($o){
    $arr = explode("-",$o->start);
    return array(
    "keyid"=>$o->id,
    "level"=>$o->level,
    "message"=>$o->message,
    "year"=>$arr[0],
    "month"=>    $arr[0],
     "day"=>   $arr[0],
    "title"=>$o->title);
}


function convert_data($item){
    $myCalData = new CalData($item["title"], $item["keyid"],
        $item["year"]."-".$item["month"]."-".$item["day"],
        $item["level"], $item["message"]);
    return $myCalData;
}

function get_CalData($date) {

    $cal_Data = new calenders_action();
    $db_data =  $cal_Data->getmonth($date["year"],$date["month"]);

    $result = array();
    if(is_array($db_data)) {
        foreach ($db_data as $item) {
            $result[] = convert_data($item);
        }
    }
    return $result;
}

function update($data) {
    $cal_Data = new calenders_action();
    return $cal_Data->updatecalender($data,$data["id"]);
}

function add_CalData($data) {
    $cal_Data = new calenders_action();
    $new_id = $cal_Data->addcalender($data);
    return $new_id;
}

function del_CalData($data) {
    $cal_Data = new calenders_action();
    if($cal_Data->delcalender($data) === 0)
        echo json_encode(true) ;
    else
        echo json_encode(false) ;
}

function sel_calender($date) {
    $date_arr = explode("-",$date);
    $cal_Data = new calenders_action();
    $db_data =  $cal_Data->getweek($date_arr[0],$date_arr[1],$date_arr[2]);
    $result = array();
    if(is_array($db_data)) {
        foreach ($db_data as $item) {
            $result[] = convert_data($item);
        }
    }
   return $result;
}