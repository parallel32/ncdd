#!/bin/bash
FILES=./src/views/_elements/css/*
for fullfile in $FILES
do
  echo "Processing $fullfile file..."
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
  #echo "filename: $filename extension: $extension"
java -jar /usr/share/yui-compressor/yui-compressor.jar $fullfile --type css -o "./src/views/_elements/css/$filename.min.php"
mv "./src/views/_elements/css/$filename.min.php" "./src/views/_elements/css/$filename.php"
done
