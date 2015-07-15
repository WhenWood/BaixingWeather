<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/14
 * Time: 17:16





 */
//require_once "test.php";
require_once "cal_action.php";
require_once "weather_infos_action.php";
/*
 array("date"=>$date,
    "time"=> time(),
    "tmp"=>$tmp, //array
    "weather"=>$weather,//array
    "image"=>$image,//array
    "suggestion"=>$suggestion//array
);
*/


    $WeatherInfo = $_GET;
    $date = $WeatherInfo["date"];
    $weather = $WeatherInfo["weather"];
    $tmp = $WeatherInfo["tmp"];
    $weekarray = array("日","一","二","三","四","五","六");
    $week =  "星期".$weekarray[date("w",$WeatherInfo["date"])];

    $action = new weather_infos_action();
    $info = $add_info->getrecentinfo();
    $info->show();

    $action_cal = new calenders_action();
    $test_data = array("year"=>2014,"day"=>12,"month"=>01,"title"=>"dadw","level"=>"1","message"=>"121");
    add_CalData($test_data);







?>