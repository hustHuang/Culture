<?php

require "./common.php";
set_time_limit(0);

$province_pinyin = $_POST["provience"];

global $gDB;
$sql = 'SELECT province, ip, total, area FROM ip_count_china WHERE province_pinyin = ? ORDER BY total DESC LIMIT 20';
$result = resultSet_to_array($gDB->Execute($sql, array($province_pinyin)));
echo json_encode($result);
