#/bin/sh
sudo /usr/bin/mongodump --host localhost --port 27242  --out ./db-dump
echo "##..begin tar -czf"
sudo tar -czf ./db-dump.tgz ./db-dump
echo "move tgz file to date stamp file"
sudo /bin/mv ./db-dump.tgz ./db-dump-$(date +'%b-%d-%Y-%T').tgz
echo "##.. remove db-dump folder"
sudo rm -rf ./db-dump
echo "##..finished"

## drop the database from the shell:  		#> mongo localhost:27242/ncdd --eval "db.dropDatabase();"
## restore the database from the shell:  	#> mongorestore --port 27242 ./db-dump/ncdd

## the statement to update the dashboard data
## mongo localhost:27242/ncdd --eval 'db.listing.copyTo("listingreport");db.listingreport.remove({"publishedDate.fullMonth":{$exists:false}});'

## dump the bson to change the image urls:
## bsondump listingdetail.bson > listingdetail.json

## import the json file (after the bson dump)
## mongo localhost:27242/ncdd --eval "db.listingdetail.drop();"
## mongoimport --port 27242 --db ncdd --collection listingdetail --file listingdetail.json