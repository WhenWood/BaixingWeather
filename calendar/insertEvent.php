<?php
include "cal_action.php";
$json = $_REQUEST['json'];
//var_dump($json);


//$json = $_REQUEST[''];
$arr = json_decode($json, true);
$title = $arr['title'];
$message  = $arr['message'];
$id = $arr['id']; // may be null
$date = $arr['date']; // 2015-7-13
//var_dump($arr);
$result = array();
if($id == null){
    $result["id"] = add_CalData($arr);
    $result["status"] =  ($result["id"]>=0);

}else{
    $result["status"] =  update($id,$arr);
}

//result
//$result["status"] = true;
//$result["id"] = 10;

$tmp = json_encode($result);
echo $tmp;

?>