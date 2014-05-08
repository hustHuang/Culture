<?php
/**
 * By  : Yanzekun
 * Date: 13-12-28
 * Time: 上午10:24
 */
class DB {
	var $driver;
	var $host;
	var $username;
	var $password;
	var $table;
	var $debug;
	var $conn;
	function __construct($driver, $host, $username, $password, $table, $debug) {
		$this->driver = $driver;
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->table = $table;
		$this->debug = $debug;
	}
	function get_connection() {
		if (is_null ( $this->conn )) {
			if (! file_exists ( ABSPATH . '/lib/adodb5/adodb.inc.php' )) {
				echo "Cannot load lib " . (ABSPATH . '/lib/adodb5/adodb.inc.php') . ". Please check it.<br/>";
				return null;
			}
			require_once(ABSPATH . '/lib/adodb5/adodb.inc.php');
			$this->conn = NewADOConnection ( $this->driver );
			$this->conn->debug = $this->debug;
			$this->conn->autoRollback = true;
			$this->conn->Connect ( $this->host, $this->username, $this->password, $this->table );
			if (is_null ( $this->conn )) {
			}
		}
		return $this->conn;
	}
}

//end of script
