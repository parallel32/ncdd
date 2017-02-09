db.autorenew.remove();

/renewalsautoseed
/renewalsautoseedsanitycheckagainstpayments



db.autorenew.find({'record.name':{$in:[/kortes/i,/yates/i,/bours/i,/david reyes/i,/condon/i,/chuck strain/i,/hays webb/i,/martin b schwartz/i,/shahin zamir/i,/lisa b santos/i,/d. cotton/i,/ducharme/i,/trevena/i,/moriarty/i,/d thompson/i,/hoelscher/i,/l. byrd/i,/m. oliver/i,/jaeger/i,/h. bradley/i,/simpkins/i,/a. forrest/i,/l vesey/i,/j. silva/i,/denslow/i,,/langston/i,/d reyes/i,/belanger/i,/k henry/i,/r. sharma/i,/s. gribow/i,/goldson/i,/stotz/i,/c. davis/i,/horsley/i,/salazar/i,/novak/i,/cho/i,/hickman/i,/lana/i,/william d. day/i,/k glaser/i,/r hoover/i,/de la paz/i,/hendricks/i,/kennard/i,/l grant/i,/koller/i,/benavides/i,/bradley loper/i,/gavrin/i,/buckalew/i,/simpson/i,/william francis/i,/thacker/i,/rowland/i,/d. rossen/i,/k gross/i,/m mehler/i,/arvin ross/i,/marc rudolph/i,/s dawson/i,/perez/i,/zelman/i,/barth/i,/dittmer/i,/hinely/i,/castro/i,/springer/i,/jaber/i,/marburger/i,/drummond/i,/maloumian/i,/j wood/i,/miller leonard/i,/f brown/i,/d. karpel/i,/hilscher/i,/f. black/i,/edmiston/i,/m. morgan/i,/fleming/i,/jake johnson/i,/adam chaudry/i,/d fox/i,/macht/i,/dennis morgan/i,/s foster/i,/lucero/i,/glenn/i,/speer/i,/koenig/i,/wayne bush/i,/s peters/i,/blass/i,/patriarca/i,/h thomas/i,/c strong/i,/schmidt/i,/murillo/i,/b green/i,/t. jones/i,/denardo/i,/wehunt/i,/quinlan/i,/going/i,/m anderson/i]}},{'record.name':1});

db.autorenew.remove({'record.name':{$in:[/kortes/i,/yates/i,/bours/i,/david reyes/i,/condon/i,/chuck strain/i,/hays webb/i,/martin b schwartz/i,/shahin zamir/i,/lisa b santos/i,/d. cotton/i,/ducharme/i,/trevena/i,/moriarty/i,/d thompson/i,/hoelscher/i,/l. byrd/i,/m. oliver/i,/jaeger/i,/h. bradley/i,/simpkins/i,/a. forrest/i,/l vesey/i,/j. silva/i,/denslow/i,,/langston/i,/d reyes/i,/belanger/i,/k henry/i,/r. sharma/i,/s. gribow/i,/goldson/i,/stotz/i,/c. davis/i,/horsley/i,/salazar/i,/novak/i,/cho/i,/hickman/i,/lana/i,/william d. day/i,/k glaser/i,/r hoover/i,/de la paz/i,/hendricks/i,/kennard/i,/l grant/i,/koller/i,/benavides/i,/bradley loper/i,/gavrin/i,/buckalew/i,/simpson/i,/william francis/i,/thacker/i,/rowland/i,/d. rossen/i,/k gross/i,/m mehler/i,/arvin ross/i,/marc rudolph/i,/s dawson/i,/perez/i,/zelman/i,/barth/i,/dittmer/i,/hinely/i,/castro/i,/springer/i,/jaber/i,/marburger/i,/drummond/i,/maloumian/i,/j wood/i,/miller leonard/i,/f brown/i,/d. karpel/i,/hilscher/i,/f. black/i,/edmiston/i,/m. morgan/i,/fleming/i,/jake johnson/i,/adam chaudry/i,/d fox/i,/macht/i,/dennis morgan/i,/s foster/i,/lucero/i,/glenn/i,/speer/i,/koenig/i,/wayne bush/i,/s peters/i,/blass/i,/patriarca/i,/h thomas/i,/c strong/i,/schmidt/i,/murillo/i,/b green/i,/t. jones/i,/denardo/i,/wehunt/i,/quinlan/i,/going/i,/m anderson/i]}});


db.autorenew.update({'record.payment.expYear':16},{$set:{'record.payment.expYear':2018}})
db.autorenew.update({'record.payment.expYear':16},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':17},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':2016},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':2014},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':2015},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':15},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':14},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':2017,'record.payment.expMonth':1},{$set:{'record.payment.expYear':2018}},{multi:1})
db.autorenew.update({'record.payment.expYear':2017,'record.payment.expMonth':2},{$set:{'record.payment.expYear':2018}},{multi:1})

db.autorenew.update({'record.expired':'yes'},{$set:{'record.expired':'no'}},{multi:1})
db.autorenew.update({'expired':'yes'},{$set:{'expired':'no'}},{multi:1})


/renewalsautocharge

/renewals-send-decline-followup-email

/renewal-send-declined-follow-up-email

/renewal-send-unsubmitted-followup-email

