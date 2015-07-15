<?php
include "cal_action.php";
$json = $_REQUEST['json'];
$arr = json_decode($json, true);
$keyid = $arr['id'];  // delete_id

//var_dump($arr['id']);

$result["status"] = del_CalData($keyid)==0;

//result
//$result["status"] = true;

$tmp = json_encode($result);
echo $tmp;

?>