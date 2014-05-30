mount -t vboxsf -o rw,uid=48,gid=48 ncdd /var/www/ncdd
service httpd start

mongod --replSet ncdd --port 27242 --dbpath /var/mongo_data/ncdd_replica_set0 --logpath /var/mongo_logs/mongod_27242.log --rest --smallfiles &
mongod --replSet ncdd --port 27243 --dbpath /var/mongo_data/ncdd_replica_set1 --logpath /var/mongo_logs/mongod_27243.log --rest --smallfiles &
mongod --replSet ncdd --port 27244 --dbpath /var/mongo_data/ncdd_replica_set2 --logpath /var/mongo_logs/mongod_27244.log --rest --smallfiles &