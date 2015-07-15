<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 15-7-13
 * Time: 下午3:49
 */

require_once("guy.php");

class guys_action
{

    private static $sql_host="127.0.0.1";
    private static $sql_name="root";
    private static $sql_passwd="0summer3";

    private static $select_db="BaixingWeather_db";
    private static $active=0;
    private static $no_item_err=-1;//条目不存在
    private static $add_repeat_err=-2;//重复添加
    private static $success=0;
    private static $para_err=-3;//参数错误

    public function __construct()
    {
        ++self::$active;
        if(self::$active==1)
        {
            mysql_connect(self::$sql_host,self::$sql_name,self::$sql_passwd);
            mysql_select_db(self::$select_db);
        }
    }

    public function __destruct()
    {
        --self::$active;
        if(self::$active==0)
        {
            mysql_close();
        }
    }

    public function addguy($email,$name)
    {
        if($email==NULL)
        {
            return self::$para_err;
        }
        if($name==NULL)
        {
            $name=" ";
        }
        $result=mysql_query("select * from guys where email = '{$email}'");
        $row=mysql_fetch_array($result);
        if($row!=[])
        {
            if($row['deleted']==0)
                return self::$add_repeat_err;
            else
            {
                mysql_query("update guys set deleted = 0,name = '{$name}' where email = '{$email}'");
                return self::$success;
            }
        }
        mysql_query("insert into guys (email, name) VALUES ('{$email}', '{$name}')");
        return self::$success;
    }

    public function delguy($email)
    {
        if($email==NULL)
        {
            return self::$para_err;
        }
        mysql_query("update guys set deleted = 1 where email = '{$email}'");
        return self::$success;
    }

    public function listguys()
    {
        $result=mysql_query("select * from guys where deleted = 0");
        $guys=[];
        while($row=mysql_fetch_array($result))
        {
            $guys[]=new guy($row['email'],$row['name']);
        }
        return $guys;
    }

    public function clearall()
    {
        mysql_query("update guys set deleted = 1");
    }

}


?>