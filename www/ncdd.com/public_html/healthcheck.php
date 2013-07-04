<?php
try {
	$conn_str	= 'mongodb://'.apache_getenv('SAW_DATABASE_MONGO_SERVERS');
	$conn_opts	= array('replicaSet' => apache_getenv('SAW_DATABASE_MONGO_REPLICASET'));
	$conn 		= new MongoClient($conn_str, $conn_opts);
	$db 		= $conn->selectDB(apache_getenv('SAW_DATABASE_MONGO_DATABASE'));
				  $db->setReadPreference(\MongoClient::RP_PRIMARY_PREFERRED);
	$collection	= $db->selectCollection('session');
	$result		= $collection->findOne();
	header("HTTP/1.1 200 OK");
	echo "all systems up ";
} catch (Exception $e) {
	$Name = apache_getenv('SAW_SERVER_NAME'); //senders name
	$email = apache_getenv('SAW_ERROR_LOG_MAILER_FROM'); //senders e-mail adress
	$recipient = apache_getenv('SAW_ERROR_LOG_MAILER_TO'); //recipient
	$mail_body = $e->getMessage(); //mail body
	$subject = apache_getenv('SAW_SERVER_NAME')." - Health Check Exception"; //subject
	$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields
	mail($recipient, $subject, $mail_body, $header); //mail command :)
	header("HTTP/1.1 500 Internal Server Error");
}