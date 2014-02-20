#!/bin/bash

#### temp commented out ###
#echo "making ssl files......"
#/home/ec2-user/staging/config/ssl_maker.sh

echo "minifying......"
#/home/ec2-user/staging/config/minify_css.sh
/home/ec2-user/staging/config/minify_js.sh
### temp commented out ###


echo "sync web1"
rsync --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" --exclude "vendor" -rlz /home/ec2-user/staging/ncdd/ ec2-user@web1:/var/www/ncdd

echo "sync web2"
rsync --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" --exclude "vendor" -rlz /home/ec2-user/staging/ncdd/ ec2-user@web2:/var/www/ncdd

echo "sync web3"
rsync --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" --exclude "vendor" -rlz /home/ec2-user/staging/ncdd/ ec2-user@web3:/var/www/ncdd

echo "discard minified and ssl files for a clean git repo.."
git clean -f
git checkout src/views/_elements/admin/js/
git checkout src/views/_elements/public/js/
#git checkout src/views/_elements/css/
