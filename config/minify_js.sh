#!/bin/bash
FILES=./src/views/_elements/js/*
for fullfile in $FILES
do
  echo "Processing $fullfile file..."
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
#echo "filename: $filename extension: $extension"
#assumes jsmin is in the home directory of ec2-user on admin-master and mike-remote on dev
~/jsmin/jsmin < $fullfile > "./src/views/_elements/js/$filename.min.php"
mv "./src/views/_elements/js/$filename.min.php" "./src/views/_elements/js/$filename.php"
done
