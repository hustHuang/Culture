<?php

require 'common.php';
//$words = "自拍 女装";
$type = $_REQUEST["type"];
$words = $_REQUEST["words"];
$words_array = explode(" ", $words);

global $gDB;
$result_array = array();
if ($type == "single") {
    $sql_s = "SELECT file,ip_count FROM words_files_new WHERE word = ? ORDER BY ip_count DESC LIMIT 20";
    foreach ($words_array as $word) {
        $word = trim($word);
        if ($word != "" && !is_null($word)) {
            $result = resultSet_to_array($gDB->Execute($sql_s, array($word)));
            $result_array[$word] = $result;
        }
    }
    echo json_encode($result_array);
} else if($type == "all") {
     
     $sql_a = "select file, ip_count from (select count(*) as count, file, ip_count from words_files_new where";
     $count = 0;
     foreach ($words_array as $word) {
        $word = trim($word);
        if ($word != "" && !is_null($word)) {
            $sql_a .= " word = '".$word."' or";
            $count++;
        }
    }
    $sql_a = substr($sql_a, 0, strlen($sql_a)-2);
    $sql_a .= " group by file) as a where count = ".$count." ORDER BY ip_count DESC LIMIT 20";
   
    //$sql = "select file, ip_count from (select count(*) as count, file, ip_count from words_files_new where word='多水' or word = '四十' group by file) as a where count = 2;";
    $result = resultSet_to_array($gDB->Execute($sql_a));
    echo json_encode($result);
}

?>
