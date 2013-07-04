#!/bin/bash
echo "sync clone-dev"
rsync --verbose --progress --delete --exclude "logs" --exclude ".gitignore" --exclude ".git" -rlz /home/ec2-user/staging/ ec2-user@10.28.6.249:/var/www/sawstud.io
