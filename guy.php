<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 15-7-13
 * Time: 下午5:10
 */

class guy
{
    public $email;
    public $name;

    public function guy($email,$name)
    {
        if($email==NULL){$email=" ";}
        if($name==NULL){$name=" ";}
        $this->email=$email;
        $this->name=$name;
    }

}

?>