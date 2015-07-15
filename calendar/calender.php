<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 15-7-13
 * Time: 下午5:10
 */

class calender
{
    public $date;
    public $message;
    public $level;

    public function __construct($date,$message,$level)
    {
        if($date==NULL){$date=" ";}
        if($message==NULL){$message=" ";}
        if($level==NULL){$level='0';}
        $this->date=$date;
        $this->message=$message;
        $this->level=$level;
    }
}

?>