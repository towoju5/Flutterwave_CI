<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
/* override number_format function  starts */
	/*-- this for avoiding the round off calculation of currency based amount calculations --*/
	
	function custom_number_format($number, $precision = 2, $separator = '.')
	{
	    $numberParts = explode($separator, $number); //85.256
	    $response = $numberParts[0];
	    if(count($numberParts)>1){
	        $response .= $separator;
	        $response .= substr($numberParts[1], 0, $precision); 
	    }
	    return $response;  
	}
	/* override number_format function ends */


	
	function CurrencyValue($id,$amount)
	{
		
		$rate=0;

		$ci =& get_instance();
			
		$currencyCode     = $ci->session->userdata('currency_type');

		$productCurrencyCode     = $ci->db->where('id',$id)->get(PRODUCT)->row()->currency;
	
		if($currencyCode == '')
		{
			$newCurrencyCode = $ci->db->where(array('status'=>'Active','default_currency'=>'Yes'))->get(CURRENCY)->row()->currency_type;
	
			$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $newCurrencyCode);
			
			$rate= round(currency_convert($params));
			echo $rate;
			if($rate!=0)
				return $rate;
			else
				return $amount;
				
		}
			
		$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

		$rate= number_format(currency_convert($params),2);



		if($rate!=0)
			return $rate;
		else
			return $amount;

	}
	
	function AdminCurrencyValue($id,$amount)
	{
		
		$rate=0;

		$ci =& get_instance();
			
		//$currencyCode      = $ci->db->where(array('status'=>'Active','default_currency'=>'Yes'))->get(CURRENCY)->row()->currency_type;

		$currencyCode  = $ci->db->where(array('id'=>'1'))->get(ADMIN)->row()->admin_currencyCode;

		$productCurrencyCode     = $ci->db->where('id',$id)->get(PRODUCT)->row()->currency;
	
		if($currencyCode == '')
		{
			//$newCurrencyCode = $ci->db->where(array('status'=>'Active','default_currency'=>'Yes'))->get(CURRENCY)->row()->currency_type;

			$newCurrencyCode = $ci->db->where(array('id'=>'1'))->get(ADMIN)->row()->admin_currencyCode;
	
			$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $newCurrencyCode);
			
			$rate= round(currency_convert($params));

			if($rate!=0)
				return $rate;
			else
				return $amount;
				
		}
			
		$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

		$rate= number_format(currency_convert($params),2);

		if($rate!=0)
			return $rate;
		else
			return $amount;

	}

	
	function USDtoOtherCurrency($id,$amount)
	{
			$rate=0;

		$ci =& get_instance();

		$currencyCode     = $ci->db->where('id',$id)->get(PRODUCT)->row()->currency;

		$productCurrencyCode     = 'USD';
	

			
		$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

		$rate= number_format(currency_convert($params),2);

		if($rate!= 0)
			return $rate;
		else
			return $amount;
	}
	
	function USDtoCurrentCurrency($amount){
		
		$rate=0;

		$ci =& get_instance();
			
		$currencyCode     = $ci->session->userdata('currency_type');

		$productCurrencyCode     = 'USD';
			
		$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

		$rate= number_format(currency_convert($params),2);

		if($rate!=0)
			return $rate;
		else
			return $amount;
		
	}
	function currencyConvertToUSD($id,$amount){
		
			$rate=0;

		$ci =& get_instance();

		$productCurrencyCode     = $ci->db->where('id',$id)->get(PRODUCT)->row()->currency;

		$currencyCode     = 'USD';
	

			
		$params  = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

		$rate= number_format(currency_convert($params),2);

		if($rate!= 0)
			return $rate;
		else
			return $amount;
	}
	
	function currencyCode()
	{
	 
	$ci =& get_instance();
	
	// $ip = $_SERVER['REMOTE_ADDR'];

	$ip = '115.118.170.1'; //IND

	//$ip = '146.185.28.59'; //UK
	 
	$host = "http://www.geoplugin.net/php.gp?ip=$ip";
	 
	 if ( ini_get('allow_url_fopen') ) 
	 {
			$response = file_get_contents($host, 'r');	
		}
		 
	 $data = unserialize($response);

	return $data['geoplugin_currencyCode'];
	
}
	
	function currency_convert($params)
	{
		//print_r($params); 
		$amount    = $params["amount"];
	
		$currFrom  = $params["currFrom"];

		$currInto  = $params["currInto"];

		if (trim($amount) == "" ||!is_numeric($amount)) 
		{
			//trigger_error("Please enter a valid amount",E_USER_ERROR);
			return $amount;
		}
		$return=array();

		$ci =& get_instance();
	
		if(trim($currFrom) == 'USD')
		{
			$currInto_result = $ci->db->where('currency_type',$currInto)->get(CURRENCY)->row();
		
			$rate = $amount * $currInto_result->currency_rate;
		}
		else
		{		
			$currFrom_result = $ci->db->where('currency_type',$currFrom)->get(CURRENCY)->row();

			$from_usd=0;
			
			if($currFrom_result->currency_rate > 0)
				$from_usd = 1/$currFrom_result->currency_rate;
	
			$from_usd_amt = $amount * $from_usd;
	
			$currInto_result = $ci->db->where('currency_type',$currInto)->get(CURRENCY)->row();
	
				$rate = $currInto_result->currency_rate * $from_usd_amt;
			
		}
	
		return $rate;
	}
	
	

function pastDateCurrency($id,$date,$Productamount)
{
	$ci =& get_instance();
	//echo $date;
	$currency_date = date('Y-m-d', strtotime($date));
	

$today = date("Y-m-d");


	if ($today <= $currency_date)
		{
return CurrencyValue($id,$Productamount);
	
			
		}
	
	$productCurrencyCode     = $ci->db->where('id',$id)->get(PRODUCT)->row()->currency;
	
	$currentCurrencyCode     = $ci->session->userdata('currency_type');
	
	$amount =  "http://currencies.apps.grandtrunk.net/getrate/$currency_date/$productCurrencyCode/$currentCurrencyCode" ;
//echo $amount; die;
	 if ( ini_get('allow_url_fopen') ) 
		{
			$response = file_get_contents($amount, 'r');	
		}
	
	$current_amount = $Productamount*$response;
	return number_format($current_amount,2);
}

/* CURRENCY CONVERTER */
/*function convertCurrency($from_Currency,$to_Currency,$amount){
$amount = urlencode($amount);
	$from = urlencode($from_Currency);
	$to = urlencode($to_Currency);
	$get = file_get_contents("https://finance.google.com/bctzjpnsun/converter?a=$amount&from=$from&to=$to");
	$get = explode("<span class=bld>",$get);
	$get = explode("</span>",$get[1]);
	$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
	return number_format((float)$converted_amount, 2, '.', '');
}*/

function convertCurrency($from_Currency, $to_Currency, $amount)
{
    /*$amount = urlencode($amount);
    $from_Currency = urlencode($from_Currency);
    $to_Currency = urlencode($to_Currency);
    $html = file_get_contents("http://www.xe.com/currencyconverter/convert/?Amount=$amount&From=$from_Currency&To=$to_Currency");
    $dom = new DOMDocument;
    $dom->loadHTML($html);
    foreach ($dom->getElementsByTagName('span') as $node) {
        if ($node->hasAttribute('class') && strstr($node->getAttribute('class'), 'uccResultAmount')){
            $convertedAmt=explode(".",$dom->saveHtml($node));
            $repClass=str_replace('<span class="uccResultAmount">','',$convertedAmt[0]);
            $twoGt=str_split($convertedAmt[1],2);
            return $repClass.".".$twoGt[0];
        }
    }*/

    /*$amount = urlencode($amount);
    $from_Currency = urlencode($from_Currency);
    $to_Currency = urlencode($to_Currency);
	$url='https://v3.exchangerate-api.com/bulk/f344e1a13f35ba74fcdc2015/USD';
	//$url='https://free.currencyconverterapi.com/api/v5/convert?q='.$from_Currency.'_'.$to_Currency.'&compact=ultra&apiKey=65fd4f1df7f6d16c887f';
	$url='https://free.currencyconverterapi.com/api/v6/convert?apiKey=&q=' . $from_Currency . '_' . $to_Currency . '&compact=ultra&apiKey=8109b8bb62310b09dc12';
	$html = file_get_contents($url);
	$currency_amount=json_decode($html);

	if(count($currency_amount)>0) {
		$eachcurrency=$currency_amount->{$from_Currency.'_'.$to_Currency};
		$retamount=$amount*$eachcurrency;
		return number_format($retamount,2);
	} else {
		return 0;
	}*/

	$amount = urlencode($amount);
	$fromCurrency = urlencode($from_Currency);
	$toCurrency = urlencode($to_Currency);
	$url = "https://www.google.com/search?q=".$fromCurrency."+to+".$toCurrency;
	$get = file_get_contents($url);
	$data = preg_split('/\D\s(.*?)\s=\s/',$get);
	$exhangeRate = (float) substr($data[1],0,7);
	$convertedAmount = $amount*$exhangeRate;
	return number_format($convertedAmount,2);

}
/*function convertCurrency($amount, $from_Currency, $to_Currency){
    $url = 'https://www.google.com/search?q='.$amount.'+' . $from_Currency . '+to+' . $to_Currency;
    $cSession = curl_init();
    curl_setopt($cSession, CURLOPT_URL, $url);
    curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cSession, CURLOPT_SSL_VERIFYPEER, false);
    $buffer = curl_exec($cSession);
    curl_close($cSession);
    $classname = 'J7UKTe';
    $dom = new DOMDocument;
    $dom->loadHTML($buffer);
    $xpath = new DOMXPath($dom);
    $results = $xpath->query("//*[@class='" . $classname . "']");
    if ($results->length > 0) {
        $review = $results->item(0)->nodeValue;
        $arr = explode("=",$review , 2);
        $myObj->input= preg_replace("/[^0-9\.]/", '', $arr[0]);
        $mFrom = preg_replace("!\d+!", '', $arr[0]);
        $mFrom = str_replace(',', '', $mFrom);
        $mFrom = str_replace('.', '', $mFrom);
        $mFrom = substr($mFrom,1);
        $myObj->from= $mFrom;
        $mTo = preg_replace("!\d+!", '', $arr[1]);
        $mTo = str_replace(',', '', $mTo);
        $mTo = str_replace('.', '', $mTo);
        $mTo = substr($mTo,2);
        $myObj->to= $mTo;
        $myObj->output = preg_replace("/[^0-9\.]/", '', $arr[1]);
        $myJSON = ($myObj);
        return 'here1'.$myJSON->output;
    } else return 'test0';

}*/


/* CURRENCY CONVERTER */
/*function convertCurrency($from,$to,$amount,$currencyPerUnitSeller=''){
	//echo 'curr'; exit;
   $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to"; 
   $request = curl_init(); 
   $timeOut = 0; 
   curl_setopt ($request, CURLOPT_URL, $url); 
   curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1); 
   curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); 
   curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut); 
   $response = curl_exec($request); 
   curl_close($request); 
   preg_match("/<span class=bld>(.*)<\/span>/",$response, $converted);
   $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
  
   //return number_format((float)$converted, 2, '.', ''); //orginal
   // return $converted; //tested for currency problem
   
   return custom_number_format($converted, 3,'.'); //tested for currency problem

  
   // $regularExpression     = '#\<span class=bld\>(.+?)\<\/span\>#s';
 //  preg_match($regularExpression, $response, $finalData);
   //return $finalData[0];   
  
}*/





/* CURRENCY CONVERTER */
function convertCurrency_mobile($from_Currency,$to_Currency,$amount){
    $amount = urlencode($amount);$from_Currency = urlencode($from_Currency);
    $to_Currency = urlencode($to_Currency);
    $get = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
    $get = explode("<span class=bld>",$get);
    $get = explode("</span>",$get[1]);
    $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
    if(($from_Currency==$to_Currency) || ($converted_amount=='')){
        return $amount;	}
        else{		return $converted_amount;	}
}
/*function convertCurrency_mobile($from,$to,$amount){
   $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to"; 
   $request = curl_init(); 
   $timeOut = 0; 
   curl_setopt ($request, CURLOPT_URL, $url); 
   curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1); 
   curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); 
   curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut); 
   $response = curl_exec($request); 
   curl_close($request); 
   preg_match("/<span class=bld>(.*)<\/span>/",$response, $converted);
   $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
 
   return $converted;
   
   
}*/

function customised_currency_conversion($unitprice,$total_amount){
	
	$amount=round($total_amount/$unitprice,2);
	return $amount;
}

?>