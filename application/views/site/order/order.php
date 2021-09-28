<?php $this->load->view('site/templates/header');



if($Confirmation =='Success'){

$user_currencycode=$invoicedata->row()->user_currencycode;

$unitprice=$invoicedata->row()->unitPerCurrencyUser;

}

 ?>

<style>

.cart-list.chept2{

float: left;

width: 100%;

margin: 20px 0px;

}



.booking{

background:#717171;

width:100%;

text-align:center;

font-size:24px;

color:#fff;

padding:5px 0px;

}



.booking h5{

padding:0px;

padding-bottom:10px;

margin:0px;

font-size: 13px;

font-weight: 100;

}

.booking-success{



}

.grid-con{

width:95%;

margin:0 auto;

}



.grid-step1{

width:100%;

float:left;

margin: 10px 0px;

}



.grid-step1 p a{

text-decoration:none;

}



.grid-step1 p a{

color:#fff;

}

.thanks-book{

border:1px solid #a5a5a5;

float: left;

width: 100%;

}

</style>

<link rel="stylesheet" type="text/css" media="all" href="css/site/cms.css">

<div class="lang-en wider no-subnav thing signed-out winOS order-confirm-container" data-twttr-rendered="true" >

	<div id="container-wrapper" class="">

		<div class="container ">

			<div class="wrapper-content right-sidebar">			

				<div class="content_text" >

					<?php if($flash_data != '') { ?>

					<!-- <div class="errorContainer" id="<?php //echo $flash_data_type;?>">

						<script>setTimeout("hideErrDiv('<?php //echo $flash_data_type;?>')", 3000);</script>

						<p><span><?php //echo $flash_data;?></span></p>

					</div> -->

					<?php } ?>

					<div id="content" >

						<div class="cart-list chept2">

							<?php if($Confirmation =='Success'){ ?>                    

							<div class="thanks-main">

								<div class="thanks-book">

									<div class="booking">

										<h1><?php if($this->lang->line('Thanks for your Booking') != '') { echo stripslashes($this->lang->line('Thanks for your Booking')); } else echo "Thanks for your Booking";?></h1>

										<h5><?php if($this->lang->line('We are glad that you choose our service, please review us after your journey') != '') { echo stripslashes($this->lang->line('We are glad that you choose our service, please review us after your journey')); } else echo "We are glad that you choose our service, please review us after your journey";?>.</h5>

									</div>

									<div class="booking-success">

										<h2><?php if($this->lang->line('Booking Success') != '') { echo stripslashes($this->lang->line('Booking Success')); } else echo "Booking Success";?>

</h2>

										<div class="grid-con">

											<div class="grid-step1">

												<p><a href=""><?php if($this->lang->line('Your Booking Reference Number is') != '') { echo stripslashes($this->lang->line('Your Booking Reference Number is')); } else echo "Your Booking Reference Number is";?> - </a></p>

												<p><a href=""><?php echo $invoicedata->row()->Bookingno; ?></a></p>

											</div>

											<div class="grid-step1">

											<p><a href=""><?php if($this->lang->line('Amount paid') != '') { echo stripslashes($this->lang->line('Amount paid')); } else echo "Amount paid";?> - </a></p>

											<p><a href=""><?php    echo $currencySymbol; ?><?php //.stripslashes(CurrencyValue($productId,$invoicedata->row()->totalAmt)); 

											

											

											

											/* 25-Sep if($invoicedata->row()->currencycode != $this->session->userdata('currency_type'))

						                      {						                    

						                     //echo convertCurrency($invoicedata->row()->currencycode,$this->session->userdata('currency_type'),$invoicedata->row()->totalAmt);

				

						                      	echo convertCurrency($invoicedata->row()->currencycode,$this->session->userdata('currency_type'),$paid_amount);



						                     }

											else{

						                     	// echo $invoicedata->row()->totalAmt;

						                     	echo $paid_amount;

						                     } 25-sep*/



 if($user_currencycode==$this->session->userdata('currency_type')){ 

				if(!empty($unitprice))

				echo customised_currency_conversion($unitprice,$paid_amount);

			 }else{

				 echo convertCurrency($invoicedata->row()->currencycode,$this->session->userdata('currency_type'),$paid_amount);

			 }











											 



											?>

												

											<?php  echo $this->session->userdata('currency_type'); ?>

											</a></p>

											</div>

										</div>

									</div>

								</div>

							</div>

							<?php $this->output->set_header('refresh:5;url='.base_url().'trips/upcoming'); 

							}elseif($Confirmation =='Failure'){ ?>

							<div class="thanks-main">

								<div class="thanks-book">

									<div class="booking">

										<h1><?php if($this->lang->line('Your Booking Failed') != '') { echo stripslashes($this->lang->line('Your Booking Failed')); } else echo "Your Booking Was Failed";?>

</h1>

										<h5><?php if($this->lang->line('We are apologize that your booking with us failed') != '') { echo stripslashes($this->lang->line('We are apologize that your booking with us failed')); } else echo "We are apologize that your booking with us was failed";?>

.</h5>

									</div>

									<div class="booking-success">

										<h2><?php if($this->lang->line('Booking Failure') != '') { echo stripslashes($this->lang->line('Booking Failure')); } else echo "Booking Failure";?>

</h2>

										<div class="grid-con">

											<div class="grid-step1">

												<p><a href=""><?php if($this->lang->line('Reason') != '') { echo stripslashes($this->lang->line('Reason')); } else echo "Reason";?> - </a></p>

												

												<?php if ($errors!=''){ ?>

												<p>

													<a href=""><?php echo $errors; ?></a>

												</p>

												

												<?php } else { ?>

												<p>

													<a href=""><?php echo "You have Cancelled Your Transaction"; ?></a>

												</p>

												<?php } ?>

												

												

											</div>

										</div>

									</div>

								</div>

							</div>

							<?php 

							$this->output->set_header('refresh:5;url='.base_url().'trips/upcoming');  

							}else if ($Confirmation =='failureList'){ ?>

							

								<div class="thanks-main">

								<div class="thanks-book">

									<div class="booking">

										<h1><?php if($this->lang->line('Your Booking Failed') != '') { echo stripslashes($this->lang->line('Your Booking Failed')); } else echo "Your Booking Failed";?>

</h1>

										<h5><?php if($this->lang->line('We are apologies that your booking with us failed') != '') { echo stripslashes($this->lang->line('We are apologize that your booking with us failed')); } else echo "We are apologize that your booking with us failed";?>

.</h5>

									</div>

									<div class="booking-success">

										<h2><?php if($this->lang->line('Booking Failure') != '') { echo stripslashes($this->lang->line('Booking Failure')); } else echo "Booking Failure";?>

</h2>

										<div class="grid-con">

											<div class="grid-step1">

												<p><a href=""><?php if($this->lang->line('Reason') != '') { echo stripslashes($this->lang->line('Reason')); } else echo "Reason";?> - </a></p>

												

												<?php if ($errors!=''){ ?>

												<p>

													<a href=""><?php echo $errors; ?></a>

												</p>

												

												<?php } else { ?>

												<p>

													<a href=""><?php echo "You have Cancelled Your Transaction"; ?></a>

												</p>

												<?php } ?>

												

												

											</div>

										</div>

									</div>

								</div>

							</div>

							<?php 

							$this->output->set_header('refresh:5;url='.base_url().'listing/all'); 

							}

							?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>	 

<?php $this->load->view('site/templates/footer');?>