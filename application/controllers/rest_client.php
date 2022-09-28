<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_client extends CI_Controller{
	var	$url = 'http://localhost/ci-rest-server/index.php/api/item';
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
		$data['items'] = json_decode($this->curl->simple_get($this->url));
        $this->load->view('rest_client',$data);
    }
	
	function native_curl($new_name, $new_email)
	{		
		// Alternative JSON version
		// $url = 'http://twitter.com/statuses/update.json';
		// Set up and execute the curl process
		$curl_handle = curl_init();
		
		curl_setopt($curl_handle, CURLOPT_URL, $this->url.'users/id/1/format/json');
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
		'name' => $new_name,
		'email' => $new_email
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

		$this->curl->create($this->url.'users/id/1/format/json'); 

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

	public function item()
	{
		//very simple php function file_get_contents()
		//$item = json_decode(file_get_contents($this->url.'item/3/format/json'));
		//$result = $item->title;
		
		// Simple call to remote URL
		$result = $this->curl->simple_get($this->url.'item');
		
		$data= array(
			//'item'		=> $item
			'result'	=> $result
			);
			
		// Simple call to CI URI
		//$this->curl->simple_post('controller/method', array('foo'=>'bar'));

		// Set advanced options in simple calls
		// Can use any of these flags http://uk3.php.net/manual/en/function.curl-setopt.php

		//$this->curl->simple_get($url, array(CURLOPT_PORT => 8080));
		//$this->curl->simple_post($url, array('foo'=>'bar'), array(CURLOPT_BUFFERSIZE => 10)); 
		
		$this->load->view("rest_client2", $data);
	}
	
	public function item2()
	{
		// Advanced calls
		// These methods allow you to build a more complex request.

		// Start session (also wipes existing/previous sessions)
		$this->curl->create($this->url.'item');

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
		echo $this->curl->execute();
		// Execute - returns responce
		//$result = $this->curl->execute();
		//$user = json_decode($result);
		//$this->load->view("rest_client", array('result' => $result, 'user' => $user));
		
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
		$this->load->library('rest', array(
			'server' => $this->url.'/',
			//'server' => 'http://localhost/ci_restserver/index.php/api/example/',
			//'http_user' => 'admin',
			//'http_pass' => '1234',
			'http_auth' => 'none'	//'basic' // or 'digest'
		));

		$user = $this->rest->get('index.php', array('id' => $id), 'json');
		//$user = $this->rest->get('users', array('id' => $id), 'json');
		//$user = $this->rest->get('users', array('id' => $id), 'application/json');
		
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
		var_dump($user);
		$result = json_encode($user);
		var_dump($result);
		echo $result;
		// $this->load->view("rest_client", array('result' => $result, 'user' => $user));
		//echo $this->rest->debug();
		
	}
	
	//using REST client library
	function sample($new_name,$new_email)
	{
		$this->load->library('rest', array(
			'server' => $this->url.'/',
			//'http_user' => $this->username,
			//'http_pass' => $this->password,
			'http_auth' => 'none'	//'basic' // or 'digest'
		));

		$user = $this->rest->post('index.php',array(
				'title' => $new_name, 
				'description' => $new_email), 
				'json');
		// debug_to_console("Test");
		//encode : object -> string; decode : string -> object
		$result = json_encode($user);
		echo $new_name.' : '.$new_email.' : '.$result;
		//$this->load->view("rest_client", array('result' => $result, 'user' => $user));
		//echo $this->rest->debug();
	}	
	
	// function debug_to_console($data) {
	// 	$output = $data;
	// 	if (is_array($output))
	// 		$output = implode(',', $output);
	
	// 	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
	// }
}