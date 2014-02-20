#!/bin/bash
FILES=./src/views/_elements/admin/js/*
for fullfile in $FILES
do
  echo "Processing $fullfile file..."
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
#echo "filename: $filename extension: $extension"
#assumes jsmin is in the home directory of ec2-user on admin-master and mike-remote on dev
~/jsmin/jsmin < $fullfile > "./src/views/_elements/admin/js/$filename.min.php"
#mv "./src/views/_elements/admin/js/$filename.min.php" "./src/views/_elements/admin/js/$filename.php"
done

FILES=./src/views/_elements/public/js/*
for fullfile in $FILES
do
  echo "Processing $fullfile file..."
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
#echo "filename: $filename extension: $extension"
#assumes jsmin is in the home directory of ec2-user on admin-master and mike-remote on dev
~/jsmin/jsmin < $fullfile > "./src/views/_elements/public/js/$filename.min.php"
#mv "./src/views/_elements/public/js/$filename.min.php" "./src/views/_elements/public/js/$filename.php"
done
