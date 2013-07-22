<?php
define("SAW_SESSION_NAME",apache_getenv('SAW_SESSION_NAME'));
define("SAW_SESSION_COOKIE_DOMAIN",apache_getenv('SAW_SESSION_COOKIE_DOMAIN'));
// saw admin credentials
define("SAW_ADMIN_EMAIL",apache_getenv('SAW_ADMIN_EMAIL'));
define("SAW_ADMIN_PASSWORD",apache_getenv('SAW_ADMIN_PASSWORD'));
define("SAW_ADMIN_USER_ID",apache_getenv('SAW_ADMIN_USER_ID'));
define("SAW_ADMIN_DISPLAY_NAME",apache_getenv('SAW_ADMIN_DISPLAY_NAME'));
define("SAW_SITE_KEY",apache_getenv('SAW_SITE_KEY'));
define("SAW_INDEX_ROUTE",apache_getenv('SAW_INDEX_ROUTE'));
// upload directory constant.  this is needed by the template model when receiving template uploads to prepare them for processing
define("SAW_FILE_UPLOAD_DIR",apache_getenv('SAW_FILE_UPLOAD_DIR'));