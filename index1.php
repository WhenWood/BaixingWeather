<?php
//if (!isset($_GET['cid']) || strlen($_GET['cid'])!=9 || !ctype_digit($_GET['cid'])) {
if (false) {
    $city = '';
    $body = '<h3>���д��벻�Ϸ���</h3>';
}
else {
    //$live = getlivedata($_GET["cid"]);
    $live = getlivedata(101010100);
    $city = $live['city'];
    $body = "{$live['time']}����<br />\n�¶ȣ�{$live['temp']}��<br />\nʪ�ȣ�{$live['SD']}<br />\n����{$live['WD']}<br />\n������{$live['WS']}<br />\n";
}
function getlivedata($cid) {
    if (!function_exists('curl_init')) {
        do {
            $data = file_get_contents('http://www.weather.com.cn/data/sk/'.$cid.'.html');
        } while ($data == '');
    }
    else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.weather.com.cn/data/sk/'.$cid.'.html');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        do {
            $data = curl_exec($ch);
        } while ($data == '');
        curl_close($ch);
    }
    $data = json_decode($data, TRUE);
    return $data['weatherinfo'];
}

?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo $city; ?>����ʵ��</title>
</head>
<body>
<?php echo $body; ?>
<br/>
<?php  echo var_dump($live)?>
</body>
</html>