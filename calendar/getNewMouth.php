<?php
include "cal_action.php";
$json = $_REQUEST['json'];
$arr = json_decode($json, true);
$arr['year'];  //
$arr['month'];  //
$arr['day'];  //

// echo var_dump($arr['year']);
// echo var_dump($arr['month']);
// echo var_dump($arr['day']);



/*
class CalData{

	function __construct($id, $title, $start, $level, $message){
		$this->id = $id;
		$this->title = $title;
		$this->start = $start;
		$this->level = $level;
		$this->message = $message;
	}

	public $id = null;
	public $title = null;
	public $start = null; // 日期
	public $level = null;
	public $message = null;
}

*/


//test
//$arr = array(new CalData(6, 'qwe', '2015-08-01', '2', 'fdsfdsf'), new CalData(6, 'qwe', '2015-08-02', '2', 'fdsfdsf'));

$result['arr'] = get_CalData($arr);
//result
$result["status"] = true;

$tmp = json_encode($result);
echo $tmp;

?>