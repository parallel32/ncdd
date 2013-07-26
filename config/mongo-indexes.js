// INDEXES
db.location.ensureIndex({'point':'2d'});
db.page.ensureIndex({slug:1});
db.page.ensureIndex({currentType:1});
db.page.ensureIndex({section:1});
db.page.ensureIndex({currentStatus:1});

///////////
// examples:
///////////
db.offer.ensureIndex({category:1});
db.offer.ensureIndex({'location.neighborhood':1},{sparse:true});  // sparse means that only documents which contain the neighborhood item will be included in the index
db.user.ensureIndex({email:1,password:1});
db.user.ensureIndex({accessLevel:1});
db.session.ensureIndex({expiry:1});

// create a compound index for both of the locationTypes .. this is used by invoices to collect total grapes and total redemptions for the current month
db.grape.ensureIndex({'offerLite.ownerId': 1, 'offerLite.locationType':1, 'offerLite:premiumLevel':1, created: 1});
db.grape.ensureIndex({'offerLite.ownerId': 1, 'offerLite.locationType':1, 'offerLite:premiumLevel':1, redemptionDate: 1});

// create index on invoice number
db.invoice.ensureIndex({number:1});
db.invoice.ensureIndex({customerId:1});
db.invoice.ensureIndex({customerId:1,startDate:1,endDate:1});

// for expiring grapes
db.grape.ensureIndex({'offerLite.offerId':1});

//geospatial index *required* otherwise distance and range queries won't work
db.offer.ensureIndex({'location.point':'2d'});
db.user.ensureIndex({'location.point':'2d'});
db.grape.ensureIndex({'offerLite.location.point':'2d'});
db.timezone.ensureIndex({'point':'2d'});
db.user.ensureIndex({'lastSeenAt':'2d'}); // in case we use it