#!/bin/bash

### temp commented out ###
#echo "making ssl files......"
#/home/ec2-user/staging/config/ssl_maker.sh

#echo "minifying......"
#/home/ec2-user/staging/config/minify_css.sh
#/home/ec2-user/staging/config/minify_js.sh
### temp commented out ###


#echo "sync web-b"
#rsync --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" -rlz /home/ec2-user/staging/ ec2-user@10.211.149.123:/var/www/saw

echo "sync web-c"
rsync --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" -rlz /home/ec2-user/staging/ ec2-user@10.211.149.123:/var/www/saw

#echo "sync web-d"
#rsync --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" -rlz /home/ec2-user/staging/ ec2-user@10.211.149.123:/var/www/saw

### temp commented out ###
#echo "discard minified and ssl files for a clean git repo.."
#git clean -f
#git checkout src/views/_elements/js/
#git checkout src/views/_elements/css/
### temp commented out ###
