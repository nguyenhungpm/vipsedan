<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/vipsedan/');
define('HTTP_CATALOG', 'http://localhost/vipsedan/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/vipsedan/');
define('HTTPS_CATALOG', 'http://localhost/vipsedan/');

// DIR
define('DIR_APPLICATION', 'D:/study/xampp/htdocs/vipsedan/admin/');
define('DIR_SYSTEM', 'D:/study/xampp/htdocs/vipsedan/system/');
define('DIR_IMAGE', 'D:/study/xampp/htdocs/vipsedan/image/');
define('DIR_STORAGE', 'D:/study/xampp/htdocs/vipsedan/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
// define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'vipsedan');
define('DB_PORT', '3306');
define('DB_PREFIX', 'se_');