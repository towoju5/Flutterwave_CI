<style>
.stars{
	    /* float: left !important;
    margin-top: -16px !important;
    margin-left: 170px !important; */
    float: none;
    margin-top: -16px !important;
    /* margin-left: 170px !important; */
    display: inline-block;

  }
</style>
<?php

/* ob_start();
$conmap=mysqli_connect("localhost","laravarc_homeliv","$e600Sa]NRV[","laravarc_homestaylive") or die("Couldn't connect db".mysqli_error());
$passqry=mysqli_query($conmap,"select * from fc_review where product_id=$Row_Rental->id");
$gt=$currentcity;
$result1=mysqli_num_rows($passqry); */
?>
<script type="text/javascript">
  <?php if($tot_product < 2) { ?>
	//$('.ui-slider').slider('disable');{"background-color": "yellow", "font-size": "200%"}
	//$(".sidebar .ui-slider-horizontal .ui-slider-range").css({"background-color":"#eeeeee","left":"0%","width":"100%"});
	//$(".ui-corner-all:nth-child(3)").css({"left":"100%"});
	

	<?php } else { ?> 
   $(".sidebar .ui-slider-horizontal .ui-slider-range").css("background-color", "#ff4047");
   <?php } ?>
  // $(document).ready(function(downloadUrl) {
   function downloadUrl() {  
//alert('test');
    var totalResults= '<?php echo $tot_product; ?>';
    
    if(totalResults > 0) {
      //$("#side_bar").html("<img id='validationEr1r' align='middle' style='margin-left:200px; margin-top:20px;' src='images/ajax-loader.gif' />");
      <?php 
      if($tot_product > 0){
        $hoverlist='1';
        //echo '<pre>';echo $productList->result();exit;
        foreach($productList->result() as $Row_Rental){
          if($Row_Rental->currency != $this->session->userdata('currency_type'))
          {
           $filter_price = convertCurrency($Row_Rental->currency,$this->session->userdata('currency_type'),$Row_Rental->price);
         }else{
           $filter_price = $Row_Rental->price;
         }
         if($filter_price >= $pricemin && $filter_price <= $pricemax) {
          if($Row_Rental->userid !='' && $Row_Rental->userid !='0' ){
            $useId=base_url().'users/show/'.$Row_Rental->userid;
          }else{
            $useId='javascript:void(0);';
          }

          if($Row_Rental->userphoto!='' && $Row_Rental->userphoto!='0' ){
            $useImg=base_url().'images/users/'.$Row_Rental->userphoto;
          }else{
            $useImg=base_url().'images/site/profile.png';
          }
          ?>

          var lat ='<?php echo $Row_Rental->latitude; ?>'; 
          var lng ='<?php echo $Row_Rental->longitude; ?>';
          var point = new google.maps.LatLng(lat,lng);
          <?php 
          $avg_val=round($Row_Rental->avg_val);
          $num_reviewers=$Row_Rental->num_reviewers;
          $simg = PRODUCTPATH.'dummyProductImage.jpg';
          if($Row_Rental->product_image!= '' && file_exists('./server/php/rental/'.$Row_Rental->product_image)){ 
            $simg = PRODUCTPATH.$Row_Rental->product_image;
          }else if($Row_Rental->product_image!= '' && strpos($Row_Rental->product_image, 's3.amazonaws.com') > 1)$simg=$Row_Rental->product_image;
          if($Row_Rental->host_status!=1)
          {
           ?>
           var html = '<div class="infoBox similar-listing" ><li><div class="img-top"><div class="figures-cobnt"><a class="listimg-big" href="rental/<?php echo $Row_Rental->id;?>" target="_blank"><img src="<?php echo $simg; ?>"></a><a class="aurtors" id="aur" href="<?php echo $useId; ?>"><img style="border-radius: 50%;" src="<?php echo $useImg; ?>"></a></div><div class="posi-abs" id="rit_posi"><span class="prdpg_mp"><?php echo addslashes(substr($Row_Rental->product_title,0,20)); if(strlen($Row_Rental->product_title)>20) { echo ".."; } ?></span><a class="ajax cboxElement heart" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id; ?>" target="_blank"></a><label class="pric-tag" id="pri_tg"><span class="rm-rate"><?php //echo $currencySymbol; ?></span><?php  echo $currencySymbol; ?><?php 
           if($Row_Rental->currency != $this->session->userdata('currency_type'))
           {
            echo convertCurrency($Row_Rental->currency,$this->session->userdata('currency_type'),$Row_Rental->price);
          }
          else{
            // echo   $Row_Rental->price;
            $priceMap =    $Row_Rental->price;

            echo number_format($priceMap,2);
          }
      //echo convertCurrency(USD,$this->session->userdata('currency_type'),$Row_Rental->price
          ?> <?php echo $this->session->userdata('currency_type');?></label><span class="headlined" id="rit_map"><a  href="rental/<?php echo $Row_Rental->id; ?>"><?php echo addslashes($Row_Rental->product_title); ?></a></span><?php //echo $Row_Rental->id; ?></div></div><div class="img-bottom">';

          html +='<label class="stars">';
          html +='<span class="review_img">';
          html +='<span class="review_st" style="width:<?php echo ($avg_val * 20); ?>%"></span>';
          html +='</span>'
          html +='<span class="rew"><?php echo $num_reviewers; ?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else{ echo "Reviews"; }?></span>';

          html +='</label></div></li></div>';
/* var oPlaceName = document.getElementById("place-name");
var iHeight = oPlaceName.clientHeight + 1;
var iWidth = oPlaceName.clientWidth + 1; */
var details='<li data-price="<?php echo CurrencyValue($Row_Rental->id,$Row_Rental->price); ?>"><div class="img-top">';
<?php if($loginCheck==''){?>

  var details1='<a class="ajax cboxElement heart reg-popup1" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a>';

  <?php }else{ ?>

    var details1='<a class="ajax cboxElement <?php if(in_array($Row_Rental->id,$newArr))echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a>';

    <?php } ?>



    var details2='<div class="figures-cobnt"><a class="listimg-big" href="rental/<?php echo $Row_Rental->id;?>" target="_blank"><img src="<?php echo $simg; ?>"></a><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;" src="<?php echo $useImg; ?>"></a></div><div class="posi-abs"><span class="prdpg_mp"><?php echo addslashes(substr($Row_Rental->product_title,0,20)); if(strlen($Row_Rental->product_title)>20) { echo ".."; } ?></span> <label class="pric-tag"><div class="pricdolr" style="font-weight: bold !important;"><span class="curSymbol"><?php //echo $currencySymbol; ?></span><?php  echo $currencySymbol; ?><?php 
    if($Row_Rental->currency != $this->session->userdata('currency_type'))
    {
      echo  convertCurrency($Row_Rental->currency,$this->session->userdata('currency_type'),$Row_Rental->price);      

    }
    else{
             //echo  $Row_Rental->price;
     $price= $Row_Rental->price;
     echo number_format($price,2);

   }//echo convertCurrency(USD,$this->session->userdata('currency_type'),$Row_Rental->price);?> <?php echo $this->session->userdata('currency_type');?> </div></label><label id="test_lbl" class="rn_map"><label class="star"><a href="<?php echo(($_SERVER['HTTPS'] ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>#reviews">';

   details2 +='<span class="review_img">';
   details2 +='<span class="review_st" style="width:<?php echo ($avg_val * 20); ?>%"></span>';
   details2 +='</span>';
   details2 +='<span class="rew"><?php echo $num_reviewers; ?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else {echo "Reviews"; }?></span>';

   details2 +='<?php //echo $Row_Rental->id; ?></a></label></label></div></div><div class="img-bottom"></div></label></li>';
   /****** Yamuna Updated - 23-11-2016 ***********************/
   var price="<?php if($Row_Rental->currency != $this->session->userdata('currency_type'))
   {
    echo $currencySymbol.convertCurrency($Row_Rental->currency,$this->session->userdata('currency_type'),$Row_Rental->price);
  }
  else{
   echo $currencySymbol.$Row_Rental->price;
 } ?>";
 var price_width=getTextWidth(price,"bold 12pt arial");
 /****** Yamuna Updated - 23-11-2016 ***********************/
 var label ='<?php echo trim(addslashes($Row_Rental->product_title));?>';

          // create the marker

          /****** Yamuna Updated - 23-11-2016 ***********************/
		 //var marker = createMarker(point,label,html,"blue",details+details1+details2,'<?php echo $Row_Rental->id; ?>');
		 var setzindex=Math.floor(Math.random()*1000);
     var marker = createMarker(point,label,html,"blue",details+details1+details2,'<?php echo $Row_Rental->id; ?>',price,price_width,35,setzindex);
     /****** Yamuna Updated - 23-11-2016 ***********************/
     <?php $hoverlist=$hoverlist+1; 
   } }}


 } ?>



        // put the assembled side_bar_html contents into the side_bar div

        side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
        //print_r(side_bar_html);die();

        side_bar_html=side_bar_html+'</ul></div>';

        $("#side_bar").html(side_bar_html);

        side_bar_html = "";

       <?php if($tot_product==0){ ?>
          $("#side_bar").html("<?php if($this->lang->line('No_rentals_found') != '') { echo stripslashes($this->lang->line('No_rentals_found')); } else echo "No rentals found";?>..");
        <?php } ?> 

      } else {
        $("#side_bar").html("<?php if($this->lang->line('No_rentals_found') != '') { echo stripslashes($this->lang->line('No_rentals_found')); } else echo "No rentals found";?>..");

      }
//});
    }


    function getTextWidth(text, font) {
    // re-use canvas object for better performance
    var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
    var context = canvas.getContext("2d");
    context.font = font;
    var metrics = context.measureText(text);
    return Math.round(metrics.width)+5;
  }


</script>