<?php
$this->load->view('site/templates/header',$this->data);
?>
<style>
.button:hover {
	background: #3e73b7;
}
.button {
	cursor: pointer;
	overflow: visible;
	margin: 5px 0px;
	padding: 8px 8px 10px 7px;
	border: 0;
	border-radius: 4px;
	font-weight: bold;
	font-size: 15px;
	line-height: 22px;
	text-align: center;
	color: #fff;
	background: #588cc7;
}
ol.commentContainer{
	height: 200px;
	overflow: scroll;
	width: 900px;
}
</style>
<div id="container-wrapper">
	<div class="container notify" style="width:940px;">
		


	<div id="content">
		
		<div class="notifications altered">
		<?php if ($order_details->num_rows()>0){
		$subTotal = $order_details->row()->total-($order_details->row()->tax+$order_details->row()->shippingcost)+$order_details->row()->discountAmount;
		?>
			<div class="review_top">
				<p class="fl"><span class="r_left fl"><?php if($this->lang->line('Order_Id') != '') { echo stripslashes($this->lang->line('Order_Id')); } else echo "Order Id";?> : </span><span class="fl">#<?php echo $order_details->row()->dealCodeNumber;?></span></p>
				<p class="fr"><span class="r_left fl"><?php if($this->lang->line('Sub_Total') != '') { echo stripslashes($this->lang->line('Sub_Total')); } else echo "Sub Total";?> : </span><span class="fl"><?php echo $currencySymbol.number_format($subTotal,2);?></span></p>
				<div style="clear: both;"></div>
				<p class="fl"><span class="r_left fl"><?php if($this->lang->line('Order_Date') != '') { echo stripslashes($this->lang->line('Order_Date')); } else echo "Order Date";?> : </span><span class="fl"><?php echo $order_details->row()->created;?></span></p>
				<p class="fr"><span class="r_left" style="clear:both;"><?php if($this->lang->line('Discount') != '') { echo stripslashes($this->lang->line('Discount')); } else echo "Discount";?> : </span><span class=""><?php echo $currencySymbol.$order_details->row()->discountAmount;?></span></p>
				<p class="fr" style="width:100%;text-align:right;"><span class="r_left" style="clear:both;"><?php if($this->lang->line('Shipping') != '') { echo stripslashes($this->lang->line('Shipping')); } else echo "Shipping";?> : </span><span class=""><?php echo $currencySymbol.$order_details->row()->shippingcost;?></span></p>
				<p class="fr" style="width:100%;text-align:right;"><span class="r_left" style="clear:both;"><?php if($this->lang->line('Tax') != '') { echo stripslashes($this->lang->line('Tax')); } else echo "Tax";?> : </span><span class=""><?php echo $currencySymbol.$order_details->row()->tax;?></span></p>
				<p class="fr" style="width:100%;text-align:right;"><span class="r_left" style="clear:both;"><?php if($this->lang->line('Grand_Total') != '') { echo stripslashes($this->lang->line('Grand_Total')); } else echo "Grand Total";?> : </span><span class=""><?php echo $currencySymbol.$order_details->row()->total;?></span></p>
			</div>
<!-- 			<hr class="review_hr"> -->
		<?php 
		foreach ($order_details->result() as $orderRow){
			if ($prod_details[$orderRow->product_id]->num_rows()==1){
				$prodImg = 'dummyProductImage.jpg';
				$imgArr = array_filter(explode(',', $prod_details[$orderRow->product_id]->row()->image));
				if (count($imgArr)>0){
					$prodImg = $imgArr[0];
				}
		?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="float:left;border:1px solid #cecece; width:99.5%;">
		        <tbody>
			        <tr bgcolor="#f3f3f3">
			        	<td width="14%" style="border-right:1px solid #cecece; text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;"><?php if($this->lang->line('Product_Image') != '') { echo stripslashes($this->lang->line('Product_Image')); } else echo "Product Image";?></span></td>
			            <td width="42%" style="border-right:1px solid #cecece;text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;"><?php if($this->lang->line('Product_Name') != '') { echo stripslashes($this->lang->line('Product_Name')); } else echo "Product Name";?></span></td>
			            <td width="8%" style="border-right:1px solid #cecece;text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;"><?php if($this->lang->line('Qty') != '') { echo stripslashes($this->lang->line('Qty')); } else echo "Qty";?></span></td>
			            <td width="10%" style="border-right:1px solid #cecece;text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;"><?php if($this->lang->line('Unit_Price') != '') { echo stripslashes($this->lang->line('Unit_Price')); } else echo "Unit Price";?></span></td>
			            <td width="10%" style="text-align:center;border-right:1px solid #cecece;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;"><?php if($this->lang->line('Sub_Total') != '') { echo stripslashes($this->lang->line('Sub_Total')); } else echo "Sub Total";?></span></td>
			            <td width="20%" style="text-align:center;"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;"><?php if($this->lang->line('Received_Status') != '') { echo stripslashes($this->lang->line('Received_Status')); } else echo "Received Status";?></span></td>
			         </tr><tr>
			            <td style="border-right:1px solid #cecece; text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><img src="<?php echo base_url();?>images/product/<?php echo $prodImg;?>" alt="<?php echo $prod_details[$orderRow->product_id]->row()->product_title;?>" width="70"></span></td>
						<td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><?php echo $prod_details[$orderRow->product_id]->row()->product_title;?>
                        <?php if($orderRow->attr_name !=''){ echo '<br>'.$orderRow->attr_name;}?>
                        
                        </span></td>
			            <td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><?php echo $orderRow->quantity;?></span></td>
			            <td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><?php echo $currencySymbol.$orderRow->price;?></span></td>
			            <td style="text-align:center;border-top:1px solid #cecece;border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><?php echo $currencySymbol.$orderRow->sumtotal;?></span></td>
			            <td style="text-align:center;border-top:1px solid #cecece;">
			            <?php if ($view_mode=='user'){?>
			            	<select style="margin: 10px;border:1px solid;" onchange="javascript:changeReceivedStatus(this,'<?php echo $orderRow->id;?>')">
	                        	<option <?php if ($orderRow->received_status == 'Not received yet'){echo 'selected="selected"';}?> value="Not received yet"><?php if($this->lang->line('order_not_received_yet') != '') { echo stripslashes($this->lang->line('order_not_received_yet')); } else echo "Not received yet"; ?></option>
	                        	<option <?php if ($orderRow->received_status == 'Product received'){echo 'selected="selected"';}?> value="Product received"><?php if($this->lang->line('order_product_received') != '') { echo stripslashes($this->lang->line('order_product_received')); } else echo "Product received"; ?></option>
<!-- 	                        	<option <?php if ($orderRow->received_status == 'Need refund'){echo 'selected="selected"';}?> value="Need refund"><?php if($this->lang->line('order_need_refund') != '') { echo stripslashes($this->lang->line('order_need_refund')); } else echo "Need refund"; ?></option> -->
	                        </select>
	                        <img alt="Loading" style="display: none;margin-top:20px;" class="status_loading_<?php echo $row->dealCodeNumber;?>" src="images/site/ajax-loader.gif"/>
	                    <?php }else {?>
	                    	<span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;"><?php echo $orderRow->received_status;?></span>
	                    <?php }?>    
			            </td>
			        </tr>
		        </tbody>
	        </table>
	        <div class="review_comments" style="float: left;">
	        	<h2><?php if($this->lang->line('Comments') != '') { echo stripslashes($this->lang->line('Comments')); } else echo "Comments";?></h2>
	        	 <?php 
	        	 if ($order_comments->num_rows()>0){
	        	 ?>
	        	 <section class="comments comments-list comments-list-new">
		        	 <ol class="commentContainer">
		        	 <?php 
		        	 $cmt_count = 0;
		        	 foreach ($order_comments->result() as $cmt_row){
		        	 	if ($cmt_row->product_id == $orderRow->product_id){
		        	 		$cmt_count++;
			        	 	$comment_from = $cmt_row->comment_from;
		        	 		$userImg = 'user-thumb.png';
			        	 	if ($comment_from == 'admin'){
				        	 	$userImg = 'user_thumb.png';
			        	 	}else if ($comment_from == 'seller'){
				        	 	$userImg = 'user-thumb1.png';
			        	 	}
			        	 	if ($view_mode == 'user'){
			        	 		if ($comment_from == 'user'){
			        	 			$comment_from = 'You';
			        	 		}			        	 			
			        	 	}else if ($view_mode == 'seller'){
			        	 		if ($comment_from == 'seller'){
			        	 			$comment_from = 'You';	
			        	 		}
			        	 		if ($comment_from == 'user'){
			        	 			$comment_from = 'Buyer';
			        	 		}
			        	 	}
		        	 		
			        	 	$cmtTime = strtotime($cmt_row->date);
			        	 	$cmt_time = timespan($cmtTime).' ago';
		        	 ?>
		        		 <li class="comment" style="position: relative;padding: 17px 0 12px 43px;z-index: 1;min-height: 20px;">
							<a class="milestone" id="comment-1866615"></a>
							<span class="vcard">
								<a class="url">
									<img src="images/users/<?php echo $userImg;?>" alt="" class="photo">
									<span class="fn nickname"><?php echo ucfirst($comment_from);?></span>
								</a>
							</span>
							<p class="c-text" style="font-size:13px;"><?php echo $cmt_row->comment;?></p>
							<p style="font-size: 10px;font-style:italic;color:green;"><?php echo $cmt_time;?></p>
						</li>
					<?php 
		        	 	}
		        	 }
					?>	
					</ol>
				</section>
				<?php 
				if ($cmt_count==0){
				?>
				<p style="margin: 10px 0 0;color: #0F6697;"><i><?php if($this->lang->line('No_comments_available') != '') { echo stripslashes($this->lang->line('No_comments_available')); } else echo "No comments available";?></i></p>
				<?php 	
				}
	        	 }else {
				?>
				<p style="margin: 10px 0 0;color: #0F6697;"><i><?php if($this->lang->line('No_comments_available') != '') { echo stripslashes($this->lang->line('No_comments_available')); } else echo "No comments available";?></i></p>
				<?php }?>
				<div style="margin:20px 0;float:left;">
					<form action="javascript:void(0)" onsubmit="post_order_comment('<?php echo $orderRow->product_id;?>','<?php echo $view_mode;?>','<?php echo $loginCheck;?>','<?php echo $order_details->row()->dealCodeNumber;?>')" method="post">
					<?php if($this->lang->line('Login required') != '')
							{ 
								$login_required = stripslashes($this->lang->line('Login required')); 
							} 
							else
							{
								$login_required = "Login required";
							}
							if($this->lang->line('Your comment is empty') != '')
							{ 
								$comment_empty = stripslashes($this->lang->line('Your comment is empty')); 
							} 
							else
							{
								$comment_empty = "Your comment is empty";
							}
							?>
							<input type="hidden" value="<?php echo $login_required; ?>" name="login_required" id="login_required">
							<input type="hidden" value="<?php echo $comment_empty; ?>" name="comment_empty" id="comment_empty">
	                    <textarea class="text order_comment_<?php echo $orderRow->product_id;?>" name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments"></textarea><br />
	                    <input type="submit" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="submit button" value=" <?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post Comment"; ?> " />
	                    <img alt="loading" src="images/site/loading.gif" style="display: none;"/>
	                </form>
                </div>
	        </div>
	      <?php 
			}
		}
	      ?>  
	       <?php }else{?>
	       <h3><?php if($this->lang->line('Reviews_not_available') != '') { echo stripslashes($this->lang->line('Reviews_not_available')); } else echo "Reviews not available";?></h3>
	       <?php }?> 
		</div>
		
	</div>
   		
		<?php 
		$this->load->view('site/templates/footer_menu',$this->data);
		?>

	</div>
	<!-- / container -->
</div>
<?php
$this->load->view('site/templates/footer',$this->data);
?>
