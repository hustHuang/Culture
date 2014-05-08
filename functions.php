<?php
/**
 * By  : Yanzekun
 * Date: 13-12-28
 * Time: 上午10:24
 */

function connect_DB() {
    global $gDB;
    require_once(ABSPATH . "./DB.class.php");

    if (isset($gDB))
        return;
    $db = new DB(DB_DRIVER, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_DEBUG);
    $gDB = $db->get_connection();
    $gDB->SetFetchMode(ADODB_FETCH_ASSOC);

    if (is_null($gDB)) {
        die("连接数据库失败，请检查配置。");
    }
}

function resultSet_to_array($rs) {
	/* ResultSet 为空时返回 null */
	if (!$rs || $rs->RecordCount() == 0)
		return null;

	$result = array();
	$column_count = $rs->FieldCount();
	$rs->Move(0);
	while ($row = $rs->FetchRow()) {
		$array_of_row = array();
		for ($i = 0; $i < $column_count; $i++) {
			$column_name = $rs->FetchField($i)->name;
			$array_of_row[$column_name] = $row[$column_name];
		}
		array_push($result, $array_of_row);
	}

	return $result;
}

function write_log($content, $filename='log.txt') {
    $file = fopen(FILE_SERVER_REAL_PATH . '/log/' . $filename, 'a+');
    $now = date("Y-m-d H:i:s", time());
    fwrite($file, $now . "\t" . $content . "\r\n");
    fclose($file);
}