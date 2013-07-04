<?php
## retrieved from the environment instead of the apache environment
## for flexiblity you can still set them in apache and update this code
## to something like this: $constant = (empty($getenv('SOMETHING'))) ? apache_getenv('SOMETHIGN') : getenv('SOMETHING');
define("SAW_DATABASE_MONGO_REPLICASET",getenv('SAW_DATABASE_MONGO_REPLICASET'));
define("SAW_DATABASE_MONGO_DATABASE",getenv('SAW_DATABASE_MONGO_DATABASE'));
define("SAW_DATABASE_MONGO_USERNAME",getenv('SAW_DATABASE_MONGO_USERNAME'));
define("SAW_DATABASE_MONGO_PASSWORD",getenv('SAW_DATABASE_MONGO_PASSWORD'));
define("SAW_DATABASE_MONGO_SERVERS",getenv('SAW_DATABASE_MONGO_SERVERS'));
define("SAW_DATABASE_MONGO_SAFE",(int)getenv('SAW_DATABASE_MONGO_SAFE'));
define("SAW_DATABASE_MONGO_FSYNC",(int)getenv('SAW_DATABASE_MONGO_FSYNC'));
