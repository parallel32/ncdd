#!/bin/bash
FILES=./www/ncdd.com/public_html/assets/stylesheets/*.css
for fullfile in $FILES
do
  echo "Processing $fullfile file..."
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
  #echo "filename: $filename extension: $extension"
java -jar /usr/share/yui-compressor/yuicompressor-2.4.8.jar $fullfile --type css -o "./www/ncdd.com/public_html/assets/stylesheets/$filename.min.css"
#mv "./www/ncdd.com/public_html/assets/stylesheets/$filename.min.php" "./www/ncdd.com/public_html/assets/stylesheets/$filename.php"
done