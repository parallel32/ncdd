<?php
//////////////////////
// Define Constants //
//////////////////////

// the probability a service task will run
define("CHANCE_SERVICE",20);

/* 
// kinollc test app
define("GOOGLE_DRIVE_CLIENT_ID", '947790988235-s2hrf1br8m3ug2gpohu744crltruqcmc.apps.googleusercontent.com');
define("GOOGLE_DRIVE_SERVICE_ACCOUNT_NAME", '947790988235-s2hrf1br8m3ug2gpohu744crltruqcmc@developer.gserviceaccount.com');
define("GOOGLE_DRIVE_KEY_FILE_LOCATION", '/var/www/ncdd/config/78c3d71f31e8d1d74bc713ee11e09bfa92978288-privatekey-kinollc-Drive-Porject.p12');
define("GOOGLE_DRIVE_APPLICATION_NAME", "Drive Project");
define("GOOGLE_DRIVE_PRN", 'mike@kinollc.com');
// this can be a csv (comma separated value)
define("GOOGLE_DRIVE_API_SCOPE", 'https://www.googleapis.com/auth/drive ');
//*/

//*
// ncdd 
define("GOOGLE_DRIVE_CLIENT_ID", '380737956111-vtjukrbm82jupiugdtn4ala978286j37.apps.googleusercontent.com');
define("GOOGLE_DRIVE_SERVICE_ACCOUNT_NAME", '380737956111-vtjukrbm82jupiugdtn4ala978286j37@developer.gserviceaccount.com');
define("GOOGLE_DRIVE_KEY_FILE_LOCATION", '/var/www/ncdd/config/a1c0558c261497fbaff083cf33d794ba3b624c25-privatekey-ncdd-VFL-Search-Files.p12');
define("GOOGLE_DRIVE_APPLICATION_NAME", "VFL Search Files");
define("GOOGLE_DRIVE_PRN", 'mikeh@ncdd.com');
// this can be a csv (comma separated value)
define("GOOGLE_DRIVE_API_SCOPE", 'https://www.googleapis.com/auth/drive ');
//*/

define("PAGE_STATUS_PUBLISHED", 30);
define("PAGE_STATUS_PENDING_MODERATION", 20);
define("PAGE_STATUS_PENDING_APPROVAL", 10);
define("PAGE_STATUS_UNPUBLISHED", 0);
define("PAGE_STATUS_EXPIRED", -10);
define("PAGE_STATUS_DEACTIVATED", -20);

define("PAGE_DEFAULT_PUBLISH_STATUS", PAGE_STATUS_PENDING_MODERATION);
$app['humanizePageStatus'] = $app->protect(function($pageStatus){
	switch ($pageStatus) {        
		case PAGE_STATUS_EXPIRED:
			return 'EXPIRED';
			break;        
		case PAGE_STATUS_DEACTIVATED:
			return 'DEACTIVATED';
			break;
        case PAGE_STATUS_PENDING_MODERATION:
        case PAGE_STATUS_PENDING_APPROVAL: 
            return 'PENDING';
            break;            
		case PAGE_STATUS_PUBLISHED:
            return 'PUBLISHED';
            break;
		default:
			return 'DRAFT';
			break;        
	}
});

// user constants
define("USER_STATUS_ACTIVE", 2);
define("USER_STATUS_VERIFIED", 1);
define("USER_STATUS_UNVERIFIED", 0);
define("USER_STATUS_INACTIVE", -1);

// user constants
// - access levels
define("ADMIN", 300);
define("EDITOR",200); // top level users (account holder)
define("MEMBER",100); // editors are made by clients or by admin but still with a client parent
define("UNPAIDMEMBER",50); // editors are made by clients or by admin but still with a client parent
define("STRINGIFY_ACCESS_LEVELS", "ADMIN:300|EDITOR:200|MEMBER:100|UNPAIDMEMBER:50");
$app['humanizeAccessLevels'] = $app->protect(function ($accessLevel) {
	switch (floor($accessLevel)) {
		case 300:
			return 'ADMIN';
			break;
		case 200:
			return 'EDITOR';
			break;
		case 100:
			return 'MEMBER';
			break;
		case 50:
			return 'UNPAIDMEMBER';
			break;
	}
});

// environment constants
define("SAW_ADMIN_WEBSITE",apache_getenv('SAW_ADMIN_WEBSITE'));
define("SAW_CONSUMER_WEBSITE",apache_getenv('SAW_CONSUMER_WEBSITE'));
define("SAW_SERVER_NAME",apache_getenv('SAW_SERVER_NAME'));
define("SAW_SERVER_PUBLIC_NAME",apache_getenv('SAW_SERVER_PUBLIC_NAME'));
define("SAW_SERVER_PUBLIC_URL",apache_getenv('SAW_SERVER_PUBLIC_URL'));
define("SAW_BASE_URL",apache_getenv('SAW_BASE_URL'));
define("SAW_IMAGE_BASE",apache_getenv('SAW_IMAGE_BASE'));
define("SAW_CDN",apache_getenv('SAW_CDN'));
define("SAW_SSL_CDN",apache_getenv('SAW_SSL_CDN'));
define("SAW_PUBLIC_CDN",apache_getenv('SAW_PUBLIC_CDN'));
define("SAW_PUBLIC_SSL_CDN",apache_getenv('SAW_PUBLIC_SSL_CDN'));
define("SAW_CDN_IMAGE",apache_getenv('SAW_CDN_IMAGE'));
define("SAW_SSL_CDN_IMAGE",apache_getenv('SAW_SSL_CDN_IMAGE'));

define("SAW_MAILER_HOST",apache_getenv('SAW_MAILER_HOST'));
define("SAW_MAILER_PORT",(int)apache_getenv('SAW_MAILER_PORT'));
define("SAW_MAILER_USERNAME",apache_getenv('SAW_MAILER_USERNAME'));
define("SAW_MAILER_PASSWORD",apache_getenv('SAW_MAILER_PASSWORD'));
define("SAW_MAILER_ENCRYPTION",apache_getenv('SAW_MAILER_ENCRYPTION'));
define("SAW_MAILER_FROM",apache_getenv('SAW_MAILER_FROM'));
define("SAW_MAILER_FROM_NAME",apache_getenv('SAW_MAILER_FROM_NAME'));
define("SAW_MAILER_BCC_TO",apache_getenv('SAW_MAILER_BCC_TO'));

define("SAW_FDGG_URL",apache_getenv('SAW_FDGG_URL'));
define("SAW_FDGG_USERPWD",apache_getenv('SAW_FDGG_USERPWD'));
define("SAW_FDGG_SSLCERT",apache_getenv('SAW_FDGG_SSLCERT'));
define("SAW_FDGG_SSLKEY",apache_getenv('SAW_FDGG_SSLKEY'));
define("SAW_FDGG_SSLKEYPASSWD",apache_getenv('SAW_FDGG_SSLKEYPASSWD'));

define("SAW_STRIPE_PUBLIC_KEY",apache_getenv('SAW_STRIPE_PUBLIC_KEY'));
define("SAW_STRIPE_SECRET_KEY",apache_getenv('SAW_STRIPE_SECRET_KEY'));

define("SAW_AWS_KEY",apache_getenv('SAW_AWS_KEY'));
define("SAW_AWS_SECRET",apache_getenv('SAW_AWS_SECRET'));

define("SAW_SALT", '$2y$08$ncddjack2012tomthumb$');
define("SAW_SALT_KEYWORD",'n@dd');

define("SAW_UNKNOWN_USER_ID","401xxxxxxxxxxxxxxxxxxxxx");

require_once __DIR__.'/bootstrap.constants.mail.php';
require_once __DIR__.'/bootstrap.constants.database.php';
require_once __DIR__.'/bootstrap.constants.session.php';