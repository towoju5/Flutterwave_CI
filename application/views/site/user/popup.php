<div class="main">
	<div class="dashboard_full">
    					<div class="dashboard_full_tex">
                     <div class="right_dashboard_content">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="property_table">
 
<?php /*?><?php foreach($InquirieDisplay->result() as $InquiryRow){ ?><?php */?>
  <tr>
 		<td width="10%"><?php if($this->lang->line('Rental_Name') != '') { echo stripslashes($this->lang->line('Rental_Name')); } else echo "Rental Name";?></td>
 			<?php /*?><?php foreach($ProductDisplay->result() as $ProductRow){ 
   				if($ProductRow->id==$InquiryRow->rental_id){?><?php */?>
 					<td width="20%"<?php /*?>><?php echo $ProductRow->product_title; ?></td> <?php } } ?><?php */?>
  </tr>
  <tr>
  	    <td width="20%"><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First Name";?></td>
  		<td width="60%">1<?php /*?><?php echo $InquiryRow->firstname; ?><?php */?></td>
  </tr>
  <tr>
  		<td width="20%"><?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last Name";?></td>
    	<td width="60%">2</td>
  </tr>
  <tr>
  		<td width="20%"><?php if($this->lang->line('Email') != '') { echo stripslashes($this->lang->line('Email')); } else echo "Email";?></td>
    	<td width="60%">3</td>
  </tr>
  <tr>
  		<td width="20%"><?php if($this->lang->line('Phone') != '') { echo stripslashes($this->lang->line('Phone')); } else echo "Phone";?></td>
    	<td width="60%">4</td>
  <tr>
  		<td width="20%"><?php if($this->lang->line('Arrival_Date') != '') { echo stripslashes($this->lang->line('Arrival_Date')); } else echo "Arrival Date";?></td>
        <td width="60%">5</td>
  </tr>
  <tr>
  		<td width="20%"><?php if($this->lang->line('Depature_Date') != '') { echo stripslashes($this->lang->line('Depature_Date')); } else echo "Depature Date";?></td>
     	<td width="60%">6</td>
  </tr>
  <tr>
  		<td width="20%"><?php if($this->lang->line('Adults') != '') { echo stripslashes($this->lang->line('Adults')); } else echo "Adults";?></td>
    	<td width="60%">7</td>
  </tr>
  <tr>
  		<td width="20%"><?php if($this->lang->line('Children') != '') { echo stripslashes($this->lang->line('Children')); } else echo "Children";?></td>
    	<td width="60%">8</td>
  </tr>
  <tr>	
  		<td width="20%"><?php if($this->lang->line('Comments') != '') { echo stripslashes($this->lang->line('Comments')); } else echo "Comments";?></td>
        <td width="60%">9</td>
  </tr>
 <?php /*?><?php } ?>	<?php */?>
</table>
     </div>
          </div>
            </div>
              </div>
   </body>
</html>