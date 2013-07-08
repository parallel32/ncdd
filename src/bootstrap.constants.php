<?php
//////////////////////
// Define Constants //
//////////////////////

// minimum allowed invoice total that can be charged in dollars
define("MINIMUM_INVOICE_TOTAL", 1);
define("MINIMUM_INVOICE_TRANSACTION_AMOUNT", 1);
define("PAYMENT_CHARGE_CURRENCY", 'usd');
// invoice constants
define("INVOICE_PAID", 3);
define("INVOICE_OVERDUE", 2);
define("INVOICE_UNPAID", 1);
define("PAYMENT_TYPE_CC", "cc");
define("PAYMENT_TYPE_CHECK", "check");
define("PAYMENT_TYPE_FRIENDS", "friends");
define("INVOICE_ITEM_TYPE_SALE", "sale");
define("SUCCEEDED", 1);
define("DECLINED", 0);

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
define("STRINGIFY_ACCESS_LEVELS", "ADMIN:300|CLIENT:200|EDITOR:100");
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