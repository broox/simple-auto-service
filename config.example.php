<?php
define('SITE_TITLE', 'Simple Auto Service');
define('SITE_URL', 'http://localhost');

/* Define some MySQL connection parameters either here or as application environment variables */
define('DB_NAME', isset($_SERVER['AUTO_DB_NAME']) ? $_SERVER['AUTO_DB_NAME'] : 'auto_service');
define('DB_USER', isset($_SERVER['AUTO_DB_USER']) ? $_SERVER['AUTO_DB_USER'] : 'username');
define('DB_PASSWORD', isset($_SERVER['AUTO_DB_PASS']) ? $_SERVER['AUTO_DB_PASS'] : 'password');
define('DB_HOST', isset($_SERVER['AUTO_DB_HOST']) ? $_SERVER['AUTO_DB_HOST'] : 'localhost');
?>