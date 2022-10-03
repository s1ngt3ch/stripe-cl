<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe_cls
{
   var $CI; 
   var $api_error; 

   public $headers;
   public $url = 'https://api.stripe.com/v1/';
   public $method = null;
   public $fields = array();
    
    function __construct () {
      $this->api_error = ''; 
      $this->CI =& get_instance(); 
      $this->CI->load->config('stripe'); 

      $this->headers = array('Authorization: Bearer '.$this->CI->config->item('stripe_api_key')); // STRIPE_API_KEY = your stripe api key
      // $this->headers = array('Authorization: Bearer '."sk_test_51LmHcZDuPeFawTq3mpEPJIsEvC2zgyrnu8lJTWxwX2t26HlUWqN8NyiZbxE0DQTEtcVmVu66NJh7LM3C7t5Iexam00DYGYQ7Z5"); // STRIPE_API_KEY = your stripe api key
    }
    
    function call () {
      try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        switch ($this->method){
           case "POST":
              curl_setopt($ch, CURLOPT_POST, 1);
              if ($this->fields)
                 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->fields));
              break;
           case "PUT":
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($this->fields)
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $this->fields);
              break;
           default:
              if ($this->fields)
                 $this->url = sprintf("%s?%s", $this->url, http_build_query($this->fields));
        }

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true); // return php array with api response
      }catch(Exception $e) { 
        $this->api_error = $e->getMessage(); 
        return false; 
      } 
 }
}

/* End of file Stripe_cls.php */
/* Location: ./application/libraries/Stripe_cls.php */