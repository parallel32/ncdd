#!/bin/bash
echo "Processing CSS files..."
FILEPATH=./src/views/_elements/css/
FILES=./src/views/_elements/css/*
for fullfile in $FILES
do
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
cp $FILEPATH$filename".php" $FILEPATH$filename"_ssl.php"
done

echo "Processing replacements..."
FILES=./src/views/_elements/css/*_ssl*
for fullfile in $FILES
do
  sed -i 's/SAW_CDN/SAW_SSL_CDN/g' $fullfile
done

echo "Processing JS files..."
FILEPATH=./src/views/_elements/js/
FILES=./src/views/_elements/js/*
for fullfile in $FILES
do
        filename=$(basename "$fullfile")
        extension=${filename##*.}
        filename=${filename%.*}
cp $FILEPATH$filename".php" $FILEPATH$filename"_ssl.php"
done

echo "Processing replacements..."
FILES=./src/views/_elements/js/*_ssl*
for fullfile in $FILES
do
  sed -i 's/SAW_CDN/SAW_SSL_CDN/g' $fullfile
done