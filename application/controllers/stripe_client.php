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
		echo 'customer : ', json_encode($customer), PHP_EOL;

		// tokenize
		$s = new Stripe_cls();
		$s->url .= 'tokens';
		$s->method = "POST";
		$s->fields['card'] = [
			  'number' => '4242424242424242',
			  'exp_month' => 12,
			  'exp_year' => 2034,
			  'cvc' => '567',
			// 'customer' => $customer['id'],
		  ];
		//   var_dump($s->fields);
		$token = $s->call();
		echo ' \r\ntokenize : ', json_encode($token), PHP_EOL;
		var_dump($token['id']);

		//payment method
		$s = new Stripe_cls();
		$s->url .= 'payment_methods';
		$s->method = "POST";
		$s->fields['type'] = 'card';
		$s->fields['card'] = [
			  'number' => '4242424242424242',
			  'exp_month' => 12,
			  'exp_year' => 2034,
			  'cvc' => '567',
			// 'customer' => $customer['id'],
		  ];
		$pmt_method = $s->call();
		var_dump($pmt_method);
		//SetupIntent
		$s = new Stripe_cls();
		$s->url .= 'setup_intents';
		$s->method = "POST";
		$s->fields = [
			'payment_method_types'=>['card'],
			'payment_method' => $pmt_method['id'],
			'customer' => $customer['id'],
			'description' => 'Great simple Uniq Cust Name',
			// 'confirm' => true,
			'usage' => "off_session"
	  	];
		$intent = $s->call();
		var_dump($intent);
		// create customer subscription with credit card and plan
		$s = new Stripe_cls();
		$s->url .= 'customers/'.$customer['id'].'/subscriptions';
		$s->method = "POST";
		$s->fields['items'] = [
			'price_data' => [
			  'unit_amount' => 5000,
			  'currency' => 'usd',
			  'product' => 'prod_456',
			  'recurring' => [
				'interval' => 'month',
			  ],
			],
		  ];
		// credit card details
		// $s->fields['default_payment_method'] = $token['id'];
		$s->fields['default_payment_method'] = $pmt_method['id'];
		$stripe_sub = $s->call();
		var_dump($stripe_sub);
	 	$subscription_id = $stripe_sub['id'];
	 	$subscription_item_id = $stripe_sub['items']['data'][0]['id'];

		echo '\nsubscription : '. json_encode($stripe_sub), $subscription_id, $subscription_item_id;
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

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

$cardholder = \Stripe\Issuing\Cardholder::create([
    'name' => 'Jenny Rosen',
    'email' => 'jenny.rosen@example.com',
    'phone_number' => '+18008675309',
    'status' => 'active',
    'type' => 'individual',
    'billing' => [
        'name' => 'Jenny Rosen',
        'address' => [
            'line1' => '1234 Main Street',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postal_code' => '94111',
            'country' => 'US',
        ],
    ],
]);