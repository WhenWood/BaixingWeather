<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 15-7-13
 * Time: 下午10:43
 */

require_once("weather_info.php");
require_once("test.php");

class weather_infos_action
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

    public function addinfo($para)
    {
        $info=$para->value;
        if($info==NULL)
        {
            return self::$para_err;
        }
        $result=mysql_query("select * from weather_infos where date = '{$info['date']}'");
        $row=mysql_fetch_array($result);
        if($row==[])
        {
            $query="insert into weather_infos ";
            $query_keys="(date,time";
            $query_vaules=" values ({$info['date']},{$info['time']}";
            for($i=1;$i<=7;++$i)
            {
                $query_keys.=",temp{$i},weather{$i},img{$i},index{$i}";
                $query_vaules.=",{$info['tmp'][$i-1]},{$info['weather'][$i-1]}
                                ,{$info['image'][$i-1]},{$info['suggestion'][$i-1]}";
            }
            $query_keys.=")";
            $query_vaules.=")";
            $query.="{$query_keys}";
            $query.="{$query_vaules}";
            mysql_query($query);
            return self::$success;
        }
        else
        {
            $query="update weather_infos set ";
            $query.="time = '{$info['time']}'";
            for($i=1;$i<=7;++$i)
            {
                $query.=",temp{$i} = {$info['tmp'][$i-1]}";
                $query.=",img{$i} = {$info['image'][$i-1]}";
                $query.=",weather{$i} = {$info['weather'][$i-1]}";
                $query.=",index{$i} = {$info['suggestion'][$i-1]}";
            }
            $query.=" where date = '{$info['date']}'";
            mysql_query($query);
            return self::$success;
        }
    }

    public function getrecentinfo()
    {
        $result=mysql_query("select * from weather_infos ORDER BY time DESC limit 1");
        $row=mysql_fetch_array($result);
        if($row==[])
        {
            return self::$no_item_err;
        }
        $tmp=[];
        $weather=[];
        $image=[];
        $suggestion=[];
        for($i=1;$i<=7;++$i)
        {
            $s1="temp{$i}";
            $s2="weather{$i}";
            $s3="img{$i}";
            $s4="index{$i}";
            $tmp[]=$row["{$s1}"];
            $weather[]=$row["{$s2}"];
            $image[]=$row["{$s3}"];
            $suggestion[]=$row["{$s4}"];
        }
        $info=array(
            "date"=>$row["date"],
            "time"=>$row["time"],
            "tmp"=>$tmp,
            "weather"=>$weather,
            "image"=>$image,
            "suggestion"=>$suggestion
        );
        return new weather_info($info);
    }

}

?>