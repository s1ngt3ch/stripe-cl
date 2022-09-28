<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_client extends CI_Controller{
	var	$url = 'http://localhost/ci-rest-server/index.php/api/item';
	var	$username = 'admin';
	var	$password = '1234';
	
	public function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('curl');
		$this->load->library('rest');
		$this->load->helper('form');
		$this->load->helper('url');
	}

	public function index()
    {
		$data['items'] = json_decode($this->curl->simple_get($this->url));
        $this->load->view('display',$data);
    }

    function create(){
        if(isset($_POST['submit'])){
            $data = array(
                'id'         =>  $this->input->post('id'),
                'title'      =>  $this->input->post('title'),
                'description'=>  $this->input->post('description'));
            $insert =  $this->curl->simple_post($this->url, $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($insert)
            {
                $this->session->set_flashdata('result','Insert successfully');
            }else
            {
               $this->session->set_flashdata('result','Insert failed');
            }
            redirect('test_client');
        }else{
            $this->load->view('create');
        }
    }
    
    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id'          =>  $this->input->post('id'),
                'title'       =>  $this->input->post('title'),
                'description' =>  $this->input->post('description'));
            $update =  $this->curl->simple_put($this->url.'/index', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($update)
            {
                $this->session->set_flashdata('result','Update successfully');
            }else
            {
               $this->session->set_flashdata('result','Update failed');
            }
            redirect('test_client');
        }else{
            $params = array('id'=>  $this->uri->segment(3));
            $data['items'] = json_decode($this->curl->simple_get($this->url,$params));
            $this->load->view('edit',$data);
        }
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!$id){
            redirect('test_client');
        }else{
            // localhost/ci-rest-server/index.php/api/item/index/id/6
            // array(1) { ["id"]=> string(1) "2" }
            // $params = array('id'=> $id);
            // var_dump($params);
            // $delete =  $this->curl->simple_delete($this->url.'/index', array('id'=>$id), array(CURLOPT_BUFFERSIZE => 10)); 
            // $delete =  $this->curl->simple_delete($this->url.'/index', $params, array(CURLOPT_BUFFERSIZE => 10)); 
            // var_dump($delete);
            // $delete =  $this->curl->simple_delete($this->url.'/index/id/1', array(CURLOPT_BUFFERSIZE => 10)); 
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->url.'/index/id'.$id);
            curl_setopt($curl, CURLOPT_URL, $this->url.'/index/'.$id);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
            curl_close($curl);
            if($delete)
            {
                $this->session->set_flashdata('result','Delete successfully');
            }else
            {
               $this->session->set_flashdata('result','Delete failed');
            }
            redirect('test_client');
        }
    }
}