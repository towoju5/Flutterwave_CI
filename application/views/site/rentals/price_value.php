<?php if($requestType == 'booking_request') {?><div class="service-copmity">

<ul>

		<li>

			<span id="bookingdate">



			<?php if($this->lang->line('Booking_for') != '') { echo stripslashes($this->lang->line('Booking_for')); } else echo "Booking for"; ?>

			<?php echo $total_nights;?> <?php if($this->lang->line('night') != '') { echo stripslashes($this->lang->line('night')); } else echo "Night"; ?></span>

			<label class="price"><?php  echo $currencySymbol; ?></label>

			<label id="bookingsubtot"><?php echo $total_value;?> <?php echo $this->session->userdata('currency_type');?>

                	

               

			</label>

		</li>

		<li>

			<span><?php if($this->lang->line('service_fee') != '') { echo stripslashes($this->lang->line('service_fee')); } else echo "Service Fee"; ?></span>

			<label class="price"><?php  echo $currencySymbol; ?></label>

			<label class="table-cell-price" id="service_tax" >

				<center><p style="font-size:14px"><?php echo $taxString;?> <?php echo $this->session->userdata('currency_type');?>

                	

                </p></center>

			</label>

		</li>
		<?php if($securityDeposite != 0){?>
		<li>

			<span><?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit";?>
			</span>

			<label class="price"><?php  echo $currencySymbol; ?></label>

			<label class="table-cell-price" id="sec_deposit" >

				<center><p style="font-size:14px"><?php echo $securityDeposite_string;?> <?php echo $this->session->userdata('currency_type');?>

                	
                	

                </p></center>

			</label>

		</li>
		<?php } ?>

				<?php if($cleaningFee != 0){?>
		<li>

			<span><?php if($this->lang->line('cleaningfee') != '') { echo stripslashes($this->lang->line('cleaningfee')); } else echo "Cleaning Fee";?>
			</span>

			<label class="price"><?php echo $currencySymbol; ?></label>

			<label class="table-cell-price" id="cleaning_fee" >

				<center><p style="font-size:14px"><?php echo $cleaningFee_string;?> <?php echo $this->session->userdata('currency_type');?>

                	
                	

                </p></center>

			</label>

		</li>
		<?php } ?>

		<?php 
		/* User wallet */
		/* malar-07/07/2017 - moved to payment
		if($userWallet->num_rows()>0 && $userWallet->row()->referalAmount>0)
		{
			?>
			

				<span style='padding-left:20px'>
				<input type='checkbox' value='yes' name='use_wallet_checkbox' id ='use_wallet_checkbox' onclick='checkPayBalance();'></checkbox> Use Wallet(<?php  echo $currencySymbol; ?>  <?php echo convertCurrency($userWallet->row()->referalAmount_currency,$this->session->userdata('currency_type'),$userWallet->row()->referalAmount); ?> <?php echo $this->session->userdata('currency_type');?>
 )</span>
 				
				<label class="price"></label>

				<label class="table-cell-price" id="wallet" >

					<center><p style="font-size:14px">
	                	

	                </p></center>

				</label>

			
			<?php
		}
			*/
		/* User Wallet Ends */

		?>

		<p id="servicetax"  style="display:none;"><?php echo $commissionType; ?></p>

		<p id="taxtype" name="taxtype" style="display:none;"><?php echo $commissionValue; ?></p>

		<li>

			<span><?php if($this->lang->line('Total') != '') { echo stripslashes($this->lang->line('Total')); } else echo "Total"; ?></span>

			<label class="price"> <?php  echo $currencySymbol; ?></label>

			<label  class="table-cell-price" id='tot_pay' ><?php echo $net_total_string;?> <?php echo $this->session->userdata('currency_type');?>

                </label>
            <input type='hidden' id="bookingtot_str" value="<?php echo $net_total_string;?>" />  
              
			<input id="bookingtot" type="hidden" value="<?php echo $net_total_value;?>" />

			<input id="subTotal" type="hidden" value="<?php echo $subTotal;?>" />


			<input id="stax" type="hidden" value="<?php echo $taxValue;?>" />
			
			<input id="secDeposit" type="hidden" value="<?php echo $securityDeposite;?>" />

			<input id="cleaningFee" type="hidden" value="<?php echo $cleaningFee;?>" />
			<!--/* malar-07/07/2017 - moved to payment -->
			<!--  
			<input type='hidden' id='use_wallet_str' value="<?php // echo convertCurrency($userWallet->row()->referalAmount_currency,$this->session->userdata('currency_type'),$userWallet->row()->referalAmount); ?>" />
			
			<input id="use_wallet" type="hidden" value="<?php  // echo convertCurrency($userWallet->row()->referalAmount_currency,$currencycd,$userWallet->row()->referalAmount);?>" />
			-->
			<input type='hidden' id='use_wallet_str' value="<?php echo ''; ?>" />
			
			<input id="use_wallet" type="hidden" value="<?php echo '';?>" />


			<input id="currencycode" type="hidden" value="<?php echo $currencycd;?>" />
		</li>

	</ul>

</div>


<?php 

/*if ($pay_option->row()->request_to_book == 'Yes' &&  $pay_option->row()->instant_pay  == 'Yes' && $instant_pay->row()->status=='1' ) { ?>

<div class="submit-link">

	<a class="booking-btn" id ="pay_option" onclick="return  BookingIt_new('book_now');" href="javascript:void(0);"><?php 

		if($this->lang->line('book_now') != '') {

		echo stripslashes($this->lang->line('book_now')); 

		} 

		else 

		echo "Book Now"; ?></a>

</div>

<br>

<div class="submit-link">

	<a class="booking-btn"  id ="pay_option" onclick="return BookingIt_new('instant_pay');" href="javascript:void(0);"><?php 

		if($this->lang->line('instant_pay') != '') {

		echo stripslashes($this->lang->line('instant_pay')); 

		} 

		else 

		echo "Instant Pay"; ?></a>

</div>




<?php } else if ($pay_option->row()->instant_pay  == 'Yes' && $instant_pay->row()->status=='1'){ ?>


<div class="submit-link">

	<a class="booking-btn" id ="pay_option" onclick="return BookingIt_new('instant_pay');" href="javascript:void(0);"><?php 

		if($this->lang->line('instant_pay') != '') {

		echo stripslashes($this->lang->line('instant_pay')); 

		} 

		else 

		echo "Instant Pay"; ?></a>

</div>

<?php } else if ($pay_option->row()->request_to_book == 'Yes' ){ ?>

<div class="submit-link">

	<a class="booking-btn" id ="pay_option" onclick="return  BookingIt_new('book_now');" href="javascript:void(0);"><?php 

		if($this->lang->line('book_now') != '') {

		echo stripslashes($this->lang->line('book_now')); 

		} 

		else 

		echo "Book Now"; ?></a>

</div>
<?php } else { ?>


<div class="submit-link">

	<a class="booking-btn" id ="pay_option" onclick="return  BookingIt_new('book_now');" href="javascript:void(0);"><?php 

		if($this->lang->line('book_now') != '') {

		echo stripslashes($this->lang->line('book_now')); 

		} 

		else 

		echo "Book Now"; ?></a>

</div>


<?php }	

*/

  } else if($requestType == 'contact_host') { ?>

	<input id="bookingtotContact" type="hidden" value="<?php echo $net_total_value;?>" />

	<input id="subTotal" type="hidden" value="<?php echo $subTotal;?>" />

	<input id="staxContact" type="hidden" value="<?php echo $taxValue;?>" />

<?php }?>