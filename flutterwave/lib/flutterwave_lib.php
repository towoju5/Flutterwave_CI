<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Flutter Wave Library for CodeIgniter 3.X.X
 *
 * Library for Flutter Wave payment gateway. It helps to integrate Flutter Wave payment gateway's Standard Method
 * in the CodeIgniter application.
 *
 * It requires Flutterwave configuration file and it should be placed in the config directory.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      Jaydeep Goswami
 * @link        https://infinitietech.com
 * @GITHUB link https://github.com/jaydeepgiri/Flutterwave-Payments-CodeIgniter-3.X.X-Library
 * @license     https://github.com/jaydeepgiri/Flutterwave-Payments-CodeIgniter-3.X.X-Library/blob/master/LICENSE
 * @version     1.0
 */

class Flutterwave_lib{
    public static $payment_url,$verify_url;
    public static $PBFPubKey, $SECKEY, $txn_prefix;
    public $test;
    public static $currency = 'NGN';
    public $post_data = array();
    var $CI;
    function __construct(){
      
        $this->CI = & get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('form');
        $this->CI->load->config('flutterwave');
        
        $this->payment_url = $this->CI->config->item('payment_endpoint');
        $this->verify_url = $this->CI->config->item('verify_endpoint');
        $this->PBFPubKey = $this->CI->config->item('PBFPubKey');
        $this->SECKEY = $this->CI->config->item('SECKEY');
        $this->currency = $this->CI->config->item('currency');
        $this->txn_prefix = $this->CI->config->item('txn_prefix');
    }
    
    // function create_payment($data){
    //     var_dump('ok');exit;
    //     $data['PBFPubKey'] = $this->PBFPubKey;
    //     $data['currency'] = $this->currency;
    //     $data['txref'] = (!empty($this->txn_prefix))?$this->txn_prefix.'-'.time().''.mt_rand() : time().''.mt_rand();
    //     $response = $this->curl_post($this->payment_url, $data,TRUE);
    //     return $response;
    // }
    public static function create_payment($data){
        // $data['PBFPubKey'] = self::$PBFPubKey;
        $data['PBFPubKey'] = "FLWPUBK-c221813f280b9ed02ef261eaf30c3790-X";
        $data['currency'] = self::$currency;
        $data['txref'] = (!empty(self::$txn_prefix))?self::$txn_prefix.'-'.time().''.mt_rand() : time().''.mt_rand();
        $response = self::curl_post(self::$payment_url, $data,TRUE);
        return $response;
    }
    
    public static function verify_transaction($reference){
        $data = array(
			"SECKEY" => $this->SECKEY, 
			"txref" => $reference
		);
		$response = $this->curl_post($this->verify_url, $data,TRUE);
        return $response;
    }
    
    public  static function curl_post($url, $data,$json_encode_data = FALSE){
        
        $data = ($json_encode_data)?json_encode($data):$data;
        var_dump($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_CUSTOMREQUEST => "POST",
    		CURLOPT_POSTFIELDS => $data,
    		CURLOPT_HTTPHEADER => [
    			"content-type: application/json",
    			"cache-control: no-cache"
    		],
    	));
        var_dump($curl);
    	$response = curl_exec($curl);
    	var_dump($response);exit;
    	if($err = curl_error($curl)){
    	    curl_close($curl);
    	    return "CURL Error : ".$err;
    	}else{
        	curl_close($curl);
        	return $response;
        }
    }
}
