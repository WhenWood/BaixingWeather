<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 15-7-13
 * Time: 下午10:41
 */

class weather_info {
    public $value;

    public function __construct($val)
    {
        $this->value=$val;
    }

    function __destruct(){}

    public function show()
    {
        $result=$this->value;
        foreach ($result as $key=>$items)
        {
            if(is_array($items))
            {
                foreach ($items as $key_i=>$item)
                {
                    print $key." ".$key_i." ".($item);
                    print "<br/>";
                }
            }
            else
            {
                print $key." ".($items);
                print "<br/>";
            }
        }
    }

}

?>