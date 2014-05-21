#/bin/sh
sudo /usr/bin/mongodump --host localhost --port 27242  --out ./db-dump
echo "##..begin tar -czf"
sudo tar -czf ./db-dump.tgz ./db-dump
echo "move tgz file to date stamp file"
sudo /bin/mv ./db-dump.tgz ./db-dump-$(date +'%b-%d-%Y-%T').tgz
echo "##.. remove db-dump folder"
sudo rm -rf ./db-dump
echo "##..finished"