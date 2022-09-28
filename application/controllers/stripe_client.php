<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');

class Stripe_client extends CI_Controller{
	var	$url = 'https://api.stripe.com/v1/';
	var	$username = 'admin';
	var	$password = '1234';
	
	public function __construct()
	{
		parent::__construct();

		$this->load->library('curl');
		$this->load->library('rest');
		$this->load->helper('url');
	}

	public function index()
    {
		$data['items'] = json_decode($this->curl->simple_get($this->url.'/item'));
        $this->load->view('rest_client',$data);
    }
	
	function stripe_cust()
	{
		$stripe = new \Stripe\StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
		$customer = $stripe->customers->create([
			'description' => 'example customer',
			'email' => 'email@example.com',
			'payment_method' => 'pm_card_visa',
		]);
		echo $customer;
		/*
		http://localhost/stripe-cl/index.php/stripe_client/stripe_cust
		Stripe\Customer JSON: { 
			"id": "cus_MVgKY2CId0hciN", 
			"object": "customer", 
			"address": null, "balance": 0, "created": 1664289654, 
			"currency": null, "default_source": null, "delinquent": false, 
			"description": "example customer", "discount": null, 
			"email": "email@example.com", "invoice_prefix": "77B9BEE4", 
			"invoice_settings": { "custom_fields": null, 
				"default_payment_method": null, "footer": null, 
				"rendering_options": null }, 
			"livemode": false, "metadata": [], "name": null, 
			"next_invoice_sequence": 1, "phone": null, 
			"preferred_locales": [], "shipping": null, "tax_exempt": "none", 
			"test_clock": null }
		*/
	}
	
	function create_price()
	{
		$stripe = new \Stripe\StripeClient("sk_test_51LmHcZDuPeFawTq3mpEPJIsEvC2zgyrnu8lJTWxwX2t26HlUWqN8NyiZbxE0DQTEtcVmVu66NJh7LM3C7t5Iexam00DYGYQ7Z5");

		$product = $stripe->products->create([
		  'name' => 'Starter Subscription',
		  'description' => '$12/Month subscription',
		]);
		echo "Success! Here is your starter subscription product id: " . $product->id . "\n";

		$price = $stripe->prices->create([
		  'unit_amount' => 1200,
		  'currency' => 'usd',
		  'recurring' => ['interval' => 'month'],
		  'product' => $product['id'],
		]);
		echo "Success! Here is your premium subscription price id: " . $price->id . "\n";
		//Success! Here is your starter subscription product id: prod_MVMft5XbTrjbf1 
		//Success! Here is your premium subscription price id: price_1LmLvqDuPeFawTq3wvx515dE 
	}
	
	function create_charge()
	{
		<?php

// The version number (9_5_0) should match version of the Chilkat extension used, omitting the micro-version number.
// For example, if using Chilkat v9.5.0.48, then include as shown here:
include("chilkat_9_5_0.php");

$rest = new CkRest();

//  URL: https://api.stripe.com/v1/charges
$bTls = true;
$port = 443;
$bAutoReconnect = true;
$success = $rest->Connect('api.stripe.com',$port,$bTls,$bAutoReconnect);
if ($success != true) {
    print 'ConnectFailReason: ' . $rest->get_ConnectFailReason() . "\n";
    print $rest->lastErrorText() . "\n";
    exit;
}

$rest->SetAuthBasic('STRIPE_SECRET_KEY','');

$rest->AddQueryParam('amount','2000');
$rest->AddQueryParam('currency','usd');
$rest->AddQueryParam('source','tok_visa');
$rest->AddQueryParam('description','Charge for aiden.jones@example.com');

$strResponseBody = $rest->fullRequestFormUrlEncoded('POST','/v1/charges');
if ($rest->get_LastMethodSuccess() != true) {
    print $rest->lastErrorText() . "\n";
    exit;
}

$jsonResponse = new CkJsonObject();
$jsonResponse->Load($strResponseBody);

$id = $jsonResponse->stringOf('id');
$object = $jsonResponse->stringOf('object');
$amount = $jsonResponse->IntOf('amount');
$amount_refunded = $jsonResponse->IntOf('amount_refunded');
$application = $jsonResponse->IsNullOf('application');
$application_fee = $jsonResponse->IsNullOf('application_fee');
$balance_transaction = $jsonResponse->stringOf('balance_transaction');
$captured = $jsonResponse->BoolOf('captured');
$created = $jsonResponse->IntOf('created');
$currency = $jsonResponse->stringOf('currency');
$customer = $jsonResponse->IsNullOf('customer');
$description = $jsonResponse->stringOf('description');
$destination = $jsonResponse->IsNullOf('destination');
$dispute = $jsonResponse->IsNullOf('dispute');
$failure_code = $jsonResponse->IsNullOf('failure_code');
$failure_message = $jsonResponse->IsNullOf('failure_message');
$invoice = $jsonResponse->IsNullOf('invoice');
$livemode = $jsonResponse->BoolOf('livemode');
$on_behalf_of = $jsonResponse->IsNullOf('on_behalf_of');
$order = $jsonResponse->IsNullOf('order');
$outcome = $jsonResponse->IsNullOf('outcome');
$paid = $jsonResponse->BoolOf('paid');
$receipt_email = $jsonResponse->IsNullOf('receipt_email');
$receipt_number = $jsonResponse->IsNullOf('receipt_number');
$refunded = $jsonResponse->BoolOf('refunded');
$refundsObject = $jsonResponse->stringOf('refunds.object');
$refundsHas_more = $jsonResponse->BoolOf('refunds.has_more');
$refundsTotal_count = $jsonResponse->IntOf('refunds.total_count');
$refundsUrl = $jsonResponse->stringOf('refunds.url');
$review = $jsonResponse->IsNullOf('review');
$shipping = $jsonResponse->IsNullOf('shipping');
$sourceId = $jsonResponse->stringOf('source.id');
$sourceObject = $jsonResponse->stringOf('source.object');
$sourceAddress_city = $jsonResponse->IsNullOf('source.address_city');
$sourceAddress_country = $jsonResponse->IsNullOf('source.address_country');
$sourceAddress_line1 = $jsonResponse->IsNullOf('source.address_line1');
$sourceAddress_line1_check = $jsonResponse->IsNullOf('source.address_line1_check');
$sourceAddress_line2 = $jsonResponse->IsNullOf('source.address_line2');
$sourceAddress_state = $jsonResponse->IsNullOf('source.address_state');
$sourceAddress_zip = $jsonResponse->IsNullOf('source.address_zip');
$sourceAddress_zip_check = $jsonResponse->IsNullOf('source.address_zip_check');
$sourceBrand = $jsonResponse->stringOf('source.brand');
$sourceCountry = $jsonResponse->stringOf('source.country');
$sourceCustomer = $jsonResponse->IsNullOf('source.customer');
$sourceCvc_check = $jsonResponse->IsNullOf('source.cvc_check');
$sourceDynamic_last4 = $jsonResponse->IsNullOf('source.dynamic_last4');
$sourceExp_month = $jsonResponse->IntOf('source.exp_month');
$sourceExp_year = $jsonResponse->IntOf('source.exp_year');
$sourceFingerprint = $jsonResponse->stringOf('source.fingerprint');
$sourceFunding = $jsonResponse->stringOf('source.funding');
$sourceLast4 = $jsonResponse->stringOf('source.last4');
$sourceName = $jsonResponse->IsNullOf('source.name');
$sourceTokenization_method = $jsonResponse->IsNullOf('source.tokenization_method');
$source_transfer = $jsonResponse->IsNullOf('source_transfer');
$statement_descriptor = $jsonResponse->IsNullOf('statement_descriptor');
$status = $jsonResponse->stringOf('status');
$transfer_group = $jsonResponse->IsNullOf('transfer_group');
$i = 0;
$count_i = $jsonResponse->SizeOfArray('refunds.data');
while ($i < $count_i) {
    $jsonResponse->put_I($i);
    $i = $i + 1;
}


?>
	}
}