<?php
/**
 * By  : Yanzekun
 * Date: 13-12-28
 * Time: 上午10:24
 */
define ( 'DB_DRIVER', 'mysql' );
//define ( 'DB_NAME', 'culture' );
//define ( 'DB_USER', 'root' );
//define ( 'DB_PASSWORD', '123' );
//define ( 'DB_HOST', 'localhost' );
define ( 'DB_NAME', 'emule' );
define ( 'DB_USER', 'maxuser_emule' );
define ( 'DB_PASSWORD', 'K6BR.WnJV3$9F{:QCXaf' );
define ( 'DB_HOST', '202.114.32.173' );
define ( 'DB_CHARSET', 'utf8' );
define ( 'DB_DEBUG', false );

define ( 'ABSPATH', dirname ( __FILE__ ) );

require_once(ABSPATH . './functions.php');

connect_DB ();

//end of script