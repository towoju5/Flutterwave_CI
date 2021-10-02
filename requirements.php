
Correction: 
These are the file and folder names you might need for the Flutterwave Payment Gateway integration: 
1. application/views/admin/paygateway/edit_gateway.php
2. application/views/admin/paygateway/display_gateway.php
3. application/views/site/product/confirmpayment.php
4. application/views/site/rentals/confirmpayment.php 
5. application/views/site/order/host_success.php
6 .application/models/checkout_model.php
7. application/controllers/site/checkout.php
8. public_html/ commonsettings/fc_payment_settings.php
9. application/controllers/site/experience_checkout.php
10. application/models/experience_checkout_model.php
11. application/views/site/experience/confirmpayment.php
12. application/views/site/experience/payment.php 
https://occupyproperties.com/site/user/confirmbooking/256
https://occupyproperties.com/order/success/133/541039116/tok_1Ii7F84TmWWF3erFDmwtooeg

Zaur, the site is called Occupyproperties.com at http://occupyproperties.com.
There are two areas on Occupyproprties website that use Payment Gateways for payment on the website namely 'Home Rentals' 
and 'Homes and Land For Sale'. Use the following following log in information and URLs to test the Gateway that you're creating: 
User: janet@vacason.com 
Password: roger1. 
URL for Home Rentals: https://occupyproperties.com/rental/249.
URL for Homes and Land For Sale: https://occupyproperties.com/view_experience/139. 
There is Stripe Payment Gateway on the site to do a sample test on the site too.


https://nesnft.vercel.app/

Develop a Flutterwave payment gateway integration for a PHP website. The payment gateway needs to be integrated with the website. Check documentation at https://developer.flutterwave.com/docs. The Flutterwave Payment Gateway integrated the Service Provider needs to be tested and working on the site by me before payment is released to the Talent (Service Provider).

Zaur: I've set up your ftp: User: zaur@occupyproperties.com Pass: zaur1616@. Log in to the site and download the Source Code titled Occupyproperties-project.zip. It's a zip file

FTP Host Name: occupyproperties.com
User: zaur@occupyproperties.com
Pass: zaur1616@


database Name: occupypr_prop 
User: occupypr_zaur 
Pass: zaur1616@ 

FTP Host Name: occupyproperties.com

9/29

judithdialu@gmail.com
Root1117!

Test information:
    Ganiyu   Adebayo  forbusiness1117@gmail.com  forbusiness1117@gmail.com   
    Zaur Aliyev 
    Ganiyu Adebayo     adekoolcomputers@yahoo.com  7702568162
    ✅http://occupyproperties.com/admin with User: zaur Pass: zaur2016

10/1
There are two areas on the site. The Home Rentals are for people who want to rent homes from our hosts while Homes and Land For Sale are for people who want to buy homes and land from our Providers. We will also need the Flutterwave Payment to transfer payments to the Hosts after successful bookings of their properties excluding our commissions.
But the payment transfers to hosts using Fluterwave, after successful booking integration, is a separate thing I will want to integrate after you have completed the Flutterwave Payment Gateway job, if you can do it after you complete this job.
The Home and Land For Sale part of the site uses 'Experience' folders on the site. I converted 'Experience' to Homes and Land For Sale.
I enabled the STRIPE Payment Gateway on the site to see where the Flutterwave Payment need to be.
Create a test for each of the two areas on the site and try make a payment for each one using the STRIPE. I will also send you some screenshots of each of the two areas using stripe.
✅Use this URL as a test property for HOMES AND LAND FOR SALE:
    https://occupyproperties.com/view_experience/139
✅Use this URL to test for the RENTAL PROPERTIES:
    https://occupyproperties.com/rental/249
✅✅USE STRIPE CARD TEST NUMBER : 4242424242424242 for each of those properties.
✅✅Use 123 as security code for the card and choose VISA Card on the payment page.
I just tested both URLS using STRIPE just now.

That what the Traveler and the Host will receive after booking. There are two major users on the site. HOST AND TRAVELER. You will see the two areas when you log in to your test account. The user can be a HOST (property owner) or Traveler. The traveler is the one that does the booking of the property.
You will also see two icons on the top right when you log in. They are messaging icons. 
✅One for Rental Properties and 
✅the other one for Homes and Land FOR SALE.
✅ image you posted is for Property Reservation for TRAVELER user.
If you are a HOST user, Your property Bookings can be found under MY RENTAL PROPERTIES link when you log in.

I've also enabled the second payment gateway. You will see it when making payment.
Check MySQL Database I sent you after integration. Go to Payment Gateway in MySQL database. You will see Flutterwave Gateway there. You will see the Public Key and Secret Key fields I created. You will need to create the Encryption Key field there.
fc_payment_gateway
ust follow the STRIPE PAYMENT GATEWAY to see.
For Fluttherwave, you will implement Card and Bank Transfer for payments
10/1
flutterwave request object
{
   "tx_ref":"hooli-tx-1920bbtytty",
   "amount":"100",
   "currency":"NGN",
   "redirect_url":"https://webhook.site/9d0b00ba-9a69-44fa-a43d-a82c33c36fdc",
   "payment_options":"card",
   "meta":{
      "consumer_id":23,
      "consumer_mac":"92a3-912ba-1192a"
   },
   "customer":{
      "email":"user@gmail.com",
      "phonenumber":"080****4528",
      "name":"Yemi Desola"
   },
   "customizations":{
      "title":"Pied Piper Payments",
      "description":"Middleout isn't free. Pay the price",
      "logo":"https://assets.piedpiper.com/logo.png"
   }
}

Flutterwave standard sample response JSON

{
   "status":"success",
   "message":"Hosted Link",
   "data":{
      "link":"https://api.flutterwave.com/v3/hosted/pay/f524c1196ffda5556341"
   }
}

$config['PBFPubKey'] ='FLWPUBK-c221813f280b9ed02ef261eaf30c3790-X' ; /* Public Key for Sandbox : Live */
$config['SECKEY'] =  'FLWSECK-4ff77dbdb3f928aa30ade16014b9ddfe-X' : 'LIVE_SECRET_KEY'; /* Secret Key for Sandbox : Live */
$config['encryption_key'] = '4ff77dbdb3f92879b0349542' 
$data=array(
			"tx_ref"=>"hooli-tx-1920bbtytty",
			"amount"=>"100",
			"currency"=>"NGN",
			"redirect_url"=>"https://api.flutterwave.com/v3/payments",
			"payment_options"=>"card",
			"meta" => array(
			   "consumer_id"=>23,
			   "consumer_mac"=>"92a3-912ba-1192a"
			),
			"customer"=> array(
			   "email"=>"adekoolcomputers@yahoo.com",
			   "phonenumber"=>"7702568162",
			   "name"=>"Ganiyu Adebayo"
			),
			"customizations"=> array(
			   "title"=>"Pied Piper Payments",
			   "description"=>"Middleout isn't free. Pay the price",
			   "logo"=>"https://assets.piedpiper.com/logo.png"
			)
			);