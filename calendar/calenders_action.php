<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 15-7-13
 * Time: 下午5:09
 */

require_once("calender.php");

function leap($year)
{
    return ($year%400==0)||($year%100!=0&&$year&3==0);
}

class calenders_action
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

    private static $days_per_month=[31,28,31,30,31,30,31,31,30,31,30,31];

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

    public function addcalender($calender)//array
    {
        if(!$calender||!is_array($calender))
        {
            return self::$para_err;
        }
        $query="insert into calenders (day,month,year,level,title,message)
                VALUES ({$calender['day']},{$calender['month']},{$calender['year']}
        ,{$calender['level']},{$calender['title']},{$calender['message']})";
        mysql_query($query);
        $result=mysql_query("select * from calenders where deleted = 0 order by keyid DESC limit 1");
        $row=mysql_fetch_array($result);
        return $row['keyid'];
    }

    public function getmonth($year,$month)
    {
        if($year==NULL||$month==NULL)
        {
            return self::$para_err;
        }
        $result=mysql_query("select * from calenders
                            where ((year = '{$year}')
                            and(month = '{$month}')
                            and(deleted = 0))
                            order by year,MONTH,DAY ");
        $calenders=[];
        while($row=mysql_fetch_array($result))
        {
            $calenders[]=array("keyid"=>$row['keyid'],
                                "day"=>$row['day'],
                                "month"=>$row['month'],
                                "year"=>$row['year'],
                                "message"=>$row['message'],
                                "title"=>$row['title'],
                                "level"=>$row['level']);
        }
        return $calenders;
    }

    public function getweek($year,$month,$day)
    {
        if(!$year||!$month||!$day)
        {
            return self::$para_err;
        }
        $year=intval($year);
        $month=intval($month);
        $day=intval($day);
        $query="select * from calenders where
                ((day = '{$day}' and month = '{$month}' and year = '{$year}')";
        for($i=2;$i<=7;++$i)
        {
            if(leap($year)){self::$days_per_month[1]=29;}
            ++$day;
            if($day>self::$days_per_month[$month-1])
            {
                $day=1;
                ++$month;
                if($month==13)
                {
                    $month=1;
                    ++$year;
                }
            }
            $query.="or(day = '{$day}' and month = '{$month}' and year = '{$year}')";
        }
        $query.=")and deleted = 0 order by year,month,day";
        $result=mysql_query($query);
        $calenders=[];
        while($row=mysql_fetch_array($result))
        {
            $calenders[]=array("keyid"=>$row['keyid'],
                "day"=>$row['day'],
                "month"=>$row['month'],
                "year"=>$row['year'],
                "message"=>$row['message'],
                "title"=>$row['title'],
                "level"=>$row['level']);
        }
        return $calenders;
    }

    public function updatecalender($calender,$keyid)
    {
        if(!$calender||!$keyid)
        {
            return self::$para_err;
        }
        $query="update calenders set level = '{$calender['level']}'
                                    ,message = '{$calender['message']}'
                                    ,title = '{$calender['title']}'
                                 where keyid = '{$keyid}'";
        mysql_query($query);
        return self::$success;
    }

    public function delcalender($keyid)
    {
        if(!$keyid)
        {
            return self::$para_err;
        }
        mysql_query("update calenders set deleted = 1 where keyid = '{$keyid}'");
        return self::$success;
    }

    public function clearall()
    {
        mysql_query("update calenders set deleted = 1");
    }
}

?>