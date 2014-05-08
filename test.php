<?php
/**
 * By  : Yanzekun
 * Date: 13-12-28
 * Time: 上午10:24
 */

require "./common.php";

global $gDB;
$sql = 'SELECT ip, total, province FROM ip_count_china limit 50';
$result = resultSet_to_array($gDB->Execute($sql, null));

echo '[';
foreach ($result as $item) {
    echo '"' . $item['ip'] . '",';
}
echo ']';

echo '<br/>';

echo '[';
foreach ($result as $item) {
    echo $item['total'] . ',';
}
echo ']';

echo '<br/>';

echo '[';
foreach ($result as $item) {
    echo '"' . $item['province'] . '",';
}
echo ']';