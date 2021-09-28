<?php



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Currency_converter extends MY_Controller {



	function __construct(){

        parent::__construct();

		$this->load->helper(array('cookie','date','form','email'));

		$this->load->library(array('encrypt','form_validation'));		

		$this->load->model('cart_model');

		



    }

	function index()

	{

	



		$url = file_get_contents("http://openexchangerates.org/api/latest.json?app_id=62eb7fcc63b8421da359ac65d877833f
");

        $json_a=json_decode($url,true);

		$curr = $this->cart_model->get_all_details('fc_currency',array());

		foreach($curr->result() as $row)

		{

		$this->cart_model->update_details('fc_currency',array('currency_rate'=>$json_a['rates']["$row->currency_type"]),array('currency_type'=>$row->currency_type));

		echo $this->db->last_query();

		}

	

		redirect('');	

	}

	function check_currency()

	{

		$url = file_get_contents("http://openexchangerates.org/api/latest.json?app_id=62eb7fcc63b8421da359ac65d877833f");

        $json_a=json_decode($url,true);

		$CRC = $json_a['rates']['CRC'];

		$USD = $json_a['rates']['USD'];

		$final = $USD/$CRC;

		$amount = 60;

		echo $amount = $amount*$final;die;

		echo $amount*100;

	}

}

	?>