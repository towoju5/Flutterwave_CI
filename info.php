<?php echo convertCurrency('USD', 'NZD', '10');
function convertCurrency($from_Currency, $to_Currency, $amount)
{
    $amount = urlencode($amount);
    $from_Currency = urlencode($from_Currency);
    $to_Currency = urlencode($to_Currency);
    $html = file_get_contents("http://www.xe.com/currencyconverter/convert/?Amount=$amount&From=$from_Currency&To=$to_Currency");
	
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
	echo $dom->saveHTML();
    foreach ($dom->getElementsByTagName('span') as $node) {
		print_r($node);
        if ($node->hasAttribute('class') && strstr($node->getAttribute('class'), 'converterresult-toAmount')){
            $convertedAmt=explode(".",$dom->saveHtml($node));
            $repClass=str_replace('<span class="converterresult-toAmount">','',$convertedAmt[0]);
            $twoGt=str_split($convertedAmt[1],2);
            return $repClass.".".$twoGt[0];
        }
    }
}
?>