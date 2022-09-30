<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe_cls
{
    public $headers;
    public $url = 'https://api.stripe.com/v1/';
    public $method = null;
    public $fields = array();
    
    function __construct () {
        //$this->headers = array('Authorization: Bearer '.STRIPE_API_KEY); // STRIPE_API_KEY = your stripe api key
        $this->headers = array('Authorization: Bearer '."sk_test_51LmHcZDuPeFawTq3mpEPJIsEvC2zgyrnu8lJTWxwX2t26HlUWqN8NyiZbxE0DQTEtcVmVu66NJh7LM3C7t5Iexam00DYGYQ7Z5"); // STRIPE_API_KEY = your stripe api key
    }
    
    function call () {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        switch ($this->method){
           case "POST":
              curl_setopt($ch, CURLOPT_POST, 1);
              if ($this->fields)
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $this->fields);
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
    }
}

/* End of file Stripe_cls.php */
/* Location: ./application/libraries/Stripe_cls.php */