// update the emails to all parallel32@gmail.com
db.member.update({},{$set:{email:'parallel32+100@gmail.com'}},{multi:true});
db.application.update({},{$set:{email:'parallel32+100@gmail.com'}},{multi:true});

// link up a seminar registration to a payment
db.registration.update({_id:ObjectId('565cf2b31f1d752b0ed3e88d')},{$set:{currentStatus:40,currentPaymentType:40,paymentId:ObjectId('565cf2b31f1d752b0ed3e88c'),paidDate:{"date" : ISODate("2015-12-01T01:06:59Z"),"checkError" : "2015-11-30","feed" : "11/30/2015","detail" : "11/30/2015","monthDay" : "November 30","iso" : "2015-11-30T20:06:59-05:00","fullDateTime" : "November 30, 2015 08:06 PM","fullMonth" : "November 30, 2015","shortMonth" : "Nov 30, 2015","dayOfWeek" : "Monday","shortDayOfWeek" : "Mon","year" : "2015","european" : "30/11/2015","europeanFullMonth" : "30 November, 2015","europeanShortMonth" : "30 Nov, 2015","shortTimeSlim" : "8:06pm","shortTime" : "8:06 pm","longTime" : "08:06 PM","militaryTime" : "20:06","timezone" : "America/New_York","month" : "November","leadingZeros" : "11-30-15","paymentGateway" : "20151130"}}});

// kevin o'grady
db.registration.update({_id:ObjectId('571ea1c71f1d75c91c9d8e9f')},{$set:{currentStatus:40,currentPaymentType:40,paymentId:ObjectId('571ea1c71f1d75c91c9d8e9e'),paidDate:{"date" : ISODate("2016-04-25T23:01:27Z"),"checkError" : "2016-04-25","feed" : "4/25/2016","detail" : "4/25/2016","monthDay" : "April 25","iso" : "2016-04-25T19:01:27-04:00","fullDateTime" : "April 25, 2016 07:01 PM","fullMonth" : "April 25, 2016","shortMonth" : "Apr 25, 2016","dayOfWeek" : "Monday","shortDayOfWeek" : "Mon","year" : "2016","european" : "25/4/2016","europeanFullMonth" : "25 April, 2016","europeanShortMonth" : "25 Apr, 2016","shortTimeSlim" : "7:01pm","shortTime" : "7:01 pm","longTime" : "07:01 PM","militaryTime" : "19:01","timezone" : "America/New_York","month" : "April","leadingZeros" : "04-25-16","paymentGateway" : "20160425"}}});
// ernest stone
db.registration.update({_id:ObjectId('571e75b454fe0b6a234b9602')},{$set:{currentStatus:20,currentPaymentType:40,paymentId:{},paidDate:{},depositPaymentId:ObjectId('571e75b454fe0b6a234b9601'),depositPaidDate:{"date" : ISODate("2016-04-25T19:53:24Z"),"checkError" : "2016-04-25","feed" : "4/25/2016","detail" : "4/25/2016","monthDay" : "April 25","iso" : "2016-04-25T15:53:24-04:00","fullDateTime" : "April 25, 2016 03:53 PM","fullMonth" : "April 25, 2016","shortMonth" : "Apr 25, 2016","dayOfWeek" : "Monday","shortDayOfWeek" : "Mon","year" : "2016","european" : "25/4/2016","europeanFullMonth" : "25 April, 2016","europeanShortMonth" : "25 Apr, 2016","shortTimeSlim" : "3:53pm","shortTime" : "3:53 pm","longTime" : "03:53 PM","militaryTime" : "15:53","timezone" : "America/New_York","month" : "April","leadingZeros" : "04-25-16","paymentGateway" : "20160425"}}});
// justin spizman
db.registration.update({_id:ObjectId('57194577a6ec61b81b592298')},{$set:{currentStatus:20,currentPaymentType:40,paymentId:{},paidDate:{},depositPaymentId:ObjectId('57194577a6ec61b81b592297'),depositPaidDate:{"date" : ISODate("2016-04-21T21:26:15Z"),"checkError" : "2016-04-21","feed" : "4/21/2016","detail" : "4/21/2016","monthDay" : "April 21","iso" : "2016-04-21T17:26:15-04:00","fullDateTime" : "April 21, 2016 05:26 PM","fullMonth" : "April 21, 2016","shortMonth" : "Apr 21, 2016","dayOfWeek" : "Thursday","shortDayOfWeek" : "Thu","year" : "2016","european" : "21/4/2016","europeanFullMonth" : "21 April, 2016","europeanShortMonth" : "21 Apr, 2016","shortTimeSlim" : "5:26pm","shortTime" : "5:26 pm","longTime" : "05:26 PM","militaryTime" : "17:26","timezone" : "America/New_York","month" : "April","leadingZeros" : "04-21-16","paymentGateway" : "20160421"}}});
//link memberId to their seminar registration
db.registration.update({_id:ObjectId('571ea1c71f1d75c91c9d8e9f')},{$set:{memberId:ObjectId('5208d68a9afe0b53323e9858')}});
db.registration.update({_id:ObjectId('57194577a6ec61b81b592298')},{$set:{memberId:ObjectId('5208d61b9afe0b53323e90aa')}});
db.registration.update({_id:ObjectId('571e75b454fe0b6a234b9602')},{$set:{memberId:ObjectId('5716781a1f1d759d5949b447')}});





{
	"_id" : ObjectId("57103911a6ec61b563342065"),
	"address1" : "303 East Broadway",
	"address2" : "",
	"attendanceCertificationStatement" : "Jessica Sisk, on this 14th day of April, 2016",
	"barNumber" : 29905,
	"cardOnFile" : {

	},
	"city" : "Newport",
	"class" : "RegistrationSeminar",
	"clearFields" : "",
	"collection" : "registration",
	"contributionPaymentId" : {

	},
	"country" : "United States",
	"currentPaymentType" : 40,
	"currentStatus" : 20,
	"deposit" : 500,
	"depositDueDate" : "July 1",
	"depositPaidDate" : {
		"date" : ISODate("2016-04-15T00:42:57Z"),
		"checkError" : "2016-04-14",
		"feed" : "4/14/2016",
		"detail" : "4/14/2016",
		"monthDay" : "April 14",
		"iso" : "2016-04-14T20:42:57-04:00",
		"fullDateTime" : "April 14, 2016 08:42 PM",
		"fullMonth" : "April 14, 2016",
		"shortMonth" : "Apr 14, 2016",
		"dayOfWeek" : "Thursday",
		"shortDayOfWeek" : "Thu",
		"year" : "2016",
		"european" : "14/4/2016",
		"europeanFullMonth" : "14 April, 2016",
		"europeanShortMonth" : "14 Apr, 2016",
		"shortTimeSlim" : "8:42pm",
		"shortTime" : "8:42 pm",
		"longTime" : "08:42 PM",
		"militaryTime" : "20:42",
		"timezone" : "America/New_York",
		"month" : "April",
		"leadingZeros" : "04-14-16",
		"paymentGateway" : "20160414"
	},
	"depositPaymentId" : ObejctId("57103911a6ec61b563342064"),
	"depositQuestion" : "yes",
	"elective1" : "Picking the Winning Jury",
	"elective2" : "Suppression Motions: Winning it All Before Trial",
	"email" : "jsisklaw@gmail.com",
	"fax" : "(423) 623-3139",
	"hardCopy" : "NO",
	"hardCopyFee" : 50,
	"memberId" : {

	},
	"name" : "Jessica Sisk",
	"nameTag" : "Jessica Sisk",
	"paidDate" : {
		
	},
	"paymentId" : {},
	"phone" : "(423) 623-3137",
	"postalCode" : 37821,
	"previouslyAttended" : "",
	"previouslyAttendedExists" : "no",
	"registrationFee" : 1500,
	"registrationFeeOriginal" : 1500,
	"registrationNumber" : "no",
	"rsvp" : 1,
	"rsvpkids" : "",
	"scholarshipId" : {

	},
	"seminarId" : ObjectId("5677050254fe0b9324742c16"),
	"state" : "Tennessee",
	"submittedDate" : {
		"date" : ISODate("2016-04-15T00:42:57Z"),
		"checkError" : "2016-04-14",
		"feed" : "4/14/2016",
		"detail" : "4/14/2016",
		"monthDay" : "April 14",
		"iso" : "2016-04-14T20:42:57-04:00",
		"fullDateTime" : "April 14, 2016 08:42 PM",
		"fullMonth" : "April 14, 2016",
		"shortMonth" : "Apr 14, 2016",
		"dayOfWeek" : "Thursday",
		"shortDayOfWeek" : "Thu",
		"year" : "2016",
		"european" : "14/4/2016",
		"europeanFullMonth" : "14 April, 2016",
		"europeanShortMonth" : "14 Apr, 2016",
		"shortTimeSlim" : "8:42pm",
		"shortTime" : "8:42 pm",
		"longTime" : "08:42 PM",
		"militaryTime" : "20:42",
		"timezone" : "America/New_York",
		"month" : "April",
		"leadingZeros" : "04-14-16",
		"paymentGateway" : "20160414"
	},
	"tempPayment" : {

	},
	"total" : 500,
	"type" : "NEW SEMINAR REGISTRATION",
	"userAgent" : "Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko"
}




// invoice block updates
db.payment.update({_id:ObjectId('560d452a54fe0bd865742c1c')},{$set:{invoiceBlock:'<div class="row-fluid invoice">               <div class="row-fluid invoice-logo">                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>                  <div class="span6">                     <p>#560d452854fe0bd865742c18 / 01 Oct, 2015 <span class="muted">Application ID and Date</span></p>                  </div>               </div>               <hr />               <div class="row-fluid">                  <div class="span3">                     <h4>Member:</h4>                     <ul class="unstyled">                                                <li>Leon A Geller</li>                        <li>200 A Monroe Suite100 Rockville, MD 20850, US</li>                        <li>email: Lglaw87@yahoo.com</li>                        <li>phone: (301) 309-8001</li>                        <li>fax: (301) 309-8003 </li>                     </ul>                  </div>                  <div class="span4">                     <h4>About:</h4>                     <ul class="unstyled">                        <li>NEW MEMBER APPLICATION</li>                        <li>Executed at Las Vegas,nv, this 01st day of October, 2015</li>                     </ul>                  </div>                  <div class="span4 invoice-payment">                     <h4></h4>                     <ul class="unstyled">                                             </ul>                  </div>               </div>               <div class="row-fluid">                  <table class="table table-striped table-hover">                     <thead>                        <tr>                           <th>Item</th>                           <th class="hidden-480">Description</th>                           <th class="hidden-480">Quantity</th>                           <th class="hidden-480">Unit Cost</th>                           <th>Total</th>                        </tr>                     </thead>                     <tbody>                                                <tr>                           <td>Application</td>                           <td class="hidden-480">NEW MEMBER APPLICATION for 2016</td>                           <td class="hidden-480">1</td>                           <td class="hidden-480">$225</td>                           <td>$225</td>                        </tr>                                                                                                                                                             <tr>                           <td>Discount</td>                           <td class="hidden-480">EAGLE2016 Promo Discount - 2015 membership free</td>                           <td class="hidden-480">1</td>                           <td class="hidden-480">$0</td>                           <td>$0</td>                        </tr>                                                                     </tbody>                  </table>               </div>               <div class="row-fluid">                  <div class="span12 invoice-block">                     <ul class="unstyled amounts">                        <li><strong>Total:</strong> $225</li>                     </ul>                  </div>               </div>                           </div>'}});
db.payment.update({_id:ObjectId('560d63f554fe0b757c742c1c')},{$set:{invoiceBlock:'	<div class="row-fluid invoice">               <div class="row-fluid invoice-logo">                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>                  <div class="span6">                     <p>#560d7d771f1d7523092c46f3 / 01 Oct, 2015 <span class="muted">Application ID and Date</span></p>                  </div>               </div>               <hr />               <div class="row-fluid">                  <div class="span3">                     <h4>Member:</h4>                     <ul class="unstyled">                                                <li>Matthew Jay Ruff</li>                        <li>18411 Crenshaw Blvd, Suite 417 Torrance, CA 90504, US</li>                        <li>email: Matthew.ruff@sbcglobal.net</li>                        <li>phone: (310) 527-4100</li>                        <li>fax: (877) 221-1688</li>                     </ul>                  </div>                  <div class="span4">                     <h4>About:</h4>                     <ul class="unstyled">                        <li>NEW MEMBER APPLICATION</li>                        <li>Executed at Las Vegas, this 01st day of October, 2015</li>                     </ul>                  </div>                  <div class="span4 invoice-payment">                     <h4></h4>                     <ul class="unstyled">                                             </ul>                  </div>               </div>               <div class="row-fluid">                  <table class="table table-striped table-hover">                     <thead>                        <tr>                           <th>Item</th>                           <th class="hidden-480">Description</th>                           <th class="hidden-480">Quantity</th>                           <th class="hidden-480">Unit Cost</th>                           <th>Total</th>                        </tr>                     </thead>                     <tbody>                                                <tr>                           <td>Application</td>                           <td class="hidden-480">NEW MEMBER APPLICATION for 2016</td>                           <td class="hidden-480">1</td>                           <td class="hidden-480">$225</td>                           <td>$225</td>                        </tr>                                                                                                                                                             <tr>                           <td>Discount</td>                           <td class="hidden-480">EAGLE2016 Promo Discount - 2015 membership free</td>                           <td class="hidden-480">1</td>                           <td class="hidden-480">$0</td>                           <td>$0</td>                        </tr>                                                                     </tbody>                  </table>               </div>               <div class="row-fluid">                  <div class="span12 invoice-block">                     <ul class="unstyled amounts">                        <li><strong>Total:</strong> $225</li>                     </ul>                  </div>               </div>                           </div>'}});


db.payment.find({email:'rosemary@nocuffs.com'},{title:1,paidDate:1}).pretty();

db.registration.update({_id:ObjectId('56743ea71f1d75392a9c6671')},{$set:{currentStatus:40,paymentId:ObjectId('56743ea71f1d75392a9c6670'),paidDate:{"date" : ISODate("2015-12-18T17:13:11Z"),"checkError" : "2015-12-18","feed" : "12/18/2015","detail" : "12/18/2015","monthDay" : "December 18","iso" : "2015-12-18T12:13:11-05:00","fullDateTime" : "December 18, 2015 12:13 PM","fullMonth" : "December 18, 2015","shortMonth" : "Dec 18, 2015","dayOfWeek" : "Friday","shortDayOfWeek" : "Fri","year" : "2015","european" : "18/12/2015","europeanFullMonth" : "18 December, 2015","europeanShortMonth" : "18 Dec, 2015","shortTimeSlim" : "12:13pm","shortTime" : "12:13 pm","longTime" : "12:13 PM","militaryTime" : "12:13","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-18-15","paymentGateway" : "20151218"}}});
db.registration.update({_id:ObjectId('5669ac51a6ec61ba70f351aa')},{$set:{currentStatus:40,paymentId:ObjectId('5669ac51a6ec61ba70f351a9'),paidDate:{"date" : ISODate("2015-12-10T16:46:09Z"),"checkError" : "2015-12-10","feed" : "12/10/2015","detail" : "12/10/2015","monthDay" : "December 10","iso" : "2015-12-10T11:46:09-05:00","fullDateTime" : "December 10, 2015 11:46 AM","fullMonth" : "December 10, 2015","shortMonth" : "Dec 10, 2015","dayOfWeek" : "Thursday","shortDayOfWeek" : "Thu","year" : "2015","european" : "10/12/2015","europeanFullMonth" : "10 December, 2015","europeanShortMonth" : "10 Dec, 2015","shortTimeSlim" : "11:46am","shortTime" : "11:46 am","longTime" : "11:46 AM","militaryTime" : "11:46","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-10-15","paymentGateway" : "20151210"}}});
db.registration.update({_id:ObjectId('5668c017a6ec611874f351aa')},{$set:{currentStatus:40,paymentId:ObjectId('5668c017a6ec611874f351a9'),paidDate:{"date" : ISODate("2015-12-09T23:58:15Z"),"checkError" : "2015-12-09","feed" : "12/9/2015","detail" : "12/9/2015","monthDay" : "December 9","iso" : "2015-12-09T18:58:15-05:00","fullDateTime" : "December 9, 2015 06:58 PM","fullMonth" : "December 9, 2015","shortMonth" : "Dec 9, 2015","dayOfWeek" : "Wednesday","shortDayOfWeek" : "Wed","year" : "2015","european" : "9/12/2015","europeanFullMonth" : "9 December, 2015","europeanShortMonth" : "9 Dec, 2015","shortTimeSlim" : "6:58pm","shortTime" : "6:58 pm","longTime" : "06:58 PM","militaryTime" : "18:58","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-09-15","paymentGateway" : "20151209"}}});
db.registration.update({_id:ObjectId('5668a0cf54fe0b3758742c1b')},{$set:{currentStatus:40,paymentId:ObjectId('5668a0cf54fe0b3758742c1a'),paidDate:{"date" : ISODate("2015-12-09T21:44:47Z"),"checkError" : "2015-12-09","feed" : "12/9/2015","detail" : "12/9/2015","monthDay" : "December 9","iso" : "2015-12-09T16:44:47-05:00","fullDateTime" : "December 9, 2015 04:44 PM","fullMonth" : "December 9, 2015","shortMonth" : "Dec 9, 2015","dayOfWeek" : "Wednesday","shortDayOfWeek" : "Wed","year" : "2015","european" : "9/12/2015","europeanFullMonth" : "9 December, 2015","europeanShortMonth" : "9 Dec, 2015","shortTimeSlim" : "4:44pm","shortTime" : "4:44 pm","longTime" : "04:44 PM","militaryTime" : "16:44","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-09-15","paymentGateway" : "20151209"}}});
db.registration.update({_id:ObjectId('5666e4841f1d75a71bdb4c14')},{$set:{currentStatus:40,paymentId:ObjectId('5666e4841f1d75a71bdb4c13'),paidDate:{"date" : ISODate("2015-12-08T14:09:08Z"),"checkError" : "2015-12-08","feed" : "12/8/2015","detail" : "12/8/2015","monthDay" : "December 8","iso" : "2015-12-08T09:09:08-05:00","fullDateTime" : "December 8, 2015 09:09 AM","fullMonth" : "December 8, 2015","shortMonth" : "Dec 8, 2015","dayOfWeek" : "Tuesday","shortDayOfWeek" : "Tue","year" : "2015","european" : "8/12/2015","europeanFullMonth" : "8 December, 2015","europeanShortMonth" : "8 Dec, 2015","shortTimeSlim" : "9:09am","shortTime" : "9:09 am","longTime" : "09:09 AM","militaryTime" : "09:09","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-08-15","paymentGateway" : "20151208"}}});
db.registration.update({_id:ObjectId('5665bf5d54fe0bc310742c1a')},{$set:{currentStatus:40,paymentId:ObjectId('5665bf5d54fe0bc310742c19'),paidDate:{"date" : ISODate("2015-12-07T17:18:21Z"),"checkError" : "2015-12-07","feed" : "12/7/2015","detail" : "12/7/2015","monthDay" : "December 7","iso" : "2015-12-07T12:18:21-05:00","fullDateTime" : "December 7, 2015 12:18 PM","fullMonth" : "December 7, 2015","shortMonth" : "Dec 7, 2015","dayOfWeek" : "Monday","shortDayOfWeek" : "Mon","year" : "2015","european" : "7/12/2015","europeanFullMonth" : "7 December, 2015","europeanShortMonth" : "7 Dec, 2015","shortTimeSlim" : "12:18pm","shortTime" : "12:18 pm","longTime" : "12:18 PM","militaryTime" : "12:18","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-07-15","paymentGateway" : "20151207"}}});
db.registration.update({_id:ObjectId('566256541f1d75ae7cd3e88d')},{$set:{currentStatus:40,paymentId:ObjectId('566256541f1d75ae7cd3e88c'),paidDate:{"date" : ISODate("2015-12-05T03:13:24Z"),"checkError" : "2015-12-04","feed" : "12/4/2015","detail" : "12/4/2015","monthDay" : "December 4","iso" : "2015-12-04T22:13:24-05:00","fullDateTime" : "December 4, 2015 10:13 PM","fullMonth" : "December 4, 2015","shortMonth" : "Dec 4, 2015","dayOfWeek" : "Friday","shortDayOfWeek" : "Fri","year" : "2015","european" : "4/12/2015","europeanFullMonth" : "4 December, 2015","europeanShortMonth" : "4 Dec, 2015","shortTimeSlim" : "10:13pm","shortTime" : "10:13 pm","longTime" : "10:13 PM","militaryTime" : "22:13","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-04-15","paymentGateway" : "20151204"}}});
db.registration.update({_id:ObjectId('5660c5271f1d75e71dd3e88d')},{$set:{currentStatus:40,paymentId:ObjectId('5660c5271f1d75e71dd3e88c'),paidDate:{"date" : ISODate("2015-12-03T22:41:43Z"),"checkError" : "2015-12-03","feed" : "12/3/2015","detail" : "12/3/2015","monthDay" : "December 3","iso" : "2015-12-03T17:41:43-05:00","fullDateTime" : "December 3, 2015 05:41 PM","fullMonth" : "December 3, 2015","shortMonth" : "Dec 3, 2015","dayOfWeek" : "Thursday","shortDayOfWeek" : "Thu","year" : "2015","european" : "3/12/2015","europeanFullMonth" : "3 December, 2015","europeanShortMonth" : "3 Dec, 2015","shortTimeSlim" : "5:41pm","shortTime" : "5:41 pm","longTime" : "05:41 PM","militaryTime" : "17:41","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-03-15","paymentGateway" : "20151203"}}});
db.registration.update({_id:ObjectId('5660b9f2a6ec61d748eaa08a')},{$set:{currentStatus:40,paymentId:ObjectId('5660b9f2a6ec61d748eaa089'),paidDate:{"date" : ISODate("2015-12-03T21:53:54Z"),"checkError" : "2015-12-03","feed" : "12/3/2015","detail" : "12/3/2015","monthDay" : "December 3","iso" : "2015-12-03T16:53:54-05:00","fullDateTime" : "December 3, 2015 04:53 PM","fullMonth" : "December 3, 2015","shortMonth" : "Dec 3, 2015","dayOfWeek" : "Thursday","shortDayOfWeek" : "Thu","year" : "2015","european" : "3/12/2015","europeanFullMonth" : "3 December, 2015","europeanShortMonth" : "3 Dec, 2015","shortTimeSlim" : "4:53pm","shortTime" : "4:53 pm","longTime" : "04:53 PM","militaryTime" : "16:53","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-03-15","paymentGateway" : "20151203"}}});
db.registration.update({_id:ObjectId('564240f0a6ec61531195d1e7')},{$set:{currentStatus:40,paymentId:ObjectId('564240f0a6ec61531195d1e6'),paidDate:{"date" : ISODate("2015-11-10T19:09:36Z"),"checkError" : "2015-11-10","feed" : "11/10/2015","detail" : "11/10/2015","monthDay" : "November 10","iso" : "2015-11-10T14:09:36-05:00","fullDateTime" : "November 10, 2015 02:09 PM","fullMonth" : "November 10, 2015","shortMonth" : "Nov 10, 2015","dayOfWeek" : "Tuesday","shortDayOfWeek" : "Tue","year" : "2015","european" : "10/11/2015","europeanFullMonth" : "10 November, 2015","europeanShortMonth" : "10 Nov, 2015","shortTimeSlim" : "2:09pm","shortTime" : "2:09 pm","longTime" : "02:09 PM","militaryTime" : "14:09","timezone" : "America/New_York","month" : "November","leadingZeros" : "11-10-15","paymentGateway" : "20151110"}}});
db.registration.update({_id:ObjectId('56423fa6a6ec61d10f95d1e7')},{$set:{currentStatus:40,paymentId:ObjectId('56423fa6a6ec61d10f95d1e6'),paidDate:{"date" : ISODate("2015-11-10T19:04:06Z"),"checkError" : "2015-11-10","feed" : "11/10/2015","detail" : "11/10/2015","monthDay" : "November 10","iso" : "2015-11-10T14:04:06-05:00","fullDateTime" : "November 10, 2015 02:04 PM","fullMonth" : "November 10, 2015","shortMonth" : "Nov 10, 2015","dayOfWeek" : "Tuesday","shortDayOfWeek" : "Tue","year" : "2015","european" : "10/11/2015","europeanFullMonth" : "10 November, 2015","europeanShortMonth" : "10 Nov, 2015","shortTimeSlim" : "2:04pm","shortTime" : "2:04 pm","longTime" : "02:04 PM","militaryTime" : "14:04","timezone" : "America/New_York","month" : "November","leadingZeros" : "11-10-15","paymentGateway" : "20151110"}}});


db.registration.update({_id:ObjectId('5683edd954fe0b5e79742c16')},{$set:{currentStatus:40,paymentId:ObjectId('5683ee071f1d75ea33aa2f4d'),paidDate:{"date" : ISODate("2015-12-30T14:45:27Z"),"checkError" : "2015-12-30","feed" : "12/30/2015","detail" : "12/30/2015","monthDay" : "December 30","iso" : "2015-12-30T09:45:27-05:00","fullDateTime" : "December 30, 2015 09:45 AM","fullMonth" : "December 30, 2015","shortMonth" : "Dec 30, 2015","dayOfWeek" : "Wednesday","shortDayOfWeek" : "Wed","year" : "2015","european" : "30/12/2015","europeanFullMonth" : "30 December, 2015","europeanShortMonth" : "30 Dec, 2015","shortTimeSlim" : "9:45am","shortTime" : "9:45 am","longTime" : "09:45 AM","militaryTime" : "09:45","timezone" : "America/New_York","month" : "December","leadingZeros" : "12-30-15","paymentGateway" : "20151230"}}});




// UPDATE THE COUNTRY CODE FOR FIRST DATA!

// ncdd:PRIMARY> db.member.find({'payment.country':'usa'}).count()
// 61
// ncdd:PRIMARY> db.member.find({'payment.country':'USA'}).count()
// 782
// ncdd:PRIMARY> db.member.find({'payment.country':'United States'}).count()
// 389


db.member.update({'payment.country':'usa'},{$set:{'payment.country':'US'}},{multi:true})
db.member.update({'payment.country':'USA'},{$set:{'payment.country':'US'}},{multi:true})
db.member.update({'payment.country':'United States'},{$set:{'payment.country':'US'}},{multi:true})
db.member.update({'payment.country':'us'},{$set:{'payment.country':'US'}},{multi:true})


db.member.find({'payment.country':'usa'}).count()
db.member.find({'payment.country':'USA'}).count()
db.member.find({'payment.country':'United States'}).count()
db.member.find({'payment.country':'U.S.A'}).count()
db.member.find({'payment.country':'u.s.a'}).count()
db.member.find({'payment.country':'us'}).count()
db.member.find({'payment.country':'US'}).count()


db.autorenew.remove({ "_id" : ObjectId("56ba4fc4a6ec610b2da6d537") });
db.autorenew.remove({ "_id" : ObjectId("56ba4fbea6ec610b2da6d4e2") });
db.autorenew.remove({ "_id" : ObjectId("56ba4fbea6ec610b2da6d4e0") });
db.autorenew.remove({ "_id" : ObjectId("56ba4fbfa6ec610b2da6d4e7") });


db.emailsent.update({_id:ObjectId('56d5e5628a16328912000001')},{$set:{"sentDate.fullMonth" : "Feb 23, 2016"}})
