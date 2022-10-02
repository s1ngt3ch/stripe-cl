<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_client extends CI_Controller{
	var	$url = 'http://localhost/ci-rest-server/index.php/api/example/';
	var	$username = 'admin';
	var	$password = '1234';
	
	public function __construct()
	{
		parent::__construct();

		$this->load->library('curl');
		$this->load->helper('url');
	}

	public function index()
    {
		$data['users'] = json_decode($this->curl->simple_get($this->url.'users'));
        $this->load->view('rest_client',$data);
    }
	
	function native_curl($name_new, $email_new)
	{		
		// Alternative JSON version
		// $url = 'http://twitter.com/statuses/update.json';
		// Set up and execute the curl process
		$curl_handle = curl_init();
		
		curl_setopt($curl_handle, CURLOPT_URL, $this->url.'users');
		// curl_setopt($curl_handle, CURLopt, 1);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
		'name' => $name_new,
		'email' => $email_new
		));

		// Optional, delete this line if your API is open
		//curl_setopt($curl_handle, CURLOPT_USERPWD, $this->username . ':' . $this->password);

		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
		
		$result = json_decode($buffer);

		if(isset($result->status) && $result->status == 'success')
		{
			echo 'User has been updated.';
		}
		else
		{
			echo 'Something has gone wrong';
		}
	}

	function ci_curl($new_name, $new_email) 
	{ 
		$this->load->library('curl'); 

		$this->curl->create($this->url.'users'); 

		// Optional, delete this line if your API is open 
		//$this->curl->http_login($this->username, $this->password); 

		$this->curl->post(array( 
		'name' => $new_name, 
		'email' => $new_email 
		)); 

		$result = json_decode($this->curl->execute()); 

		if(isset($result->status) && $result->status == 'success') 
		{ 
			echo 'User ['.$result->name.'] ';
			echo 'has been updated.'; 
		} 

		else 
		{ 
			echo 'Something has gone wrong'; 
		} 
	} 

	public function user()
	{
		//very simple php function file_get_contents()
		//$item = json_decode(file_get_contents($this->url.'item/3/format/json'));
		//$result = $item->title;
		
		// Simple call to remote URL
		$result = $this->curl->simple_get($this->url.'users');
		$data = array(
			'users'	=> json_decode( $result )
			);
			
		// Simple call to CI URI
		//$this->curl->simple_post('controller/method', array('foo'=>'bar'));

		// Set advanced options in simple calls
		// Can use any of these flags http://uk3.php.net/manual/en/function.curl-setopt.php

		//$this->curl->simple_get($url, array(CURLOPT_PORT => 8080));
		//$this->curl->simple_post($url, array('foo'=>'bar'), array(CURLOPT_BUFFERSIZE => 10)); 
		
		$this->load->view("rest_client", $data);
	}
	
	public function user_adv()
	{
		// Advanced calls
		// These methods allow you to build a more complex request.

		// Start session (also wipes existing/previous sessions)
		$this->curl->create($this->url.'users');

		// Option & Options
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));

		// More human looking options
		$this->curl->option('buffersize', 10);

		// Login to HTTP user authentication
		//$this->curl->http_login($this->username, $this->password);

		// Post - If you do not use post, it will just run a GET request
		//$post = array('foo'=>'bar');
		//$this->curl->post($post);

		// Cookies - If you do not use post, it will just run a GET request
		//$vars = array('foo'=>'bar');
		//$this->curl->set_cookies($vars);

		// Proxy - Request the page through a proxy server
		// Port is optional, defaults to 80
		//$this->curl->proxy($url, 1080);
		//$this->curl->proxy($url);

		// Proxy login
		//$this->curl->proxy_login('username', 'password');

		// Execute - returns responce
		// echo $this->curl->execute();
		// Execute - returns responce
		$result = $this->curl->execute();
		$users = json_decode($result);
		$this->load->view("rest_client", array('result' => $result, 'users' => $users));
		
		// Debug data ------------------------------------------------

		// Errors
		$this->curl->error_code; // int
		$this->curl->error_string;

		// Information
		$this->curl->info; // array
	}
	
	//using REST client library
	function rest_client_example($id)
	{
		// Load the rest client spark
		// $this->load->spark('restclient/2.2.1');

		// Load the library
		$this->load->library('rest');

		// Set config options (only 'server' is required to work)
		$config = array('server' 			=> $this->url,
						//'api_key'			=> 'Setec_Astronomy'
						//'api_name'		=> 'X-API-KEY'
						//'http_user' 		=> 'username',
						//'http_pass' 		=> 'password',
						'http_auth' 		=> 'none'	//'basic' // or 'digest'
						//'ssl_verify_peer' => TRUE,
						//'ssl_cainfo' 		=> '/certs/cert.pem'
						);

		// Run some setup
		$this->rest->initialize($config);

		// Pull in an array
		$user = $this->rest->get('users', array('id' => $id), 'json');
		// $user = $this->rest->get('users', array('id' => $id), 'application/json');
		
		/*
		As you have probably guessed as well as 
		$this->rest->get(), 
		the library also supports 
		$this->rest->post(), 
		$this->rest->put(), 
		$this->rest->delete() 
		to match all of your REST_Controller methods.
		*/
		
		//encode : object -> string; decode : string -> object
		$result = json_encode($user);
		echo $result;
	
	}
	
	//using REST client library
	function sample($new_name,$new_email)
	{
		// Load the library
		$this->load->library('rest');

		// Set config options (only 'server' is required to work)
		$config = array('server' 			=> $this->url,
						//'api_key'			=> 'Setec_Astronomy'
						//'api_name'		=> 'X-API-KEY'
						//'http_user' 		=> 'username',
						//'http_pass' 		=> 'password',
						'http_auth' 		=> 'none'	//'basic' // or 'digest'
						//'ssl_verify_peer' => TRUE,
						//'ssl_cainfo' 		=> '/certs/cert.pem'
						);

		// Run some setup
		$this->rest->initialize($config);

		// Push in an array
		$user = $this->rest->post('users',array(
				'name'  => $new_name, 
				'email' => $new_email
				// 'json'
				));
		
		//encode : object -> string; decode : string -> object
		$result = json_encode($user);
		echo $new_name.' : '.$new_email.' : '.$result;
	}	
	
}