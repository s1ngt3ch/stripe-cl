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
		$links = array( 
			"Link 1 - create_cust"=>"create_cust", 
			"Link 2 - create_price"=>"create_price", 
			"Link 3 - create_charge"=>"create_charge",
			"Link 4 - create_cardholder"=>"create_cardholder" 
		); 
	 
		foreach($links as $text=>$url) { 
			echo '<a href="'.$url.'">'.$text.'</a><br/>'; 
		} 
    }
	
	function create_cust()
	{
		$stripe = new \Stripe\StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
		$customer = $stripe->customers->create([
			'description' => 'example customer',
			'email' => 'email@example.com',
			'payment_method' => 'pm_card_visa',
		]);
		echo $customer;
		/*
		http://localhost/stripe-cl/index.php/stripe_client/create_cust
		Stripe\Customer JSON: { 
			"id": "cus_MWZ4n2ERpdRVPd",               	"object": "customer", 
			"address": null,  "balance": 0,           	"created": 1664493278, 
			"currency": null, "default_source": null, 	"delinquent": false, 
			"description": "example customer",        	"discount": null, 
			"email": "email@example.com", 				"invoice_prefix": "F740698C", 
			"invoice_settings": { 
				"custom_fields": null, 	"default_payment_method": null, 
				"footer": null, 		"rendering_options": null 
				}, 
			"livemode": false, 			"metadata": [], "name": null, 
			"next_invoice_sequence": 1, "phone": null, 
			"preferred_locales": [], 	"shipping": null, 
			"tax_exempt": "none", 		"test_clock": null 
		}
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
		/**
		 * http://localhost/stripe-cl/index.php/stripe_client/create_price
		 * Success! Here is your starter subscription product id: prod_MWZ6ZF83RLHZxo 
		 * Success! Here is your premium subscription price id: price_1LnVyiDuPeFawTq3zPcL9FTz 
		 */
	}
	
	function create_charge()
	{
		$this->load->library('stripe_cls');

		// create customer and use email to identify them in stripe
		$s = new Stripe_cls();
		$s->url .= 'customers';
		$s->method = "POST";
		$s->fields['email'] = 'email@example.com';
		$customer = $s->call();
		echo json_encode($customer);

		// create customer subscription with credit card and plan
		$s = new Stripe_cls();
		$s->url .= 'customers/'.$customer['id'].'/subscriptions';
		$s->method = "POST";
		$s->fields['plan'] ='my_plan'; // name of the stripe plan i.e. my_stripe_plan
		// credit card details
		$s->fields['source'] = array(
			'object' => 'card',
			'exp_month' => '10',
			'exp_year' => '2023',
			'number' => '123456789123456',
			'cvc' => '123'
		);
		$subscription = $s->call();
		echo json_encode($subscription);
	}

	function create_cardholder()
	{
		$this->load->library('stripe_cls');

		// create customer and use email to identify them in stripe
		$s = new Stripe_cls();
		$s->url .= 'issuing/cardholders';
		$s->method = "POST";
		$s->fields = [
			'name' => 'Jenny Rosen',
			'email' => 'jenny.rosen@example.com',
			'phone_number' => '+18008675309',
			'status' => 'active',
			'type' => 'individual',
			'billing' => [
			  'address' => [
				'line1' => '123 Main Street',
				'city' => 'San Francisco',
				'state' => 'CA',
				'postal_code' => '94111',
				'country' => 'SG',
			  ],
			],
		  ];
		  $cardholder = $s->call();
		echo json_encode($cardholder);
	}

}