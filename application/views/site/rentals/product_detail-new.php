<?php 
$this->load->view('site/templates/header');
//print_r($productDetails->result());
foreach($productDetails->result() as $productlist)
{
$productId=$productlist->id;

$listings_values = $productlist->listings;
}  
//echo $listings_values;
$product = $productDetails->row();

?>
<style>
.ui-datepicker .ui-datepicker-prev, 
.ui-datepicker .ui-datepicker-next,
.ui-datepicker .ui-datepicker-header
{background:#e2e2e2 !important}


#location{width: 100%}

.btn-create.create-button{

display:block;

}
.header.active
{
display:none;	
}
.create-button {

background-color: #018FE1;

background-image: -moz-linear-gradient(top, #33BEFF, #018FE1);

background-image: -ms-linear-gradient(top, #33BEFF, #018FE1);

background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#33BEFF), to(#018FE1));

background-image: -webkit-linear-gradient(top, #33BEFF, #018FE1);

background-image: -o-linear-gradient(top, #33BEFF, #018FE1);

background-image: linear-gradient(top, #33BEFF, #018FE1);

background-repeat: repeat-x;

filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33BEFF', endColorstr='#018FE1', GradientType=0);

font-weight: bold;

border-color: #D3D3D3 #CFCFCF #C7C7C7;

border-image: none;

border-style: solid;

border-width: 1px;

box-shadow: 0 0 0.2em rgba(255, 255, 255, 0.3) inset, 0 0 0 #000000;

color: #FFFFFF;

text-shadow: none;

padding: 3px 15px;

width: 9em;

margin: 0px 0px 0px 38em;

}

.review_img

{

background: url(images/no-rating_star.png) repeat-x;

float: left;

height: 17px;

width: 86px;

}

.review_st

{

background: url(images/rating_star.png) repeat-x;

float: left;

height: 17px;

position: relative;

}

.right-review

{

float: right;

width: 80%;

}



.right-review li {

float: left;

width: 50%;

padding:0 0 0 30px;

border-bottom:none;

}

.right-review span {

color: #605f5f;

float: left;



font-size: 13px;

text-align: left;

width:100px;

}



.overlay{

background: rgba(0, 0, 0, 0.88);

display: none;

height: 100%;

position: fixed;

width: 100%;

top: 0;

z-index: 999;

opacity: 1;

}

.carousel-inner img{width:100%}

.bookedDate > span.ui-state-default {
	background-color: #752b7e !important;
    background-image :none !important;
    color: #ffffff !important;
}


#content {
  overflow: hidden; 
  height: 4em;
  line-height:23px;
  word-spacing: 2px;
}

</style>
<link rel="stylesheet" href="css/contact-host-pop-up.css" type="text/css" /> 

<link rel="stylesheet" href="css/jRating.jquery.css" type="text/css" /> 

<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="js/jquery-ui-1.8.12.custom.min.js"></script>

<script type="text/javascript" src="js/jquery.ui.stars.min.js"></script>

<link type="text/css" rel="stylesheet" href="css/jquery.ui.stars.min.css" />

<script src="js/jRating.jquery.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/jRating.jquery.css" type="text/css" /> 

<link rel="stylesheet" href="css/site/my-account.css" type="text/css" />

<script src="js/site/jquery-ui-1.8.18.custom.min.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/site/jquery-ui-1.8.18.custom.css" />
<!--
<script type="text/javascript">
$(window).on("scroll", function() {
    if($(window).scrollTop() > 50) {
        $(".header").addClass("active");
    } else {
        //remove the background property so it comes transparent again (defined in your css)
       $(".header").removeClass("active");
    }
});
</script>-->

<script type="text/javascript">
jQuery(document).ready( function () {
	initialize();
});

var array1 = <?php echo $forbiddenCheckIn; ?>;   
var array2 = <?php echo $forbiddenCheckOut; ?>;   
</script>

<?php if($product->calendar_checked == 'onetime') { ?>
<script type="text/javascript">
$(function() {
	var oneTimeMinY = '<?php echo date('Y', strtotime($product->datefrom));?>';
	var oneTimeMinM = '<?php echo date('m', strtotime($product->datefrom));?>';
	var oneTimeMinD = '<?php echo date('d', strtotime($product->datefrom));?>';
	var oneTimeMaxY = '<?php echo date('Y', strtotime($product->dateto));?>';
	var oneTimeMaxM = '<?php echo date('m', strtotime($product->dateto));?>';
	var oneTimeMaxD = '<?php echo date('d', strtotime($product->dateto));?>';
	var oneTimeMin = new Date(oneTimeMinY, oneTimeMinM -1, oneTimeMinD);
	
	var oneTimeMax = new Date(oneTimeMaxY, oneTimeMaxM, oneTimeMaxD);
	$( "#datefrom" ).datepicker({
		changeMonth: true,
		minDate: new Date(oneTimeMinY, oneTimeMinM -1, oneTimeMinD),
        maxDate: new Date(oneTimeMaxY, oneTimeMaxM -1, oneTimeMaxD),
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array1.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#expiredate" ).datepicker( "option", "minDate", selectedDate );
			$( "#expiredate" ).val('');
		}
	});
	
	$( "#expiredate" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate: new Date(oneTimeMinY, oneTimeMinM -1, oneTimeMinD),
        maxDate: new Date(oneTimeMaxY, oneTimeMaxM -1, oneTimeMaxD),
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array2.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{			
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#datefrom" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	$( "#datefromContact" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate: new Date(oneTimeMinY, oneTimeMinM -1, oneTimeMinD),
        maxDate: new Date(oneTimeMaxY, oneTimeMaxM -1, oneTimeMaxD),
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array1.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#expiredateContact" ).datepicker( "option", "minDate", selectedDate );
			$( "#expiredateContact" ).val('');
		}
	});
	
	$( "#expiredateContact" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate: new Date(oneTimeMinY, oneTimeMinM -1, oneTimeMinD),
        maxDate: new Date(oneTimeMaxY, oneTimeMaxM -1, oneTimeMaxD),
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array2.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{			
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#datefromContact" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<?php } else { ?>
<script type="text/javascript">
$(function() {
	$( "#datefrom" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate:0,
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array1.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{
					return [false, "bookedDate", "check"];
				}
			}

			
		},
		onClose: function( selectedDate ) {
			$( "#expiredate" ).datepicker( "option", "minDate", selectedDate );
			$( "#expiredate" ).val('');
		}
	});
	
	$( "#expiredate" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate:0,
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array2.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{			
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#datefrom" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	$( "#datefromContact" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate:0,
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array1.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#expiredateContact" ).datepicker( "option", "minDate", selectedDate );
			$( "#expiredateContact" ).val('');
		}
	});
	
	$( "#expiredateContact" ).datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		minDate:0,
		beforeShowDay: function(date){
			var string = $.datepicker.formatDate('yy-mm-dd', date);
			var check = array2.indexOf(string) == -1;
			if(typeof(check)!='undefined')
			{
				if(check)
				{
					return [true, '', ''];
				}
				else
				{			
					return [false, "bookedDate", "check"];
				}
			}
		},
		onClose: function( selectedDate ) {
			$( "#datefromContact" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<?php } ?>

<script type="text/javascript">
function hidefun(elem){
$(elem).hide();
}
</script>


<script type="text/javascript">
$(document).ready(function(){
	var yOffset = $(".animation-bar").offset().top;
	var yOffset1 = $(".map-section").offset().top-$(".animation-bar").innerHeight();
	$(window).scroll(function() {
		if ($(window).scrollTop() > yOffset && $(window).scrollTop() < yOffset1) 
		{
			$(".animation-bar").css({
				'position': 'fixed',
				'top': 7,
				'width': 354,
				'right':140
			});
		}
        else if($(window).scrollTop() > yOffset1)
        {
            $(".animation-bar").css({
                'position': 'inherit',
                'top': -41,
                'right': 0
            });
        }
		else {
			$(".animation-bar").css({
				'position': 'inherit',
                'top': -41,
                'width': 354,
                'right': 0
			});
		}
	});
}); 

$(document).ready(function() {
	$("#expiredate").click(function(){
		if($("#datefrom").val()=="")
			$("#datefrom").focus();
	});

	$("#expiredateContact").click(function(){
		if($("#datefromContact").val()=="")
			$("#datefromContact").focus();
	});

    var aboveHeight = $('detail-middle').outerHeight();

    var yOffset = $(".animation-bar").offset().top;

    var yOffset1 = $(".map-section").offset().top;

	var slideCount = $('#side_bar ul li').length;

    var slideWidth = $('#side_bar ul li').width();

    var slideHeight = $('#side_bar ul li').height();

    var sliderUlWidth = slideCount * slideWidth;

    $('#side_bar').css({ width: 940, height: 300 });

    $('#side_bar ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

    $('#side_bar ul li:last-child').prependTo('#side_bar ul');

    function moveLeft() {

        $('#side_bar ul').animate({

            left: + slideWidth

        }, 200, function () {

            $('#side_bar ul li:last-child').prependTo('#side_bar ul');

            $('#side_bar ul').css('left', '');

        });

    };

    function moveRight() {

        $('#side_bar ul').animate({

            left: - slideWidth

        }, 200, function () {

            $('#side_bar ul li:first-child').appendTo('#side_bar ul');

            $('#side_bar ul').css('left', '');

        });

    };

	$('a.control_prev').click(function () {

        moveLeft();

    });

    $('a.control_next').click(function () {

        moveRight();

    });

    $(window).scroll(function(){

		if ($(window).scrollTop() > yOffset){	

            $('#inner_fixed').addClass('fixed').css('display','block').next().css('padding-top','0px');

        } else {

            $('#inner_fixed').removeClass('fixed').css('display','none').next().css('padding-top','0');

        }

    });

	$(document).on("scroll", onScroll);

});

function onScroll(event){ 

    var scrollPos = $(document).scrollTop();

    $('.page-bar a').each(function () {

        var currLink = $(this);

        var refElement = $(currLink.attr("data-value"));

        if (refElement.position().top <= scrollPos+100 && refElement.position().top + refElement.height() > scrollPos+100) {

		$('.page-bar ul li a').removeClass("active");

			currLink.addClass("active");

        }

        else{

            currLink.removeClass("active");

        }

    });

}


function ViewAllReview(){

    $(".reviews-list-item").css("display","block");

    $("#ViewMore").css("display","none");

}

function displydesc(elem) {



document.getElementById('moredesc').style.display='block';

$(elem).hide();

}

function displydesc1(elem) {

document.getElementById('more_description').style.display='block';

$(elem).hide();

}

function displydesc2(elem) {

document.getElementById('desc').style.display='block';

$(elem).hide();

}

function displydesc3(elem) {

document.getElementById('descother').style.display='block';

$(elem).hide();

}

function displydesc4(elem) {

$('#deschome').css('display', 'block');

$(elem).hide();

}

function displydesc5(elem) {

$('.emore').css('display', 'block');

$(elem).hide();

}

function displydesc0(elem) {

$('.amore').css('display', 'block');

$(elem).hide();

}



<?php 



		if($listItems->num_rows()>0) {



			foreach($listItems->result() as $list){



		?>



		function displydesc11<?php echo $list->id;?>(elem) {



		$('.amore<?php echo $list->id;?>').css('display', 'block');



		$(elem).hide();



		}



		<?php 



		}



		}



		?>

function displydesc6(elem) {

$('.smore').css('display', 'block');

$(elem).hide();

}

function displydesc7(elem) {

$('.hmore').css('display', 'block');

$(elem).hide();

}



</script>







<section>



<?php 



     if($product->user_id!='' && $product->user_id!='0' ){

         $useId=base_url().'users/show/'.$product->user_id;

       }else{

         $useId='javascript:void(0);';

       }

?>
<div class="banner-container detail-pgaes">

    <div class="row">

        <div class="col-md-12" id="s2">

            <div id="carousel-example-generic" class="slide">              
                <ul class="carousel-inner">
				<?php 								
				//var_dump($productImages->result_array());die;
				//echo $productlist->product_image;
				$imgArr = $productImages->result_array();
				//echo (count($productImages->result_array()));
				if(count($imgArr)==0)

        {?> <div class="coverimg">

		          <li class="item active">

                   
				     <a href="javascript:void(0);"><img src="<?php if(strpos($imgArr[$i]['product_image'], 's3.amazonaws.com') > 1)echo $imgArr[$i]['product_image'];else echo base_url()."server/php/rental/".$imgArr[$i]['product_image']; ?>" data-gallery="first-gallery" alt=""/></a>

						 

						 <!--<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">

						<span class="left-ars"></span>

					</a>



                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">

						<span class="right-ars"></span>

					</a>-->

                        

                    </li>

		<?php }else {

		for($i=0;$i<count($imgArr);$i++) {
			
			?>

		           <li  class="item <?php if($i==0){?>active<?php }?>">

					    <a href="javascript:void(0);"><img src="<?php if(strpos($imgArr[$i]['product_image'], 's3.amazonaws.com') > 1)echo $imgArr[$i]['product_image'];else echo base_url()."server/php/rental/".$imgArr[$i]['product_image']; ?>" data-gallery="first-gallery" alt="" id="image-gal-<?php echo $imgArr[$i]['id'];?>"/></a>

						
					<?php 
					//print_r($imgArr);
					
					if(count($productImages->result_array())==1)
					//(count($productList->result()) > 0)
					{
						
						?>
						<!--<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev" >

						<span class="left-ars"></span>

					</a>



                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next" >

						<span class="right-ars"></span>

					</a>-->
					
					<?php } else{?>
					<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">

						<span class="left-ars"></span>

					</a>



                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">

						<span class="right-ars"></span>

					</a>
					<?php } ?>
                        

                    </li>

		<?php } }?>

		

					

                    

                    

                </div>

                

            </ul>

        </div>
        </div>
    </div>
</div>
         </div>
    </div>
</div>

<div id="push">

</div>

</section>

<section>

<div class="fized-hei-area">

    <div class="container" id="proddtl_contnr">

    

 <div id="inner_fixed" style="display:none;">

    			<div class="container">

	                <div class="top-page-bar">

	                        <ul class="page-bar">

							

							<li><a class="active" href="javascript:void(0);" data-value="#carousel-example-generic" onclick="scrollDiv('carousel-example-generic')"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>

							    <li><a href="javascript:void(0);" data-value="#about-listing-text" onclick="scrollDiv('about-listing-text')"><?php if($this->lang->line('about_listing') != '') { echo stripslashes($this->lang->line('about_listing')); } else echo "About this listing";?> </a></li>

							    <li><a href="javascript:void(0);" data-value="#reviews_list" onclick="scrollDiv('reviews_list')"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>

								<li><a href="javascript:void(0);" data-value="#host" onclick="scrollDiv('host')"><?php if($this->lang->line('the_host') != '') { echo stripslashes($this->lang->line('the_host')); } else echo "The Host";?></a></li>

							    <li><a href="javascript:void(0);" data-value="#location" onclick="scrollDiv('location')"><?php if($this->lang->line('list_Location') != '') { echo stripslashes($this->lang->line('list_Location')); } else echo "Location";?></a></li>

							</ul>

	                </div>

	                </div>

                </div>



<!--.......... .......... ..........place features....................-->

        <div class="detail-middle go_down">

            <div class="col-md-8 prod_detlcol8 ">

            <div class="listing-menu">

                
				
				
                 <div class="listing-menu-left">



                  <figure class="listing-pep"><a href="<?php echo $useId;?>" class="detail-topimg">
					
                  <img src="<?php if($product->loginUserType == 'google')echo $product->thumbnail;else if($product->thumbnail == '')echo base_url().'images/site/profile.png'; else echo 'images/users/'.$product->thumbnail; ?>">
				  
                  <span class="pep-name"><?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?></span>
				  </a>
				  </figure>



                 </div>
				
				
				<div class="listing-menu-right">

                    <ul class="listmenu-head">

                    <li> <h2 class="titled"><?php echo ucfirst($product->product_title); ?></h2></li>

                     <li class="numrstr"><a class="link-plce" href="<?php echo(($_SERVER['HTTPS'] ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>#map"><?php  echo $product->CityName.', '.$product->State_name.', '.$product->Country_name; ?></a>

                     

                     <?php if(count($reviewData->result_array()) >0){?>

                    

                    <label class="star">

                    <a href="<?php echo(($_SERVER['HTTPS'] ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>#reviews">

					<!--<img src="images/star.png">--></a>

                    <span class="review_img"><span class="review_st" style="width:<?php echo $reviewTotal->row()->tot_tot * 20?>%"></span></span></label>

                    <span class="nums">(<?php echo count($reviewData->result_array());?>)</span></li>

					<?php }?>

                    </ul>

                   







                    <table class="propety-feature">

                <?php if($product->home_type !='') {?>

                        <td>

                         <center><img src="images/slider/hom3.png" alt=""></center>

                         <span>
						 <?php
						 //echo ucfirst($product->home_type);
						 //ucfirst($product->home_type).'/'.
							echo ucfirst($listings_hometype);
						 ?></span>



                        </td>

                  <?php } if($product->accommodates !='') {
					  
					  $listingChild=$this->product_model->get_all_details(LISTING_CHILD,array('id'=>$product->accommodates));
					  $childNameDisplay=$listingChild->row()->child_name;
					  
					  
					  
					  ?>

                       <td>

                         <center><img src="images/slider/g3.png" alt=""></center>

                         <span><?php echo $childNameDisplay;?> <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></span>



                        </td>
					<?php 

					
					
							$finalsListing= json_decode($listings_values);
							//print_r($finalsListing);

							foreach($finalsListing as $listingResult => $FinalValues){
$valu='';
							$resultArr[$listingResult] = $FinalValues; 

							if(trim($FinalValues) != ''){

								$ind_val=$this->product_model->get_all_details(LISTING_CHILD,array('id'=>$FinalValues));
								$ind=$ind_val->row();
							
								if(!empty($ind)){
									$valu=$ind->child_name;
								}

							?>



							<?php if(strtolower($listingResult) == 'bedrooms'){?>
							<td>

							 <center><img src="images/slider/bed3.png" alt=""></center>

							 <span><?php echo stripslashes(ucfirst($valu)); ?> <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></span>



							</td>
							<?php } ?>
							
							<?php } } ?>

                    <?php } if($product->bedrooms !='') {?>



                       <!-- <li>

                         <i class="topsp spr3"></i>

                         <span><?php echo stripslashes($product->bedrooms); ?> <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></span>



                        </li>-->

                    <?php } if($product->beds !='') {?>



                         <!-- <li>

                         <i class="topsp spr4"></i>

                         <span><?php echo stripslashes($product->beds); ?> <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "beds";?></span>



                        </li>-->

                    <?php } if($product->bathrooms !='') {?>

						<!--<li>

                         <i class="topsp spr5"></i>

                         <span><?php echo stripslashes($product->bathrooms); ?> <?php if($this->lang->line('bathrooms') != '') { echo stripslashes($this->lang->line('bathrooms')); } else echo "bathrooms";?></span>



                        </li>-->

						<?php }?>
	

                     </table>  



                </div>

            </div>

			
			
			
			<div class="left-listg-container">

			

                <h2><a><?php if($this->lang->line('about_listing') != '') { echo stripslashes($this->lang->line('about_listing')); } else echo "About This Listing"; ?></a> </h2>

                <?php if($product->description !="") { ?>

				

				<div id="content">
	                <span class="info-area">
	                <?php echo nl2br(stripslashes($product->description)); ?>
	                </span>
				</div>
				
 <a href="javascript:void(0);" onclick ="document.getElementById('content').style.height='auto'; hidefun(this)" style="float: right;">
           <?php if($this->lang->line('read_more') != '') { echo stripslashes($this->lang->line('read_more')); } else echo "Read more"; ?>
 </a>
				
				
				
				

                <?php } ?>
			<?php if($product->video_url != ''){?>
			<iframe width="100%" height="350px" src="<?php echo $product->video_url;?>">
			</iframe>
			<?php }?>
			<article class="descri-section" id="ritespace_first">
                <span class="left-space"><?php if($this->lang->line('The_Space') != '') { echo stripslashes($this->lang->line('The_Space')); } else echo "The Space"; ?></span>
                <ul class="right-space">


						

							<?php if($product->bed_type !=''){?>

							

							<li>

								<span><?php if($this->lang->line('bed_type') != '') { echo stripslashes($this->lang->line('bed_type')); } else echo "Bed type";?></span>

								<label><?php echo  stripslashes(ucfirst($product->bed_type)); ?></label>

							</li> <?php } ?>

							

								<?php if($product->home_type !=''){?>

							<li>

								<span><?php if($this->lang->line('property_type') != '') { echo stripslashes($this->lang->line('property_type')); } else echo "Property type"; echo ":"; ?></span>

								<label><?php  
										$prop_type = $this->db->select('*')->from('fc_listspace_values')->where('id',$product->home_type)->get();
										echo $prop_type->row()->list_value;
								?></label>

							</li>

							<?php } if(trim($product->room_type)!= ''){ ?>

							<li>

								<span><?php if($this->lang->line('room_type') != '') { echo stripslashes($this->lang->line('room_type')); } else echo "Room type";  echo ":";?></span>

								<label><?php  
										$room_type = $this->db->select('*')->from('fc_listspace_values')->where('id',$product->room_type)->get();
										echo $room_type->row()->list_value;
								?></label>

							</li>

							

							<?php } if($product->noofbathrooms !=''){ ?>

							<li> 

								<span><?php if($this->lang->line('no_of_bathrooms') != '') { echo stripslashes($this->lang->line('no_of_bathrooms')); } else echo "Number of bathrooms";?></span>

								<label><?php if($product->noofbathrooms!=""){
									echo $product->noofbathrooms;
									}else { 
									echo "Nil"; 
									} ?></label>

							</li> <?php } ?>
							<?php 

							$finalsListing= json_decode($listings_values);
							

							foreach($finalsListing as $listingResult => $FinalValues)

							{
							

							$resultArr[$listingResult] = $FinalValues; 
							
						
								
							if(trim($FinalValues) != '')

							{

							?>



							<li>

								<span><?php //echo str_replace("_", " ", $listingResult); 
									//$list_type = $this->db->select('*')->from('fc_listing_types')->where('id',$listingResult)->get();
									
									$list_type = $this->db->select('*')->from('fc_listing_types')->where('name',$listingResult)->get();
									echo str_replace("_", " ", $list_type->row()->name);
									
								?>:</span>

								<label><?php //echo stripslashes(ucfirst($FinalValues)); 
								
								$list_type_value = $this->db->select('*')->from('fc_listing_child')->where('id',$FinalValues)->get();
								
								if($list_type_value->row()->child_name!=""){
								echo stripslashes(ucfirst($list_type_value->row()->child_name));	
								}else{
									echo stripslashes(ucfirst($FinalValues)); 
								}
								
								
								
								
								?></label>

							</li>

							<?php } } ?>


                </ul>
                <label>
            </article> 

<?php 

		$main=0;

		if($listItems->num_rows()>0) {

		$sub_list=explode(',',$product->list_name);

		//echo '<pre>';print_r($sub_list);die;

			foreach($listItems->result() as $list){

				$list_name = $listDetail->row()->list_name;

				$facility = (explode(",", $list_name));
				$listValues = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$list->id));

				//echo "<pre>"; print_r($listValues->result_array());

				if($listValues->num_rows()>0){

					$mcount = 0;					

					foreach($listValues->result() as $details){
						$key=$details->id;

						if(in_array($key,$sub_list)){
							$arrayAvailable[] = $details;
						}else{

							$arrayNotAvailable[] = $details;
						}
					}

					$newAmenities = array_merge($arrayAvailable, $arrayNotAvailable);
						
					$ds='';
					$exist=0;
					if(!empty($newAmenities)){
		
						//echo "<pre>"; print_r($newAmenities); 
						$ds='';
						foreach($newAmenities as $details){

							$key=$details->id;
							if(in_array($key,$sub_list)){
						
								if($mcount>4){ if(!in_array($key,$sub_list)){ $v_d='style="display:none;"'; } else { $v_d='class="amore'.$list->id.'" style="display:none;" '; } }

								$ds.='<li'.$v_d.' >';
								if($details->image != '') { 

									$ds.='<span class="amimg"><img src="images/attribute/'.$details->image.'" style="height:20px;width:20px;float:left;"/></span>';
								
								}else{
									 
									$ds.='<span class="amimg"><img src="images/attribute/default1.png" style="height:25px;width:25px;float:left;"/></span>';
								
								} 
								$ds.='<label>'.$details->list_value.'</label>';
								
								$ds.='</li>';
								$exist++;
							}

						$mcount++;

						}
						//$ds;
						
						$newAmenities = array();

						$arrayAvailable = array();

						$arrayNotAvailable = array();

						if($exist>0){

						?>

							<article class="descri-section new-line">

								<label class="ful-lent">

								<span class="left-space"><?php echo $list->attribute_name; ?></span>

								<ul class="right-space amenities-type">

								<?php
									echo $ds;
									//echo $exist;

								?>
								<?php if($listValues->num_rows > 5){ ?>

									<a class="moretag" href="javascript:void(0);" onclick="displydesc11<?php echo $list->id;?> (this)" style="float:right;">+ <?php if($this->lang->line('more') != '') { echo stripslashes($this->lang->line('more')); } else echo "more";?></a>

								<?php } ?>

									</ul>

									</label>
									
							</article>


								<?php 
						}	
					}

				}

			}

		}

					?>

		  

				<?php  if($product->price_perweek=='0.00') { 

						   $chkval=0;

						   }

						   

						 ?>

			

			<?php  //if($chkval!=0) {  ?>

			

               <label class="ful-lent new-line">

                <span class="left-space"><?php if($this->lang->line('prices') != '') { echo stripslashes($this->lang->line('prices')); } else echo "Prices";?></span>



                   <ul class="right-space">

                    <li class="exttra-area">

                       <ul class="extra-type">

                         
<!--
						 

						 <?php //if($product->price_perweek===0.00) { 

						   //$weekprice=0;

						  // }

						   //else {

						  //$weekprice =$product->price_perweek;

						   //}

						 ?>

						 <?php //if($weekprice!=0) { ?>

						 <li><span><?php //if($this->lang->line('header_country') != '') { echo stripslashes("Weekly"); } else echo "Weekly";?></span><label><?php //echo $this->session->userdata('currency_s'); echo $this->session->userdata('currency_r')*$product->price_perweek; ?></label></li>

						 <?php //} ?>

						



						<?php 

						        //if($product->price_permonth==0.00) { 

						          //$monthlypriece=0;

						        //}else {

						          //$monthlypriece =$product->price_permonth;

						        //}

						 ?>

						 

						 <?php //if($monthlypriece!=0) { ?>

                                  <li> <span><?php //if($this->lang->line('header_city') != '') { echo stripslashes("Monthly"); } else echo "Monthly";?> </span><label> <?php //echo $this->session->userdata('currency_s'); echo $this->session->userdata('currency_r')*$product->price_permonth; ?></label></li>

                          

						 <?php //} ?>

						 
-->
						 <?php if($product->cancellation_policy!='') { ?>

                         <li> <span><?php if($this->lang->line('Cancellation Policy') != '') { echo stripslashes($this->lang->line('Cancellation Policy')); } else echo "Cancellation Policy";?>: </span><label> 

						 <a href="<?php echo base_url();?>pages/cancellation-policy"><?php echo ucfirst($product->cancellation_policy); ?></a></label></li>

                          

						 <?php } ?>
						<?php if($product->cancel_percentage!='') { ?>

                         <li> <span><?php if($this->lang->line('Cancellation Percentage') != '') { echo stripslashes($this->lang->line('Cancellation Percentage')); } else echo "Cancellation Percentage";?>: </span><label> 

						 <a href="<?php echo base_url();?>pages/cancellation-policy"><?php echo ucfirst($product->cancel_percentage); ?>%</a></label></li>

                          

						 <?php } ?>
						   

						 <?php if($product->security_deposit!='') { ?>

                         <li> <span>

						 <?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit";?>: </span><label> 

						 

					<?php  echo $currencySymbol;?>
					<?php
                      if($product->currency != $this->session->userdata('currency_type'))
                      {
                     echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$product->security_deposit);
                     }
                     else{
                     	 echo $product->security_deposit;
                     }
                     ?><?php echo $this->session->userdata('currency_type');?></label>


						

						 </li>

                          

						   <?php } ?>

			

			

                        </ul>

                    </li>



                   



                </ul>

            </label>

			

			<?php //} ?>

			

			

            </article>  



				<?php 

				if($product->space != ""){

				?>

                <article class="descri-section">

                       <label class="ful-lent">

                <span class="left-space newspace"><?php if($this->lang->line('list_Description') != '') { echo stripslashes($this->lang->line('list_Description')); } else echo "Description";?></span>



                 <div class="right-space space-descri-area">

                   

                   <h3 style="font-weight:bold;">

				   <?php if($this->lang->line('the_space') != '') { echo stripslashes($this->lang->line('the_space')); } else echo "The Space";?>
		   
<!--				   <?php //echo $product->product_title; ?> -->
				   </h3>
				   <p>

				   <?php $space= stripslashes($product->space);

				   

					$lengh=strlen($space);

				    $string  = $space;

					$needle = '.';

					$nth = '2';

					$max = strlen($string);

					$n = 0;

					for($i=0;$i<$max;$i++)

					{

						if($string[$i]==$needle)

						{

							$n++;

							if($n>=$nth)

							{

								break;

							}

						}

					}			

					$pos = $i+1;

					

					$string = substr($space, 0, $pos);

					echo nl2br(stripslashes($string));

	

	

	

	

	

                        //echo substr($space,0,139);?></p>

                        <span id="desc" style="display:none;"><p style="align:justify;"><?php echo nl2br(stripslashes(substr($space, $pos)));?></p>
						
						<p>

						<?php if($product->other_thingnote!=''){?>

						<h3 style="font-weight:bold;"><?php if($this->lang->line('other_things_to_note') != '') { echo stripslashes($this->lang->line('other_things_to_note')); } else echo "Other things to note";?>

				  </h3>

						<p style="align:justify;"><?php echo nl2br(stripslashes($product->other_thingnote));?></p>

						<?php }?>

						</span>

                      <?php 

                        {?>

                        <a class="moretag" href="javascript:void(0);" onclick="displydesc2(this)" style="float:right;">+ <?php if($this->lang->line('more') != '') { echo stripslashes($this->lang->line('more')); } else echo "more";?></a>

                        <?php } ?>

				   <br />

				   </div>   

            </label>

                </article> 

				<?php }?>

				

					

				

				

				

				

				

          

                 <?php if($product->house_rules!='') { ?>  

                 <article class="descri-section" >

				  <label class="ful-lent">

                 <span class="left-space"><?php if($this->lang->line('house_rules') != '') { echo stripslashes($this->lang->line('house_rules')); } else echo "House Rules";?></span>

                 <div class="right-space space-descri-area">

                 <p style="align:justify;">

				  <?php $home= stripslashes($product->house_rules);

				  

				  

				  $string  = $home;

					$needle = '.';

					$nth = '2';

					$max = strlen($string);

					$n = 0;

					for($i=0;$i<$max;$i++)

					{

						if($string[$i]==$needle)

						{

							$n++;

							if($n>=$nth)

							{

								break;

							}

						}

					}			

					$pos = $i+1;

					

					

                        echo nl2br(substr($home,0,$pos));

                        echo '<span id="deschome" style="display:none;">'.nl2br(substr($home,$pos)).'</span>';?></p>

                      <?php 

                        $home=strlen($home);

                        if($home>$pos){?>

                        <a class="moretag" href="javascript:void(0);" onclick="displydesc4(this)" style="float:right;">+ <?php if($this->lang->line('more') != '') { echo stripslashes($this->lang->line('more')); } else echo "more";?></a>

                        <?php } ?>

				   

                 

				 </label>

                 </div>

                 </article>  



                <?php } ?>  

				<?php if($this->lang->line('night') != '') 
				{ 
					$Night = stripslashes($this->lang->line('night')); 
				} 
				else 
				{
					$Night = "Night";
				}
				if($this->lang->line('Nights') != '') 
				{ 
					$Nights = stripslashes($this->lang->line('Nights')); 
				} 
				else 
				{
					$Nights = "Nights";
				}?>
				<?php if($product->guest_access !="" ){?>
				<section class="descri-section">
					<span class="left-space">Guest access</span>
					<div class="right-space space-descri-area">
						<?php echo $product->guest_access; ?>
					</div>
				</section>
				<?php } ?>
				<?php if($product->interact_guest !="" ){?>
				<section class="descri-section">
					<span class="left-space">Interaction with guest</span>
					<div class="right-space space-descri-area">
						<?php echo $product->interact_guest; ?>
					</div>
				</section>
				<?php } ?><?php if($product->neighbor_overview !="" ){?>
				<section class="descri-section">
					<span class="left-space">Neighborhood</span>
					<div class="right-space space-descri-area">
						<?php echo $product->neighbor_overview; ?>
					</div>
				</section>
				<?php } ?>
                <article class="descri-section">

                <span class="left-space"><?php if($this->lang->line('availability') != '') { echo stripslashes($this->lang->line('availability')); } else echo "Availability";?></span>

                <div class="right-space space-descri-area">

                <?php if($product->minimum_stay !=0 ){
					$valu='';
					if(trim($product->minimum_stay) != ''){

								$ind_val=$this->product_model->get_all_details(LISTING_CHILD,array('id'=>$product->minimum_stay));
								$ind=$ind_val->row();
							
								if(!empty($ind)){
									$valu=$ind->child_name;
								}
					}
					
					?>

                <ul><li class="minstwy"><span><?php if($this->lang->line('min_stay') != '') { echo stripslashes($this->lang->line('min_stay')); } else echo "Minimum Stay";?>:</span> <label> <?php echo $valu." "; if($product->minimum_stay==1){echo $Night;}else {echo $Nights;}?></label></li>

                <?php }?><li>
					<!--<a class="viwe-text" href="javascript:void(0);" onclick="productImage_Calendar()"><?php if($this->lang->line('view_calendar') != '') { echo stripslashes($this->lang->line('view_calendar')); } else echo "View Calendar";?></a>-->
					<a class="viwe-text" href="javascript:void(0);" id="datepicker_view"><?php if($this->lang->line('view_calendar') != '') { echo stripslashes($this->lang->line('view_calendar')); } else echo "View Calendar";?></a>
				</li></ul>

                </div>								            
            </ul>
			

                </article>  
				<?php $imgArr = $productImages->result_array();
				if(count($imgArr)!=0){ ?>
				<article class="descri-section" id="s1">
					<div id="" class="slide multiCarousel">              
						<ul>
							<?php
							$count = count($imgArr);
							for($i=0;$i<$count;$i++) { ?>
							
							<li class="item <?php if($count == 1)echo "col-md-12";?><?php if($count > 1 && $i == 0)echo "col-md-9";?><?php if($count > 1 && $i > 0)echo "col-md-3";?>">
								<?php if($i == 6){
									?><a  href="javascript:void(0);" style="float: left; position: relative;" onclick="clickImage(<?php echo $imgArr[0]['id'];?>);"><img  style="position: relative; width: 100%;" src="<?php if(strpos($imgArr[$i]['product_image'], 's3.amazonaws.com') > 1)echo $imgArr[$i]['product_image'];else echo base_url()."server/php/rental/".$imgArr[$i]['product_image']; ?>"  alt=""/><span class="moreImages"><?php if($this->lang->line('See_all') != '') { echo stripslashes($this->lang->line('See_all')); } else echo "See all";?> <?php echo $count;?> <?php if($this->lang->line('Photos') != '') { echo stripslashes($this->lang->line('Photos')); } else echo "Photos";?></span></a><?php
									break;
								} else {?>
									<a  href="javascript:void(0);" onclick="clickImage(<?php echo $imgArr[$i]['id'];?>);"><img  style="position: relative; width: 100%;" src="<?php if(strpos($imgArr[$i]['product_image'], 's3.amazonaws.com') > 1)echo $imgArr[$i]['product_image'];else echo base_url()."server/php/rental/".$imgArr[$i]['product_image']; ?>"  alt=""/></a>
								<?php }?>
							</li>

							<?php }?>
						</ul>
					</div>
				</article>  
				<?php } ?>
</div>
			
			


            </div>

<!--......... .......... ..........place features....................-->



<!--......... .......... .......... FOR EMPTY SPACE....................-->





             <div class="col-md-4 prod_detlcol4 cm_dwn_anibox">

             <div class="animation-bar">

			 <div class="animation-container">

                <div class="top-title">

                    <span class="title"> <?php  echo $currencySymbol; ?><?php
                      if($product->currency != $this->session->userdata('currency_type'))
                     {
						 
                     echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$product->price);
					
                   
					 	
                     }
					 
					 
                     else{
						 
						 
						 
                     	// echo $product->price;
						
						
                     	 $price=  $product->price;
						 echo number_format($price,2);
						 
						 
                     }
                     ?>
                 <?php echo $this->session->userdata('currency_type');?>
                	
					<input type="hidden" value="<?php echo $this->session->userdata('currency_type'); ?>" name="user_currencyCode" id="user_currencyCode">
					
                </span> <span class="price-descri"><?php if($this->lang->line('per_night') != '') { echo stripslashes($this->lang->line('per_night')); } else echo "per night"; ?></span>

                </div>

                <?php
               // if($product->host_status!='1' && $product->host_login_status!='Inactive'){
                 ?>


	                <ul class="coupon-detail">

	                	<?php

						/* malar - 11/07/2017 - coupon code display */
						$cur_date = date('Y-m-d');
						$couponQ = "select c.* from ".COUPONCARDS. " c  where  ('".$cur_date."' between c.datefrom and c.dateto or (c.dateto ='".$cur_date."') or (c.datefrom ='".$cur_date."')  ) and status='Active' ";

						$couponData = $this->user_model->ExecuteQuery($couponQ);
						//echo $this->db->last_query();exit;
						//print_r($this->data['couponData']->result());

						
						?>
						<?php $productAr = explode(',', $couponData->row()->product_id);  
						//print_r( $productAr) ;
						if($couponData->num_rows()>0) { 
							?>
							
							<?php
							$count=0;
							$coupon_result='';
							foreach ($couponData->result() as $coupon) {
								
							
								$productAr = explode(',', $coupon->product_id);
								if(in_array($this->uri->segment(2), $productAr)){
									$type = $coupon->price_type !=1 ?'%':'flat';
									$count++;
									
									$qty=$coupon->quantity;
									$purchaseCount=$coupon->purchase_count;
									$remining=$qty-$purchaseCount;
									
						?>
			                	<?php
								
								//$couponPrice=$coupon->price_value;
								if ($coupon->price_type==1){
								$couponPrice= convertCurrency("USD",$this->session->userdata('currency_type'),$coupon->price_value);
								}else{
									$couponPrice=$coupon->price_value;
								}
								
								
								
				                	$coupon_result .='<div class="coupon-info"><label>Code</label><span>'.$coupon->code.' ('.$couponPrice.' '.$type.')'.'</span></div><div class="coupon-info"><label>Time limit</label> <span>'. $coupon->datefrom .' to '.$coupon->dateto.'</span></div>';
								?>

	                	<?php 		}
	                	 		} 
								if($count!=0)
									echo '<h4>Available coupon </h4><div class="coupon-result">'.$coupon_result.'</div>';
	                		}

	                		?>
	                	</ul>
	                	<?php 
	                	/* malar - 11/07/2017 - coupon code display ends */
	                	?>
	                	<ul class="chekin-list">	
						<div class="chekin-list-inner">
	                    <li>

	                        <label><?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "check in"; ?></label>

	                        

	              <?php if($loginCheck==''){?>

	              <!--input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" autocomplete="off"   class="login-popup" id="datefromCheck"  value="" /-->
				  <input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" autocomplete="off" name="datefrom" readonly="readonly" style="cursor:pointer;"  id="datefrom" class="checkin ui-datepicker-target"  value="<?php if($this->session->userdata('searchFrom') != '') echo $this->session->userdata('searchFrom'); if($this->session->userdata('datefrom')!='') echo $this->session->userdata('datefrom');?>" />
	              <?php }else{ ?>

	              <input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" autocomplete="off" name="datefrom" readonly="readonly" style="cursor:pointer;"  id="datefrom" class="checkin ui-datepicker-target"  value="<?php if($this->session->userdata('searchFrom') != '') echo $this->session->userdata('searchFrom'); if($this->session->userdata('datefrom')!='') echo $this->session->userdata('datefrom');?>" />

	              <?php } ?>  

	                        

	                    </li>



	                    <li>

	                        <label><?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "check out"; ?></label>

							<?php if($loginCheck==''){?>

	              <!--input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" autocomplete="off" class="login-popup" id="expiredateCheck" value="" /-->
				  <input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" name="expiredate" autocomplete="off" readonly="readonly" style="cursor:pointer;"  id="expiredate" onchange="DateBetween();" class="checkout ui-datepicker-target" value="<?php if($this->session->userdata('searchTo') != '') echo $this->session->userdata('searchTo'); if($this->session->userdata('expiredate')!='') echo $this->session->userdata('expiredate'); ?>">
	              <?php }else{ ?>

	                        <input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" name="expiredate" autocomplete="off" readonly="readonly" style="cursor:pointer;"  id="expiredate" onchange="DateBetween();" class="checkout ui-datepicker-target" value="<?php if($this->session->userdata('searchTo') != '') echo $this->session->userdata('searchTo');  if($this->session->userdata('expiredate')!='') echo $this->session->userdata('expiredate'); ?>">
						<?php } ?>  

	                    </li>



	                     <li>

	                        <label><?php if($this->lang->line('Guest') != '') { echo stripslashes($this->lang->line('Guest')); } else echo "Guest"; ?></label>

	                         <select id="number_of_guests" name="number_of_guests" onchange="myfunction(this.value);">

						   <?php for($i=1;$i<=$childNameDrop;$i++){ ?>
						   <option <?php if($this->session->userdata('searchGuest') != '') 
					  if($this->session->userdata('searchGuest') == $i ) echo "selected"; if($this->session->userdata('number_of_guests')==$i) echo "selected";?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
						   <?php } ?>

							</select>

	                    </li>
					</div>
	                </ul>



	              <!--  <div id="price_div">
					<div class="submit-link" style="cursor:pointer;">
						<a <?php //if($loginCheck==''){ ?> class="login-popup booking-btn" <?php //} else { ?>  class="booking-btn" onclick="return BookingIt_new();" href="javascript:void(0);" <?php //} ?> ><?php //if($this->lang->line('book_now') != '') { echo stripslashes($this->lang->line('book_now')); } else echo "Request to Book"; ?></a>
					</div>	
					</div>-->
	
<!--	
<div id="price_div">
<?php //if ($pay_option->row()->pay_option == 'Request to book' ) { ?> 				
<div class="submit-link" style="cursor:pointer;">
<a <?php //if($loginCheck==''){ ?> class="login-popup booking-btn" <?php //} 
//else { ?>  class="booking-btn" onclick="return  BookingIt_new();" href="javascript:void(0);" <?php //} ?> >
<?php //if($this->lang->line('book_now') != '') { echo stripslashes($this->lang->line('book_now')); } else echo "Request to Book"; ?></a>
</div>	
<?php //} else { ?>

<div class="submit-link" style="cursor:pointer;">
<a <?php //if($loginCheck==''){ ?> class="login-popup booking-btn" <?php //} 
//else { ?>  class="booking-btn" onclick="return  BookingIt_new();" href="javascript:void(0);" <?php //} ?> >
<?php //if($this->lang->line('instant_pay') != '') { echo stripslashes($this->lang->line('instant_pay')); } else echo "Instant Pay"; ?></a>
</div>
<?php //} ?>	
</div>Old Instant Pay-->

<?php 
//echo $productlist->id_verified;

if($productlist->id_verified=="No"){
	$show_book='style="display:none;"';	 
}else{ 
	$show_book='';	 
} ?>

					
<div id="price_div" <?php echo $show_book; ?>>	
<?php  if($this->session->userdata('datefrom')!="" && $this->session->userdata('expiredate')!="" && $this->session->userdata('number_of_guests')!=""	) { ?>
<script type="text/javascript">	
jQuery(document).ready( function () {
DateBetween();
});
</script>
<?php } ?>
</div>					

<?php 

if ($pay_option->row()->request_to_book == 'Yes' &&  $pay_option->row()->instant_pay  == 'Yes' ) { ?>
<div class="submit-link" style="cursor:pointer;">
<a <?php if($loginCheck==''){ ?> class="login-popup booking-btn" <?php } 
else { ?>  class="booking-btn" onclick="return  BookingIt_new('book_now');" href="javascript:void(0);" <?php } ?> >
<?php if($this->lang->line('book_now') != '') { echo stripslashes($this->lang->line('book_now')); } else echo "Request to Book"; ?></a>
</div>	
<br>
<div class="submit-link" style="cursor:pointer;">
<a <?php if($loginCheck==''){ ?> class="login-popup booking-btn" <?php } 
else { ?>  class="booking-btn" onclick="return  BookingIt_new('instant_pay');" href="javascript:void(0);" <?php } ?> >
<?php if($this->lang->line('instant_pay') != '') { echo stripslashes($this->lang->line('instant_pay')); } else echo "Instant Pay"; ?></a>
</div>

<?php } else if ($pay_option->row()->instant_pay  == 'Yes'){ ?>

<div class="submit-link" style="cursor:pointer;">
<a <?php if($loginCheck==''){ ?> class="login-popup booking-btn" <?php } 
else { ?>  class="booking-btn" onclick="return  BookingIt_new('instant_pay');" href="javascript:void(0);" <?php } ?> >
<?php if($this->lang->line('instant_pay') != '') { echo stripslashes($this->lang->line('instant_pay')); } else echo "Instant Pay"; ?></a>
</div>

<?php } else if ($pay_option->row()->request_to_book == 'Yes' ){ ?>
<div class="submit-link" style="cursor:pointer;">
<a <?php if($loginCheck==''){ ?> class="login-popup booking-btn" <?php } 
else { ?>  class="booking-btn" onclick="return  BookingIt_new('book_now');" href="javascript:void(0);" <?php } ?> >
<?php if($this->lang->line('book_now') != '') { echo stripslashes($this->lang->line('book_now')); } else echo "Request to Book"; ?></a>
</div>	
<?php }
?>		
		
				<?php 
				/*}else {
					echo "<label><br><br>Sorry, the host is currently not available ,so you are enable to book the property.</label>";
				}*/
				?>	

				<div class="submit-link-bottom">
                <?php  if (! in_array($product->id, $newArr)){   ?>

                 <div class="heart-list">

                    

                    <?php if($loginCheck!=''){?>

                    <a class="ajax cboxElement" href="site/rentals/AddWishListForm/<?php echo $product->id;?>" style="pointer:cursor"><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Save to Wish List"; ?></a>

                    <?php } else {?>

                    <a  class="login-popup ajax cboxElement" href="site/rentals/AddWishListForm/<?php echo $product->id;?>" style="pointer:cursor"><i class="fa fa-heart-o colsds"></i><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Save to Wish List"; ?></a>

                    <?php }?>

                    </div>
                <?php  } ?>
                    

                     <div class="save-wishlist">



                   





                    <div class="fb-sect">



                         <label><?php if($this->lang->line('share') != '') { echo stripslashes($this->lang->line('share')); } else echo "share"; ?>:</label>



                         <ul class="fbids">

                         <?php 

                         $description=$product->space;

                         $url=base_url().'rental/'.$product->id;

                         

                         $url=urlencode($url);

                         //echo $url;die;

                         $facebook_share='http://www.facebook.com/sharer.php?u='.$url;

                         //$google_plus_share='https://accounts.google.com/share?url='.$url;

                         $twitter_share='https://twitter.com/share?url="'.$url.'"';?>

                           <li><a class="fba1" target="_blank" href="<?php echo $facebook_share;?>"><i class="fa fa-facebook"></i></a></li>

                            <!--<li><a class="fba2" target="_blank" href="<?php echo $google_plus_share;?>"></a></li>-->

                             <!--<li><a class="fba3" target="_blank" href="<?php echo $this->config->item('pinterest');?>"></a></li>-->

                             <li><a class="fba4" target="_blank" href="<?php echo $twitter_share;?>"><i class="fa fa-twitter"></i></a></li>

                             <li><a class="fba2" href="https://plus.google.com/share?url={<?php echo $url; ?>}" onclick="javascript:window.open(this.href,

  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a></li>

                        </ul>

                         

                    </div>


                </div>



				

				

				

				

				</div>

				

             




                    

                </div>

             

			 </div>













            </div>

<!--......... .......... .......... FOR EMPTY SPACE....................-->



        </div>

    </div>

	</div>

<div id="listing"></div>

</section>

<section>



    <div class="about-listing">

        <div class="container" id="about-listing-text">

           


<?php

	$protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");

    $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];

	$complete_url =   $base_url . $_SERVER["REQUEST_URI"];

	?>

             

        </div>





    </div>



</section>

<section>



<!-- 

<?php 

if($loginCheck!=''){

if($product->user_id!=$userDetails->row()->id){

if(count($user_reviewData->result_array()) == ''){

?>

<a class="btn-create create-button" href="javascript:void(0);" onclick="addreview(this);" ><?php echo "Write a Review"; ?></a>

<?php }}} else if($loginCheck==''){?>

 <a class="login-popup ajax cboxElement btn-create create-button" href="javascript:void(0);" style="pointer:cursor"><?php echo "Write a Review"; ?></a>

 <?php }?>

-->

 

<?php

if($user_reviewData !='')

{

$total_review = count($reviewData->result_array()) + count($user_reviewData->result_array());

}

else{

$total_review = count($reviewData->result_array());

}

?>

<div class="floats-type">

<div class="container" id="reviews_list">

<div class="riwiew-container" id="reviews">

<div id=""></div>
<h2 class="abt-host-text"><?php if($this->lang->line('Property Reviews') != '') { echo stripslashes($this->lang->line('Property Reviews')); } else echo "Property Reviews";?>
 </h2>
<?php if($total_review == 0){?>

<div class="reviw-not-show">

<h4 class="row-revw-yet"><?php if($this->lang->line('no_review_msg') != '') { echo stripslashes($this->lang->line('no_review_msg')); } else echo "No Reviews Yet";?>  </h4>

<p> <?php if($this->lang->line('review_msg_to_review') != '') { echo stripslashes($this->lang->line('review_msg_to_review')); } else echo "Stay here and you could give this host their first review! ";?></p>

</div>

<?php  }else { ?>

<div class="reviw-count">

<span class="bottom-review-count"><?php echo $total_review;?> <?php if($this->lang->line('review') != '') { echo stripslashes($this->lang->line('review')); } else echo "Review";?></span><span class="review_img"><span class="review_st" style="width:<?php echo $reviewTotal->row()->tot_tot * 20?>%"></span></span>

</div>

<div class="review-summary">

<span class="summar-text"><?php if($this->lang->line('Summary') != '') { echo stripslashes($this->lang->line('Summary')); } else echo "Summary";?></span>

<?php }?>

<ul class="list-paging">

<?php if($user_reviewData !=''){foreach($user_reviewData->result_array() as $review ): ?>

<li>

<div class="peps">

<figure class="peps-area">

<img src="<?php if($review['image'] == '')echo base_url().'images/site/profile.png'; else echo 'images/users/'.$review['image']; ?>">

</figure>



<span class="johns"><b><?php echo $review['firstname']?></b></span>

</div>



<div class="listd-right">

<p><?php echo $review['review']; ?></p>
<?php if($review['owner_reply'] != '') {?><a href="javascript:void(0);" style="float:right;" onClick="toggle_visibility(<?php echo $review['id'];?>);"><?php if($this->lang->line('view_reply') != '') { echo stripslashes($this->lang->line(view_reply)); } else echo "View Reply";?></a></br>

<p style="display:none; padding:12px;color:blue;" id="reply_<?php echo $review['id'];?>"><?php echo $review['owner_reply'];?></p>



<?php }?>

<label class="date-year"><?php echo date('F Y',strtotime($review['dateAdded']));?></label>

</div>


</li>

<?php endforeach;}?>

<?php foreach( $reviewData->result_array() as $review ):?>

<li>

<div class="peps">

<figure class="peps-area">

<img src="<?php if($review['image'] == '')echo base_url().'images/site/profile.png'; else echo 'images/users/'.$review['image']; ?>">

</figure>



<span class="johns"><?php echo $review['firstname'];?></span>

</div>

<div class="listd-right">

<p><?php echo $review['review'];?></p>

<?php if($review['owner_reply'] != '') {?><a href="javascript:void(0);" style="float:right;" onClick="toggle_visibility(<?php echo $review['id'];?>);"><?php if($this->lang->line('view_reply') != '') { echo stripslashes($this->lang->line('view_reply')); } else echo "View Reply";?></a></br>

<p style="display:none; padding:12px;color:blue;" id="reply_<?php echo $review['id'];?>"><?php echo $review['owner_reply'];?></p>


<?php }?>

<label class="date-year"><?php echo date('F Y',strtotime($review['dateAdded']));?></label>

</div>

</li>

<?php endforeach;?>

</ul>

</div>

</div>





<script type="text/javascript">



    function toggle_visibility(id) {

       var e = document.getElementById('reply_'+id);

       if(e.style.display == 'block')

          e.style.display = 'none';

       else

          e.style.display = 'block';

    }



</script>



<!---------end review ------------>



</div>

</div>

</section>

<div id="add_review" style="display:none; margin:2em 0px 0px 8em;">

<?php if($loginCheck !=''){ echo form_open('site/product/add_review',array('id'=>'reviewForm'));?>

<input type="hidden" name="proid" value="<?php echo $product->id;?>" />

<input type="hidden" name="user_id" value="<?php echo $product->user_id; ?>" />



<label><?php if($this->lang->line('my_review') != '') { echo stripslashes($this->lang->line('my_review')); } else echo "My review";?><span>*</span>

<span style="font-size:12px; color:#666;"> <?php if($this->lang->line('my_review_instruction') != '') { echo stripslashes($this->lang->line('my_review_instruction')); } else echo "(Exclude personally identifiable information such as name, email address, etc)";?></span></label>

<textarea  name="review" id="review" class="scroll_newdes" style="height:90px;" onkeypress="return IsEmpty('title');"></textarea>

<div id="review_warn"  style="float:left; color:#FF0000;"></div>

<div class="clear"></div>

<input type="hidden" name="accuracy" id="r1"/>

<input type="hidden" name="communication" id="r2"/>

<input type="hidden" name="cleanliness" id="r3"/>

<input type="hidden" name="location" id="r4"/>

<input type="hidden" name="checkin" id="r5"/>

<input type="hidden" name="value" id="r6"/>

<input type="hidden" name="total_review" id="r7" value=""/>



<div class="star_rating">

<?php if($this->lang->line('accuracy') != '') { echo stripslashes($this->lang->line('accuracy')); } else echo "Accuracy";?><div class="exemple5" data-id="r1" data="10_5"  style="width:60%;  margin:-1em 0em 7px 8em "></div>

<?php if($this->lang->line('communication') != '') { echo stripslashes($this->lang->line('communication')); } else echo "Communication";?><div class="exemple5" data-id="r2" data="10_5"  style="width:60%;  margin:-1em 0em 7px 8em "></div>

<?php if($this->lang->line('pdetail_cleanliness') != '') { echo stripslashes($this->lang->line('pdetail_cleanliness')); } else echo "cleanliness";?><div class="exemple5" data-id="r3" data="10_5"  style="width:60%;  margin:-1em 0em 7px 8em "></div>

<?php if($this->lang->line('location') != '') { echo stripslashes($this->lang->line('location')); } else echo "Location";?><div class="exemple5" data-id="r4" data="10_5"  style="width:60%;  margin:-1em 0em 7px 8em "></div>

<?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "check in";?><div class="exemple5" data-id="r5" data="10_5"  style="width:60%;  margin:-1em 0em 7px 8em "></div>

<?php if($this->lang->line('value') != '') { echo stripslashes($this->lang->line('value')); } else echo "value";?><div class="exemple5" data-id="r6" data="10_5"  style="width:60%;  margin:-1em 0em 7px 8em "></div>

</div>





<div class="field_login" style=" margin-top:10px;">

  <input type="hidden" name="reviewer_id" value="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" />

  <input type="hidden" name="thumbnail" value="<?php if($userDetails!='no') { echo $userDetails->row()->image; }?>" />

  <input type="button" name="Review" id="Review" onClick="add_review()" class="form_sub" value="Submit my review">

</div>

<?php echo form_close();}?>

</div>



<section>



<div class="about-titl" >

<div class="container" id="host">





                      <h2 class="abt-host-text"><?php if($this->lang->line('about_the_host') != '') { echo stripslashes($this->lang->line('about_the_host')); } else echo "About the Host";?>: </h2>



                      <ul class="list-paging">

                      <li>

                        <div class="peps">

                           <figure class="peps-area">
							<img src="<?php if($product->thumbnail == '')echo base_url().'images/site/profile.png'; else echo 'images/users/'.$product->thumbnail; ?>">
						   </figure>



                        </div>

                       <div class="listd-right">
<!--class="more"--->
<span style="text-transform: capitalize;color: #752b7e;font-size: 18px;display: block;margin-bottom: 10px;"><?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?></span>
					   <p >
					   <?php 
					   
					   $description1= stripslashes($product->description1);
					   
					   echo $description1;
					   
					   ?>
					   </p>
					   <?php /*
					   
                        <p class="para-moredesc">
						
						
						<?php $description1= stripslashes($product->description1);

                        echo substr($description1,0,100);

                        echo '<span id="more_description" style="display:none;">'.substr($description1,100).'</span>';?></p>

                      <?php 

                        $description1=substr($description1,100);

                        $description1=strlen($description1);

                        if($description1>10){?>

                      <!--  <a class="moretag" href="javascript:void(0);" onclick="displydesc1(this)">+ <?php if($this->lang->line('more') != '') { echo stripslashes($this->lang->line('more')); } else echo "More";?></a>

                      -->  <?php } ?>
*/ ?>
                       
<a class="view-prof" href="users/show/<?php echo $product->user_id; ?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a> 
<?php if($loginCheck != '' && $loginCheck != $product->user_id){?>				 
<div class="host-contact-btn"><a id="prodpg_btn" data-toggle="modal" class="request-trip" href="#myModal-host"><?php if($this->lang->line('contact_host') != '') { echo stripslashes($this->lang->line('contact_host')); } else echo "Contact host";?></a></div>
<?php }?>

                       </div>



                      </li>

                        <!--<li>

                        <div class="trudt-text"><?php //if($this->lang->line('connection') != '') { echo stripslashes($this->lang->line('connection')); } else echo "Connection";?>

                           

                        </div>

                       <div class="listd-right">

                       <span><?php //if($this->lang->line('connection_question') != '') { echo stripslashes($this->lang->line('connection_question')); } else echo "Are you or your friends connected with this host";?>?</span>

                     <a target="_blank" href="<?php //echo base_url().'facebook/user.php'; ?>" id="fb-connect" style="list-style-type:none;"><img src="images/fbds.png"></a>

                       </div>



                      </li>-->
                            <li>

							<?php if ($proof_verify->num_rows() > 0) { ?>
							
                        <div class="peps">
                          <span class="trudt-text"><?php if($this->lang->line('trust') != '') { echo stripslashes($this->lang->line('trust')); } else echo "Trust";?></span>
                        </div>
							<?php } ?>
						
						
<div class="listd-right">
					
<?php if ($proof_verify->num_rows() > 0) { ?>			
<table border="1px"> 						
<tr>
<?php /*
	
	<td><h2 class="abt-host-text"><?php if($this->lang->line('trust') != '') { echo stripslashes($this->lang->line('trust')); } else echo "Trust";?></h2> </td>

*/ ?>

<td>
<img src="<?php  echo base_url().'images/users/trust1.png';?>"  alt ="Trust">
<p><?php if($this->lang->line('verified_host') != '') { echo stripslashes($this->lang->line('verified_host')); } else echo "Verified Host";?></p>
</td>

<td>
<?php if($proof_verify->row()->id_proof_status == 'Verified') { ?>
<img src="<?php  echo base_url().'images/users/verfied_img1.png';?>"  alt ="Verified">
<p><?php if($this->lang->line('verified_proof') != '') { echo stripslashes($this->lang->line('verified_proof')); } else echo "Verified Proof";?></p>
<?php }  

else { ?>
<img src="<?php  echo base_url().'images/users/unverified_img1.png';?>"  alt ="UnVerified">
<p><?php if($this->lang->line('unVerified_proof') != '') { echo stripslashes($this->lang->line('unVerified_proof')); } else echo "UnVerified Proof";?></p>
<?php } ?>
</td> 
</tr>
</table>
							
	
                        <?php 
                        /*  malar - 12/07/2017 - truxt verification info  */
                        // Get existing proof of user
						/*$existCheck = "SELECT * FROM ".ID_PROOF." WHERE user_id='".$product->user_id."' and proof_status='V'" ;
						$proofDetails = $this->product_model->ExecuteQuery($existCheck);
						if($proofDetails->num_rows()>0){
							//print_r($proofDetails->result());
							$img_type  = array('gif','jpg','png','bmp','jpeg');
							$doc_type  = array('doc','docx');
							$pdf_type = 'pdf';

							foreach ($proofDetails->result() as $proof) {

								$file_ar = explode('.',$proof->proof_file);
								$file_ext = $file_ar[1]; 

								if(in_array($file_ext, $img_type)){
								?><a href='<?php echo ID_PROOF_PATH.$proof->proof_file;?>' target='_blank'>
									<img src="<?php echo ID_PROOF_PATH.$proof->proof_file; ?>"  />	</a>
								<?php
								}elseif(in_array($file_ext, $doc_type)){
									?><a href='<?php echo ID_PROOF_PATH.$proof->proof_file;?>' target='_blank'>
									<img src="images/uploadimg/document_thumb.png"  /> </a>
									<?php
								}elseif($file_ext==$pdf_type){
									?><a href='<?php echo ID_PROOF_PATH.$proof->proof_file;?>' target='_blank'>
									<img src="images/uploadimg/pdf_thumb.jpg"  /> </a>
									<?php
								}
								?>
								<h4><?php echo $proof_title;?></h4>
								<?php
							}
							}*/
							
							
} 

/*else{
						?>
                        <span class="reviews-mark"><?php //if($this->lang->line('Under_development') != '') { echo stripslashes($this->lang->line('Under_development')); } else echo "Under development";
                        //echo "Not verified";
						
						if($this->lang->line('NotVerified') != '') { echo stripslashes($this->lang->line('NotVerified')); } else echo "Not Verified";
                        ?>.</span>
                        </div>

                        <?php  }*/ ?>
						
                        <!--
                       <div class="listd-right">
                       	<?php

						$hostId = $productDetails->row()->user_id;

						$reviewRslt = $this->product_model->get_all_details(REVIEW,array('user_id'=>$hostId, 'status'=>'Active'));



						if($user_reviewData !='')

						$total_review = count($reviewData->result_array()) + count($user_reviewData->result_array());

						else{

						$total_review = count($reviewData->result_array());

						}

						?>
                        <span class="reviews-mark"><?php echo $reviewRslt->num_rows();?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></span>

                       </div>
						-->


                      </li>











                      </ul>

   

                    </div>
					

</div>

</section>

<script type="text/javascript" src="js/site/downloadxml.js"></script>

<style type="text/css">
html, body { height: 100%; } 
</style>

<script type="text/javascript"> 
	var side_bar_html = ""; 
	
	var img='images/mapIcons/marker_red.png'; 
		
	var yimg='images/mapIcons/marker_yellow.png';
	
	var gmarkers = []; 

	var gicons = [];

	var map = null;

	gicons["red"] = new google.maps.MarkerImage(img,

	new google.maps.Size(20, 34),

	new google.maps.Point(0,0),

	new google.maps.Point(9, 34));

	var iconImage = new google.maps.MarkerImage(img,

	new google.maps.Size(20, 34),

	new google.maps.Point(0,0),

	new google.maps.Point(9, 34));

	var iconShadow = new google.maps.MarkerImage('images/mapIcons/shadow50.png',

	new google.maps.Size(37, 34),

	new google.maps.Point(0,0),

	new google.maps.Point(9, 34));

	var iconShape = { coord: [9,0,6,1,4,2,2,4,0,8,0,12,1,14,2,16,5,19,7,23,8,26,9,30,9,34,11,34,11,30,12,26,13,24,14,21,16,18,18,16,20,12,20,8,18,4,16,2,15,1,13,0], type: 'poly' };

	function getMarkerImage(iconColor) {
		if ((typeof(iconColor)=="undefined") || (iconColor==null)) { iconColor = "red";}
		
		if (!gicons[iconColor]) {
	
			gicons[iconColor] = new google.maps.MarkerImage("images/mapIcons/marker_"+iconColor+".png", new google.maps.Size(27, 32), new google.maps.Point(0,0), new google.maps.Point(9, 34)); 
		}
		
		return gicons[iconColor];
	}

	gicons["blue"] = getMarkerImage("blue");

	gicons["green"] = getMarkerImage("green");

	gicons["yelow"] = getMarkerImage("yellow");

	function createMarker(latlng,name,html,color,details,rid) {

		var contentString = html;
	
		var marker = new google.maps.Marker({

		position: latlng,

		icon: gicons[color],

		shadow: iconShadow,

		map: map,

		title: name,

		animation: google.maps.Animation.DROP,

		zIndex: Math.round(latlng.lat()*-100000)<<5

		});

		google.maps.event.addListener(map, 'idle', function(event) {

		});

		google.maps.event.addListener(marker, 'click', function() {

		infowindow.setContent(contentString); 

		infowindow.open(map,marker);

		});

		if(details != '')

		{

		google.maps.event.addListener(marker, "mouseover", function() {

		marker.setIcon(gicons["yellow"]);

		});

		google.maps.event.addListener(marker, "mouseout", function() {

		marker.setIcon(gicons["blue"]);

		});

		}

		else

		{

		google.maps.event.addListener(marker, "mouseover", function() {

		marker.setIcon(gicons["green"]);

		});

		google.maps.event.addListener(marker, "mouseout", function() {

		marker.setIcon(gicons["green"]);

		});

		}

		gmarkers.push(marker);

		var marker_num = gmarkers.length-1;

		if(details != '')

		return '<li class="slide_li" onmouseover="gmarkers['+marker_num+'].setIcon(gicons.yellow)" onmouseout="gmarkers['+marker_num+'].setIcon(gicons.blue)">'+details+'</li>';
		
		else return;
	
	}
	
	function myclick(i) {

		google.maps.event.trigger(gmarkers[i], "click");
	}

	function initialize() {

	var myOptions = {

		scrollwheel: false,

		zoom: 12,

		zoomControl:true,

		zoomControlOptions: {

		style:google.maps.ZoomControlStyle.SMALL,

		position: google.maps.ControlPosition.RIGHT_TOP

		},

		center: new google.maps.LatLng(<?php echo $product->latitude;?>,<?php echo $product->longitude;?>),

		mapTypeControl: true,

		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},

		navigationControl: true,

		mapTypeId: google.maps.MapTypeId.ROADMAP

		}

		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		google.maps.event.addListener(map, 'click', function() { infowindow.close(); });

		downloadUrl();

		}

		function downloadUrl() {  

		var marker = '';

		var totalResults= '<?php echo count($DistanceQryArr->result()); ?>';

		<?php 

		$useId=base_url().'users/show/'.$product->id;

		if($product->thumbnail == '') $useImg=base_url().'images/site/profile.png';

		else $useImg=base_url().'images/users/'.$product->thumbnail;

		?>
		var lat ='<?php echo $product->latitude; ?>'; 

		var lng ='<?php echo $product->longitude; ?>';

		var point = new google.maps.LatLng(lat,lng);

		<?php

		$sample = $productImages->result_array();		

		$simg = PRODUCTPATH.'dummyProductImage.jpg';

		if($sample[0]['product_image']!= '' && file_exists('./server/php/rental/'.$imgArr[0]['product_image'])){ 
		$simg = PRODUCTPATH.$sample[0]['product_image'];
		}else if($sample[0]['product_image']!= '' && strpos($sample[0]['product_image'], 's3.amazonaws.com') > 1)$simg=$sample[0]['product_image'];?>

		var html = '<div class="infoBox similar-listing" ><li><div class="img-top"><div class="figures-cobnt"><img src="<?php echo $simg; ?>"></div><div class="posi-abs" id="pri_map"><a class="ajax cboxElement heart" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a><label class="pric-tag"><span class="rm-rate"><?php  echo  $currencySymbol; ?></span><?php //echo  number_format($product->price * $this->session->userdata('currency_r'),2);
			if($product->currency != $this->session->userdata('currency_type'))
                      {
						echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$product->price);
                      }
                     else{
						echo $product->price;
                     }


		?></label><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom" id="pri_map1"><span class="headlined" style="margin: 0 !important;"><?php echo addslashes($product->product_title); ?></span><p class="describ"><?php echo ucfirst($product->home_type); ?>- <?php echo addslashes(ucfirst($product->CityName)); ?></p></div></li></div>';

		var details='';

		var label ='<?php echo trim(addslashes($product->product_title));?>';

		createMarker(point,label,html,"green",details,'<?php echo $product->id; ?>');

		if(totalResults > 0) {

		<?php 

		if(count($DistanceQryArr->result()) > 0){

		$hoverlist='1';

		

		foreach($DistanceQryArr->result() as $Row_Rental){

		$useId=base_url().'users/show/'.$Row_Rental->userId;

		if($Row_Rental->user_image == '') $useImg=base_url().'images/site/profile.png';

		else $useImg=base_url().'images/users/'.$Row_Rental->user_image;

		?>

		var lat ='<?php echo $Row_Rental->latitud; ?>'; //worke on 6.1.2016

		var lng ='<?php echo $Row_Rental->longitude; ?>';

		var point = new google.maps.LatLng(lat,lng);

		<?php $simg = PRODUCTPATH.'dummyProductImage.jpg';

		if($Row_Rental->PImg!= '' && file_exists('./server/php/rental/'.$Row_Rental->PImg)){
		$simg = PRODUCTPATH.$Row_Rental->PImg;
		}
		else if($Row_Rental->PImg!= '' && strpos($Row_Rental->PImg, 's3.amazonaws.com') > 1)$simg = $Row_Rental->PImg;?>

		<?php 
        $result = 0;
        if($Row_Rental->id != '') {
        $this->db->select('*');
        $this->db->from(REVIEW);
        $this->db->where('product_id',$Row_Rental->id);
        //$this->db->group_by('product_id');
        $result = $this->db->get()->num_rows();


        }
                  $result1 = 0;
        if($Row_Rental->id != '') {
        $this->db->select('*');
        $this->db->from(REVIEW);
        $this->db->where('product_id',$Row_Rental->id);
        //$this->db->group_by('product_id');
        $result1 = $this->db->get()->num_rows();
        //$result1->row();

        }
        ?>

		var html = '<div class="infoBox similar-listing" ><li><div class="img-top"><div class="figures-cobnt"><img src="<?php echo $simg; ?>"></div><div class="posi-abs"><a class="ajax cboxElement heart" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a><label class="pric-tag"><span class="rm-rate"><?php echo $currencySymbol; ?></span><?php echo CurrencyValue($Row_Rental->id ,$Row_Rental->price ); ?></label><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom"><span class="headlined" style="margin: 0 !important;"><?php echo addslashes($Row_Rental->product_title); ?></span><p class="describ"><?php echo ucfirst($Row_Rental->room_type); ?>- <?php echo addslashes(ucfirst($Row_Rental->city_name)); ?></p></div></li></div>';

		var details='<div data-price="<?php echo CurrencyValue($Row_Rental->id ,$Row_Rental->price ); ?>"><div class="img-top" id="prd_sli"><div class="figures-cobnt"><a href="rental/<?php echo $Row_Rental->id; ?>"><img src="<?php echo $simg; ?>"></a></div><span class="headlined" id="pdsli_re"><a  href="rental/<?php echo $Row_Rental->id; ?>" style="float:left;"><?php echo addslashes(substr($Row_Rental->product_title,0,8)).'...'; ?></a></span><div class="posi-abs"><a class="ajax cboxElement <?php if(in_array($Row_Rental->id,$newArr))echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a><label class="pric-tag slide-tag"><?php echo $currencySymbol; 
		//echo CurrencyValue($Row_Rental->id ,$Row_Rental->price ); 
		
					if($Row_Rental->currency != $this->session->userdata('currency_type'))
                      {
						echo convertCurrency($Row_Rental->currency,$this->session->userdata('currency_type'),$Row_Rental->price);
                     }
                     else{
						echo $Row_Rental->price;
                     }
		
		
		
		?></label><a class="aurtors" id="aur" href="<?php echo base_url();?>users/show/<?php echo $Row_Rental->userId;?>"><img style=";" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom"><label id="test_lbl"><label class="star"><a href="<?php echo(($_SERVER['HTTPS'] ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>#reviews"><span class="review_img"><span class="review_st" style="width:<?php echo $result * 20?>%"></span></span><span class="rew"><?php echo $result1; ?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></span><?php //echo $Row_Rental->id; ?></label></label></div></div>';

		var label ='<?php echo trim(addslashes($Row_Rental->product_title));?>';

		marker += createMarker(point,label,html,"blue",details,'<?php echo $Row_Rental->id; ?>');

		<?php $hoverlist=$hoverlist+1;}

		} ?>

		side_bar_html='<div class="map-areas"><ul class="similar-listing">'+marker+'</ul></div>';

		document.getElementById("side_bar").innerHTML = side_bar_html;

		}

		else{

		$("#side_bar").html("<li><?php if($this->lang->line('no_rentals_found') != '') { echo stripslashes($this->lang->line('no_rentals_found')); } else echo "No rentals found..";?></li>");

		}

		} 

		var infowindow = new google.maps.InfoWindow(

		{ 

		size: new google.maps.Size(50,150)

		});
</script>

<style>

  #map{

  display: block;

  width: 95%;

  height: 350px;

  margin: 0 auto;

  -moz-box-shadow: 0px 5px 20px #ccc;

  -webkit-box-shadow: 0px 5px 20px #ccc;

  box-shadow: 0px 5px 20px #ccc;

}

#map.large{

  height:500px;

}



.overlay{

  display:block;

  text-align:center;

  color:#fff;

  font-size:60px;

  line-height:80px;

  opacity:0.8;

  background:#4477aa;

  border:solid 3px #336699;

  border-radius:4px;

  box-shadow:2px 2px 10px #333;

  text-shadow:1px 1px 1px #666;

  padding:0 4px;

}



.overlay_arrow{

  left:50%;

  margin-left:-16px;

  width:0;

  height:0;

  position:absolute;

}

.overlay_arrow.above{

  bottom:-15px;

  border-left:16px solid transparent;

  border-right:16px solid transparent;

  border-top:16px solid #336699;

}

.overlay_arrow.below{

  top:-15px;

  border-left:16px solid transparent;

  border-right:16px solid transparent;

  border-bottom:16px solid #336699;

}



  </style>



<section>



<div id="location" class="map-section">



<div>



</div>







<div id="map" >



<div id="map_canvas" style="width:100%;height:100%"></div>



</div>







</div>



</section>



<style>

#jquery-script-menu {

position: fixed;

height: 90px;

width: 100%;

top: 0;

left: 0;

border-top: 5px solid #316594;

background: #fff;

-moz-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);

-webkit-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);

box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);

z-index: 999999;

padding: 10px 0;

-webkit-box-sizing:content-box;

-moz-box-sizing:content-box;

box-sizing:content-box;

}



.jquery-script-center {

width: 960px;

margin: 0 auto;

}

.jquery-script-center ul {

width: 212px;

float:left;

line-height:45px;

margin:0;

padding:0;

list-style:none;

}

.jquery-script-center a {

	text-decoration:none;

}

.jquery-script-ads {

width: 728px;

height:90px;

float:right;

}

.jquery-script-clear {

clear:both;

height:0;

}



.headlined{



}

#side_bar {

  position: relative;

  overflow: hidden;

  margin: 20px auto 0 auto;

  border-radius: 4px;

}



#side_bar ul {

  position: relative;

  width:920px;

  margin: 0;

  padding: 0;

  height: 200px;

  list-style: none;

  left:315px;

}



#side_bar ul li {

  position: relative;

  display: block;

  float: left;

  margin: 0;

  padding: 0;

  width: 320px;

  height: 250px;

  text-align: center;

  

}



a.control_prev, a.control_next {

  position: absolute;

  top: 45%;

  z-index: 999;

  display: block;

  padding:0;

  width: 30px;

  height: 40px;

  

  color: #blue;

  text-decoration: none;

  font-weight: 600;

  font-size: 18px;

  opacity: 0.8;

  cursor: pointer;

}



a.control_prev:hover, a.control_next:hover {

  opacity: 1;

  -webkit-transition: all 0.2s ease;

}




a.control_prev{

left: -18px !important;
border-radius: 0 2px 2px 0;

}


a.control_next {

  right: -42px;

  border-radius: 2px 0 0 2px;

}



.slider_option {

  position: relative;

  margin: 10px auto;

  width: 160px;

  font-size: 18px;

}

</style>

	<div id="myModal-host" class="modal fade in myModal-host-new mdl_rntl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		<div class="modal-dialog">
		   <div class="modal-content" id="pre_approve_reject">
		<div class="modal-header" id="address-modal">
	
	<a class="btn btn-default close-btn" data-dismiss="modal" onclick="click_test()" id="pre-approve-close"><span class="">x</span></a>
	
	
	<div class="msg-header-left">
	<?php if($this->lang->line('contact_host') != '') { echo stripslashes($this->lang->line('contact_host')); } else{ echo "Contact Host"; }?>
	</div>
	
	
	<div class="msg-header-right">
		
	</div>
	
	
</div>
<div class="modal-body msg-host-form">

                   
<div id="pre_approve_accept" style="display:block">


 <div class="top-title" style="display:none">

                </div>							 
           		
                <ul class="chekin-list" style="border:none">

                    <li>

                        <label><?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "check in"; ?></label>

                        

       
			  
			 <input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" id="datefromContact" class="checkout ui-datepicker-target" autocomplete="off"/> 
			<!-- <input type="text" placeholder="dd-mm-yyyy" autocomplete="off" name="datefrom" readonly="readonly" id="datefromContact" class="checkin ui-datepicker-target" /> -->
				 
          
      

                        

                    </li>



                    <li>

                        <label><?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "check out"; ?></label>

						

						<input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" name="expiredate" autocomplete="off"  id="expiredateContact" onchange="return DateBetweenContact();" class="checkout ui-datepicker-target">
					

                    </li>


                     <li>

                        <label><?php if($this->lang->line('Guest') != '') { echo stripslashes($this->lang->line('Guest')); } else echo "Guest"; ?></label>

                        <select id="number_of_guests_contact" name="number_of_guests_contact" style="width:50px; margin: 0 !important;"onchange="myfunctionContact(this.value);">

					   <?php for($i=1;$i<=$product->accommodates;$i++){ echo '<option value="'.$i.'">'.$i.'</option>';}?>

						</select>
						<div id="contact_host_hidden">
						</div>
                    </li>
					
					<li style="width:100%;"><textarea  name="review" id="offer_message_contact" class="scroll_newdes" style="height:90px;" onkeypress="return IsEmpty('title');"></textarea>
					
					
					
</li>
	<li id="btn_li">											  
<a class="booking-btn" id="contactMsg"><?php if($this->lang->line('Send Message') != '') { echo stripslashes($this->lang->line('Send Message')); } else echo "Send Message"; ?></a>
</li>
                </ul>


              			

</div>
	
	
</div>

		
  
</div>		</div><!-- /.modal-content -->
	</div><!-- /.modal-dalog -->



<section>








<!--<a href="" ><?php if($this->lang->line('contact_host') != '') { echo stripslashes($this->lang->line('contact_host')); } else echo "Contact host";?></a> -->

 							

</section>
<section>



<div class="review-section-area">

<?php  if(count($DistanceQryArr->result()) > 0){ ?>

    <div class="container">

	<div class="listings" id="lih"><?php if($this->lang->line('similar_listings') != '') { echo stripslashes($this->lang->line('similar_listings')); } else echo "Similar Listings";?></div>

		

  <div class="center" style="width: 960px; margin: 0 auto;">

    <div class="slides">
      <a href="javascript:void(0);" class="control_next"></a>
			<div id="side_bar">
			</div>

			<a href="javascript:void(0);" class="control_prev"></a>

	</div>

	</div>

	</div>
<?php }  ?>
</div>



</section>


<input type="hidden" value="<?php echo $product->price; ?>" id="price" />   
<input type="hidden" value="<?php echo $product->price; ?>" id="Global_Price" />    

 <input type="hidden" value="<?php echo $product->user_id; ?>" id="ownerid" />



<input type="hidden" id="login_userid" name="login_userid" value="<?php echo $loginCheck; ?>" />

<input type="hidden" value="793959" name="hosting_id" id="hosting_id">

<input type="hidden" name="renter_id" id="renter_id" value="<?php echo $loginCheck; ?>" />

<input type="hidden" name="prd_id" id="prd_id" value="<?php echo $product->id; ?>" />
<input type="hidden" name="cancel_percentage" id="cancel_percentage" value="<?php echo $product->cancel_percentage; ?>" />

<input type="hidden" value="" id="results" />
<input type="hidden" value="" id="resultsContact" />

<input type="hidden" value="<?php echo $productDetails->row()->accommodates; ?>" id="RentalGuest" />




<script type="text/javascript">





function reviewValid() {

                 $("#title_warn").html('');

                 $("#review_warn").html('');

                 $("#nickname_warn").html('');

                                 

                 

                    if($("#title").val() == ''){                    

                        $("#title_warn").html('<?php if($this->lang->line('This_field_is_required') != '') { echo stripslashes($this->lang->line('This_field_is_required')); } else echo "This field is required";?>');

                        $("#title").focus();

                        return false;

                        

                    }else if($("#review").val() == ''){

                        $("#review_warn").html('<?php if($this->lang->line('This_field_is_required') != '') { echo stripslashes($this->lang->line('This_field_is_required')); } else echo "This field is required";?>');

                        $("#review").focus();

                        return false;

                    



                    }else if($("#nickname").val() == ''){

                        $("#nickname_warn").html('<?php if($this->lang->line('This_field_is_required') != '') { echo stripslashes($this->lang->line('This_field_is_required')); } else echo "This field is required";?>');

                        $("#nickname").focus();

                        return false;

                        

                    }

                    else

                    {   

                            $("#reviewForm").submit();

                    }

                    

                    

    }

        function IsEmail(email) {

        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if(!regex.test(email)) {

           return false;

        }else{

           return true;

        }

      }

function removeError(idval){

    $("#"+idval+"_warn").html('');}

    



</script>

<script type="text/javascript">

//alert();
$(".carousel-inner .active").click();

function showView(val){

    if($('.showlist'+val).css('display')=='block'){

        $('.showlist'+val).hide('');    

    }else{

        $('.showlist'+val).show('');

    }   

}

<!-- calculation part -->

function DateBetween(){

	var date = $("#datefrom").datepicker('getDate');

    var start = date.setDate(date.getDate()),

	end = $("#expiredate").datepicker("getDate"),

        currentDate = new Date(start),

        

        between = [];

    while (currentDate < end) {

        between.push(new Date(currentDate));

        currentDate.setDate(currentDate.getDate() + 1);

    }

   days = between.length;

   if(days == 0)
   return false;

    $('#results').val(between.join(','));

    var price=$("#Global_Price").val();

  

    $.ajax({

        type: 'POST',   

        url:baseURL+'site/product/ajaxdateCalculate',

        data:{'dateval':between.join(','),'pid':$("#prd_id").val(),'price':price},

        success:function(response){
			//alert(response);
			$('#price_div').html(response);
			return false;
        }

    });

 

}

function DateBetweenContact(){
	var date = $("#datefromContact").datepicker('getDate');

    var start = date.setDate(date.getDate()),

	end = $("#expiredateContact").datepicker("getDate"),

        currentDate = new Date(start),

        

        between = [];

    while (currentDate < end) {

        between.push(new Date(currentDate));

        currentDate.setDate(currentDate.getDate() + 1);

    }
	
   days = between.length;
   if(days == 0)
   return false;

    $('#resultsContact').val(between.join(','));

    var price=$("#Global_Price").val();
   

    $.ajax({

        type: 'POST',   

        url:baseURL+'site/product/ajaxdateCalculateContact',

        data:{'dateval':between.join(','),'pid':$("#prd_id").val(),'price':price},

        success:function(response){
			
			$('#contact_host_hidden').html(response);
			$('#contactMsg').show();
			return false;
		}
	});
	return false;
}







<!-- script added 22/05/2014 ---->

/*function bookingamt(val) {

    

    var noofguest = val.value;

    var amt=$("#price").val();

    $('#bookingtot').html(amt * noofguest);

    

}*/



</script>
<!-- Wallet  Payment -moved to payment - no need here - /* malar -07/07/2017 */ -->
<script type="text/javascript">
	/*
	function checkPayBalance(){
		var walletAmount = $("#use_wallet_str").val();
		var bookingtot = $("#bookingtot_str").val();

		if($("#use_wallet_checkbox").is(':checked')){
			
			if(Number(walletAmount)<=Number(bookingtot-10)){
				str = (bookingtot-walletAmount).toFixed(2);
				$("#tot_pay").html(str) ;
				$("#tot_pay").append(' <?php echo $this->session->userdata('currency_type');?>');
			}else if(Number(walletAmount)>Number((walletAmount-bookingtot)-10)){
				str = (bookingtot-walletAmount).toFixed(2);
				$("#tot_pay").html(str) ;
				$("#tot_pay").append(' <?php echo $this->session->userdata('currency_type');?>');
			}else{
				alert("Sorry you can't pay full payment from wallet. ");
			}

		}else {
			alert('wallet unchecked');
			$("#tot_pay").html(bookingtot) ;
				$("#tot_pay").append(' <?php echo $this->session->userdata('currency_type');?>');

		}
	}
*/
</script>

<script> 

function BookingIt_new(option)
{


var choosed_option=option;

if($('#datefrom').val() == '')
{
	$('#datefrom').focus();
	return false;
}

if($('#expiredate').val() == '')
{
	$('#expiredate').focus();
	return false;
}
var datefrom=new Date($('#datefrom').val());

var expiredate=new Date($('#expiredate').val());

var diffDays = (expiredate.getTime() - datefrom.getTime())/(24 * 60 * 60 * 1000);

//alert(diffDays);

if ($('#ownerid').val()==$('#login_userid').val()) {

alert("<?php if($this->lang->line('You_have_no_permission') != '') { echo stripslashes($this->lang->line('You_have_no_permission')); } else echo "You have no permission";?>");

return false;

} 

else if('<?php echo $productDetails->row()->child_name;?>'>diffDays)

{

alert("<?php if($this->lang->line('Minimum_Stay_Shoud_be') != '') { echo stripslashes($this->lang->line('Minimum_Stay_Shoud_be')); } else echo "Minimum Stay Shoud be";?> "+<?php echo $productDetails->row()->child_name;?>+' <?php if($this->lang->line('Days') != '') { echo stripslashes($this->lang->line('Days')); } else echo "Days";?>');

return false;

}
else if('<?php echo $productDetails->row()->host_status;?>' == 1)
{
	alert("<?php if($this->lang->line('Host_is_removed') != '') { echo stripslashes($this->lang->line('Host_is_removed')); } else echo "Host is removed so booking is not available";?>");
	
	return false;
}

else {

$('#subtotal_area_div').html('');



    var checkin = jQuery.trim($('#datefrom').val());

    var checkout = jQuery.trim($("#expiredate").val());

    var NoofGuest = parseInt(jQuery.trim($("#number_of_guests").val()));

	//alert(NoofGuest);

    var prd_id=$('#prd_id').val();
	
	var cancel_percentage=$('#cancel_percentage').val();
	

    var renter_id=$('#ownerid').val();

    if($("#datefrom").val()!='' && $("#expiredate").val()!='') {

        var diff = ($("#expiredate").datepicker("getDate") - $("#datefrom").datepicker("getDate")) / 1000 / 60 / 60 / 24;

    }

}       









var rentguest=jQuery.trim($('#RentalGuest').val());



    if(checkin == ''){

        $("#datefrom").focus();

        return false;

    }else if(checkout== ''){

        $("#expiredate").focus();

        return false;

    }else if(NoofGuest > parseInt(rentguest)){

        $('#subtotal_area_div').html('<?php if($this->lang->line('Maximum_number_of_guests_is') != '') { echo stripslashes($this->lang->line('Maximum_number_of_guests_is')); } else echo "Maximum number of guests is";?> '+parseInt(rentguest));

        return false;

    }else{  

    //$('#BookingPriceCalc').hide();

    $('#book_it_status').html('<div align="center"><img src="images/load-indicator.gif" align="center" /></div>');

		var totalamt=$('#bookingtot').val();

		var servicefee=$('#stax').val();
		var subTotal = $("#subTotal").val();
		var currencycode = $("#currencycode").val();
		
		var user_currencyCode = $("#user_currencyCode").val();
		
		
		var secDeposit = $("#secDeposit").val();
		var walletAmount =$("#use_wallet").val();	
		var use_wallet_checkbox ='no';
		/* malar- 07/07/2017 */
		/* 
		if($("#use_wallet_checkbox").is(':checked')){
		 	use_wallet_checkbox ='yes';
		}
		if(use_wallet_checkbox=='yes')
			walletAmount = walletAmount;
		else 
			walletAmount ='0.00';
		//alert(use_wallet_checkbox);
		*/

		walletAmount = '0.00';

		if(totalamt != ''){
        $.ajax({

            type: 'POST',

            url: baseURL+'site/user/rentalEnquiry_booking',

            data: {"checkin":checkin,"checkout":checkout,'numofdates':diff,"NoofGuest":NoofGuest,"cancel_percentage":cancel_percentage,"prd_id":prd_id,"renter_id":renter_id,"serviceFee":servicefee,"totalAmt":totalamt,"subTotal":subTotal,"secDeposit":secDeposit,"walletAmount":walletAmount,"currencycode":currencycode,"user_currencyCode":user_currencyCode,"choosed_option":choosed_option},

            dataType: 'json',

            success: function(json){

            //alert(json['status_code']);

            if(json['message']=='Rental date already booked')

            {

            alert('<?php if($this->lang->line('Rental date already booked') != '') { echo stripslashes($this->lang->line('Rental date already booked')); } else echo "Rental date already booked";?>');

            }

            else{

             window.location.href = baseURL+'booking/'+$('#prd_id').val();

                }

                    

            }

        });
	}
	}
}



</script>

<!-- script added 22/05/2014 -->

<script>




function myfunctionContact(val) {

//alert();

var famt =$('#bookingsubtot1').html();

//alert(famt);

var service_tax =$('#servicetax1').html();

//alert(service_tax+famt);

famt = famt.replace ( /[^\d.]/g, '' );

//famt=parseInt(famt);



service_tax = service_tax.replace ( /[^\d.]/g, '' );

service_tax=parseInt(service_tax);



//service_tax=parseInt(service_tax);



if('<?php echo $service_tax->num_rows()?>'==0)

{
total =(val*famt);
$('#bookingtot1').html(total);
}

else if('<?php echo $service_tax->row()->promotion_type; ?>'=='flat')

{

total =(val*famt);

var gtotal = (val*famt);

total =(val*famt)+parseInt(service_tax);

var stax = total-gtotal;

$('#bookingtot1').html(total);

$('#stax1').html(stax);

}

else{

total =(val*famt);

var gtotal = (val*famt);

total =total+(total*parseInt(service_tax)/100);

total=Math.round(total);

var stax = total-gtotal;

$('#bookingtot1').html(total);

$('#stax1').html(stax);

}

}

function myfunction(val) {



var famt =$('#bookingsubtot').html();

//alert(famt);

var service_tax =$('#servicetax').html();

//alert(service_tax+famt);

famt = famt.replace ( /[^\d.]/g, '' );

//famt=parseInt(famt);



service_tax = service_tax.replace ( /[^\d.]/g, '' );

service_tax=parseInt(service_tax);



//service_tax=parseInt(service_tax);



if('<?php echo $service_tax->num_rows()?>'==0)

{

total =(val*famt);





$('#bookingtot').html(total);



}

else if('<?php echo $service_tax->row()->promotion_type; ?>'=='flat')

{

total =(val*famt);

var gtotal = (val*famt);

total =(val*famt)+parseInt(service_tax);

var stax = total-gtotal;

//$('#bookingtot').html(total);

//$('#stax').html(stax);

}

else{

total =(val*famt);

var gtotal = (val*famt);

total =total+(total*parseInt(service_tax)/100);

total=Math.round(total);

var stax = total-gtotal;

//$('#bookingtot').html(total);

//$('#stax').html(stax);

}

}

</script>





















<script type="text/javascript">
$(document).ready(function(){
	<?php if($loginCheck != '' && $this->session->userdata ( 'searchFrom' ) != '' && $this->session->userdata ( 'searchTo' ) != '' && $this->session->userdata ( 'searchGuest' ) != ''){ ?>
		DateBetween();
	<?php } ?>
});

/*** 

    Simple jQuery Slideshow Script

    Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)

***/



function slideSwitch() {

    var $active = $('#slidebanner IMG.active');



    if ( $active.length == 0 ) 
	{
		$active = $('#slidebanner IMG:last');
	}


    // use this to pull the images in the order they appear in the markup

    var $next =  $active.next().length ? $active.next(): $('#slidebanner IMG:first');



    // uncomment the 3 lines below to pull the images in random order

    

    // var $sibs  = $active.siblings();

    // var rndNum = Math.floor(Math.random() * $sibs.length );

    // var $next  = $( $sibs[ rndNum ] );





    $active.addClass('last-active');



    $next.css({opacity: 0.0})

        .addClass('active')

        .animate({opacity: 1.0}, 1000, function() {

            $active.removeClass('active last-active');

        });

}



$(function() {

    setInterval( "slideSwitch()", 5000 );

});



</script>



<!-- script added by 14/03/2014 -->

<script>

function amtChange(val) {



var arr = val.split('-');

//  includesFees

    if(arr[0]=="2")  {

        if(arr[1]>0){

        document.getElementById('priceweek_amount').style.display='block';

        }else{

        var price=$('#price_amount').html();

        $('#priceweek_amount').html((price * 7).toFixed(2));

        document.getElementById('priceweek_amount').style.display='block';

        }

    document.getElementById('pricemonth_amount').style.display='none';

    document.getElementById('price_amount').style.display='none';

    document.getElementById('includesFees').style.display='none';

    }

    else if(arr[0]=="3")  {

        if(arr[1]>0){

        

            document.getElementById('pricemonth_amount').style.display='block';

        }else{

            var price=$('#price_amount').html();

            $('#pricemonth_amount').html((price * 30).toFixed(2));

            document.getElementById('pricemonth_amount').style.display='block';

        }

    document.getElementById('priceweek_amount').style.display='none';

    document.getElementById('price_amount').style.display='none';

    document.getElementById('includesFees').style.display='block';

    }

    else if(arr[0]=="1")  {

        document.getElementById('price_amount').style.display='block';

        document.getElementById('pricemonth_amount').style.display='none';

        document.getElementById('priceweek_amount').style.display='none';

        document.getElementById('includesFees').style.display='none';

    }

    

    

    

}

/* function productImage_Calendar()

{

 
if($('.descri-section:last >img').css('display')!='none')

{

$('.descri-section:last >img').css('display','none');

$('.descri-section:last >div').css('display','block');

}

else{

$('.descri-section:last >img').css('display','block');

$('.descri-section:last >div').css('display','none');

} 

} */



function addreview(evt)

{

    $(evt).hide();

    $("#reviews_list").hide();

    $("#add_review").show();

    //$(evt).previous().show(); 

}



$('#demo_button').click(function(){

    alert($("input[name=mystar]").val());

});

$('#datepicker_view').click(function(){

    $("#datefromCheck").click();
    $("#datefrom").focus();

});

</script>


<script type="text/javascript">

$(document).ready(function() {
	$('#contactMsg').click(function()
	{
		if($.trim($("#datefromContact").val()) == ''){
		   $("#datefromContact").focus();
		}
		else if($.trim($("#expiredateContact").val()) == ''){
		   $("#expiredateContact").focus();
		}
		else if($("#offer_message_contact").val()=='')
		{
			$("#offer_message_contact").focus();
		}
		else
		{
			var contactMessage=$("#offer_message_contact").val();
			
			var productId=<?php echo $productId;?>;
			
			var noOfGuests=$("#number_of_guests_contact").val();
			
			if($("#datefromContact").val()!='' && $("#expiredateContact").val()!='') {

				var nodays = ($("#expiredateContact").datepicker("getDate") - $("#datefromContact").datepicker("getDate")) / 1000 / 60 / 60 / 24;

			}
			
			var checkIn = $("#datefromContact").val();
			var checkOut = $("#expiredateContact").val();
			var productPrice = $("#Global_Price").val();
			var service_fee = $("#staxContact").val();
			var totalPrice = $("#bookingtotContact").val();
	
			$.ajax({

				type: 'POST',   

				url:baseURL+'site/rentals/request_booking',
				
				data:{'checkIn':checkIn,'checkOut':checkOut,'noOfNyts':nodays,'productPrice':productPrice,'service_fee':service_fee,'totalPrice':totalPrice,'noOfGuests':noOfGuests,'msg':contactMessage,'productId':productId}, 

				success:function(response){
					$('#myModal-host').modal('toggle');
					$("#offer_message_contact").val("");
					$("#datefromContact").val('')
					$("#expiredateContact").val('');
					$("#number_of_guests_contact").val('1');
					$('#contactMsg').hide();
				}
			}); 
		}
	});
});


function add_review()

{

r1 = $('#r1').val();

r2 = $('#r2').val();

r3 = $('#r3').val();

r4 = $('#r4').val();

r5 = $('#r5').val();

r6 = $('#r6').val();

sum = parseInt(r1) + parseInt(r2) + parseInt(r3) + parseInt(r4) + parseInt(r5) + parseInt(r6);

total_review = sum/6;

$('#r7').val(total_review);

$('#reviewForm').submit();

//alert(r1);

//alert(r2);

}



function visible_invisible(elem)

{

current_id=$(elem).prev('p').find('span').attr('id');



$('#'+current_id).css('display','block');



$($(elem).hide());

}

</script> 



<script>
$("#pre-approve-close").click(function(){

});

</script>





<style>

.similar-listing li {

    margin: 0 0px 0 10px;

} 

.header{position:absolute; background:#fff;}

</style>

<script  type="text/javascript">

function scrollDiv(scroll_div_id)

{

 

$('html, body').animate({

 scrollTop: $('#'+scroll_div_id).offset().top-50

    }, 2000); 

	

}


function clickImage(id)
{
	$("#image-gal-"+id).click();
}

show_more_and_less(200);
</script>

<?php

$this->load->view('site/templates/prefooter');

$this->load->view('site/templates/footer');?>

<div style="display:none">

<?php $this->load->view('site/popup/list');?>

</div>

<input type="hidden" value="<?php echo $ProductDealPrice->row()->deal_start_date;?>" id="deal_dateFrom">

<input type="hidden" value="<?php echo $ProductDealPrice->row()->deal_end_date;?>" id="deal_Dateto">

<input type="hidden" value="<?php echo $ProductDealPrice->row()->deal_amount;?>" id="deal_amount">
<!---popup banner jquery-->