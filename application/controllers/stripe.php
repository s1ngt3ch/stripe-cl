<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

/*
* Custom Request Timeouts
// set up your tweaked Curl client
$curl = new \Stripe\HttpClient\CurlClient();
$curl->setTimeout(10); // default is \Stripe\HttpClient\CurlClient::DEFAULT_TIMEOUT
$curl->setConnectTimeout(5); // default is \Stripe\HttpClient\CurlClient::DEFAULT_CONNECT_TIMEOUT

echo $curl->getTimeout(); // 10
echo $curl->getConnectTimeout(); // 5

// tell Stripe to use the tweaked client
\Stripe\ApiRequestor::setHttpClient($curl);

// use the Stripe API client as you normally would

* Custom cURL Options (e.g. proxies)
// set up your tweaked Curl client
$curl = new \Stripe\HttpClient\CurlClient([CURLOPT_PROXY => 'proxy.local:80']);
// tell Stripe to use the tweaked client
\Stripe\ApiRequestor::setHttpClient($curl);

* Configuring a Logger
\Stripe\Stripe::setLogger($logger);

* Accessing response data
$customer = $stripe->customers->create([
    'description' => 'example customer',
]);
echo $customer->getLastResponse()->headers['Request-Id'];

* Per-request Configuration
For apps that need to use multiple keys during the lifetime of a process, like one that uses Stripe Connect, it's also possible to set a per-request key and/or account:

$customers = $stripe->customers->all([],[
    'api_key' => 'sk_test_...',
    'stripe_account' => 'acct_...'
]);

$stripe->customers->retrieve('cus_123456789', [], [
    'api_key' => 'sk_test_...',
    'stripe_account' => 'acct_...'
]);

* Configuring CA Bundles
By default, the library will use its own internal bundle of known CA certificates, but it's possible to configure your own:

\Stripe\Stripe::setCABundlePath("path/to/ca/bundle");

 */
?>


