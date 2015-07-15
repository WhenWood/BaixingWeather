<?php

    require_once "weather_info_action.php";
    //require_once "weather_infos_action.php";

    $ch = curl_init();
    $url = 'http://apis.baidu.com/heweather/weather/free?city=shanghai';
    $header = array(
        'apikey: 1ed2959b377806d883716be9898aa951',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
    
    //var_dump($res);
    //echo '<br/>';
    //echo $res;

    $temp = json_decode($res, true);
    $jsonContent = $temp['HeWeather data service 3.0'];
    $content = $jsonContent['0'];
    //基本信息
    $array1 = $content['basic'];
    //实况天气
    $array2 = $content['now'];
    //空气质量
    $array3 = $content['aqi'];
    //天气预报，国内7天
    $array4 =$content['daily_forecast'];
    //每小时天气预报，免费接口为每三小时预报
    $array5 = $content['hourly_forecast'];
    //生活指数
    $array6 = $content['suggestion'];

    $date = $array1["update"]["loc"];
    $tmp = array();
    $weather = array();
    $image = array();
    $suggestion = array();
    foreach($array4 as $key=>$value){
        $tmp[$key] =  $array4[$key]["tmp"]["max"]."-".$array4[$key]["tmp"]["min"];
        $weather[$key] = $array4[$key]["cond"]["txt_d"];//这里会有个问题 晚上无法获取白天天气。
        $image[$key] = "image1";
    }

    $suggestion[] = $array6["comf"]["brf"]."-".$array6["comf"]["txt"];
    $suggestion[] = $array6["cw"]["brf"]."-".$array6["cw"]["txt"];
    $suggestion[] = $array6["drsg"]["brf"]."-".$array6["drsg"]["txt"];
    $suggestion[] = $array6["flu"]["brf"]."-".$array6["flu"]["txt"];
    $suggestion[] = $array6["sport"]["brf"]."-".$array6["sport"]["txt"];
    $suggestion[] = $array6["trav"]["brf"]."-".$array6["trav"]["txt"];
    $suggestion[] = $array6["uv"]["brf"]."-".$array6["uv"]["txt"];

    $tmp[0] = $array5[0]["tmp"];

    $result = array("date"=>$date,
                "time"=> time(),
                "tmp"=>$tmp, //array
                "weather"=>$weather,//array
                "image"=>$image,//array
                "suggestion"=>$suggestion//array
            );


    //var_dump(json_decode($res));

    $info = new weather_info($result);

    $add_info = new weather_infos_action();
    $add_info-> addinfo($info);

    //$info->show();
    //$result =  $info->value;
    //foreach ($result as $key=>$items){
    //    if(is_array($items)) {
    //        foreach ($items as $key_i=>$item) {
    //            print $key." ".$key_i." ".($item);
    //            print "<br/>";
    //        }
    //    }else {
    //        print $key . " " . ($items);
    //        print "<br/>";
    //    }
    //}




?>