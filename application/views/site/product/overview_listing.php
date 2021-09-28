<?php
$this->load->view('site/templates/header');
$this->load->view('site/templates/listing_head_side');
?>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>

<script>
function overview() {

    document.getElementById("overviewlist").submit();
    
    
}
</script>



            <div class="right_side overview">
            
            <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('Overview') != '') { echo stripslashes($this->lang->line('Overview')); } else echo "Overview";?></h3>
                        



                        <p><?php if($this->lang->line('title_and_summary') != '') { echo stripslashes($this->lang->line('title_and_summary')); } else echo "Now let give tittle of the listing and summary description, that should cover major features of your space";?></p>
                    
                    </div>
                   <form onsubmit="return validate_form()" id="overviewlist" name="overviewlist" action="<?php echo base_url()."photos_listing/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8">
                    <div class="dashboard_price_right ovr_dash">
                    
                        <div class="overview_title">
                        
                            <label><?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?><span class="req"> *</span>
							<small> <?php if($this->lang->line('max_err') != '') { echo stripslashes($this->lang->line('max_err')); } else echo "Maximum";?> 15 <?php if($this->lang->line('max_wrds') != '') { echo stripslashes($this->lang->line('max_wrds')); } else echo "words";?></small>
							</label><br>
                        
                            <input type="text" title="<?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?>" onkeypress="return checkSpcialChar(event)"; value="<?php echo $listDetail->row()->product_title;?>" placeholder="<?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?>" class="title_overview " 
                            onchange="javascript:ChangeOVerview(this,<?php echo $listDetail->row()->id; ?>);" id="title" name="product_title" style="color:#000 !important;" />
							
                            <span id="words_left_title" style="margin-left:2px; color:red"> </span>
							
							<span id="title_error" style="color:#f00;display:none;">
							*<?php 	
	if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}	
	?>!</span>
							
							
                            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />
                            
                            <!--<span>35 characters left</span>-->
                        
                        </div>
                        
                        
                        <div class="overview_title">
                        
                            <label><?php if($this->lang->line('Summary') != '') { echo stripslashes($this->lang->line('Summary')); } else echo "Summary";?> <small> <?php if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";?></small><span class="req"> *</span></label>
                            
                            <textarea class="title_overview"  title="<?php if($this->lang->line('Summary') != '') { echo stripslashes($this->lang->line('Summary')); } else echo "Summary";?>" id="summary" placeholder="<?php if($this->lang->line('Summary') != '') { echo stripslashes($this->lang->line('Summary')); } else echo "Summary";?>" rows="8"name="description" id="description" style="color:#000 !important;min-width:100%;max-width:100%;"  onchange="javascript:ChangeOVerviewdesc(this,<?php echo $listDetail->row()->id; ?>);"><?php echo strip_tags($listDetail->row()->description);?></textarea>
                          <span id="words-left"  style="color:red"> </span>
						  
						  
						  <span id="summary_error" style="color:#f00;display:none;">
							*<?php 	
	if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}	
	?>!</span>
						  
						
                            <!--<span>250 characters left</span>-->
                        
                        </div>
						
					<!--	<div class="overview_title">
                        	<label><?php //if($this->lang->line('instant_pay') != '') { echo stripslashes($this->lang->line('instant_pay')); } else echo "Instant Pay";?> </label>
                            <input type ="radio" class="title_overview"   onchange="javascript:Changepay_option(this,<?php// echo $listDetail->row()->id; ?>);"  name="pay_option" <?php// if(!empty($listDetail)){ if($listDetail->row()->pay_option=='Request to book'){echo 'checked="checked"';}}?>  value="Request to book" style="color:#000 !important;"> Request to book
							<input type ="radio" class="title_overview"   onchange="javascript:Changepay_option(this,<?php //echo $listDetail->row()->id; ?>);"  name="pay_option" <?php// if(!empty($listDetail)){ if($listDetail->row()->pay_option=='Instant Pay'){echo 'checked="checked"';}}?>  value="Instant Pay" style="color:#000 !important;"> Instant Pay
                        </div>-->
						
						
						
		      <li>
                <div class="overview_title ovr_rdo">
                  <label> <?php if($this->lang->line('request_to_book') != '') { echo stripslashes($this->lang->line('request_to_book')); } else echo "Request to Book";?> </label>
                  <div class="form_input">                  
					  <div class="inpt_1"><input type="radio"  name="request_to_book" id="req_id_y"   onchange=" CheckStatus();"   <?php if(!empty($listDetail)){ if($listDetail->row()->request_to_book=='Yes'){echo 'checked="checked"';}}?> value="Yes"/><?php if($this->lang->line('Yes') != '') { echo stripslashes($this->lang->line('Yes')); } else echo "Yes";?></div>
					  <div class="inpt_1"><input type="radio"  name="request_to_book"  id="req_id_n"  onchange=" CheckStatus();" <?php if(!empty($listDetail)){ if($listDetail->row()->request_to_book=='No'){echo 'checked="checked"';}}?> value="No"/> <?php if($this->lang->line('No') != '') { echo stripslashes($this->lang->line('No')); } else echo "No";?>  </div>
                  </div>
                </div>
             </li>
			  
			
						
		<?php  if ($instant_pay->row()->status=='1') { ?>		  
		   <li>
			<div class="overview_title ovr_rdo">
			  <label ><?php if($this->lang->line('instant_pay') != '') { echo stripslashes($this->lang->line('instant_pay')); } else echo "Instant Pay";?> </label>
			  <div class="form_input">                  
					<div class="inpt_1"><input type="radio"  name="instant_pay" id="instant_y" onchange=" CheckStatusTwo();"  <?php if(!empty($listDetail)){ if($listDetail->row()->instant_pay=='Yes'){echo 'checked="checked"';}}?> value="Yes"/><?php if($this->lang->line('Yes') != '') { echo stripslashes($this->lang->line('Yes')); } else echo "Yes";?></div>
					<div class="inpt_1"><input type="radio"  name="instant_pay"   id="instant_n"  onchange=" CheckStatusTwo();" <?php if(!empty($listDetail)){ if($listDetail->row()->instant_pay=='No'){echo 'checked="checked"';}}?> value="No"/> <?php if($this->lang->line('No') != '') { echo stripslashes($this->lang->line('No')); } else echo "No";?> </div>
			  </div>
			</div>
			</li>
		<?php } ?>
                        <div class="ovr_btn">
                        <button type="submit" class="next_button"><?php if($this->lang->line('Next') != '') { echo stripslashes($this->lang->line('Next')); } else echo "Next";?></button>
                    </div>
                    </div>
                </form>
                </div>
            
            </div>
            <?php if($listDetail->row()->space =="" || $listDetail->row()->guest_access =="" || $listDetail->row()->interact_guest =="" || $listDetail->row()->neighbor_overview =="" || $listDetail->row()->neighbor_around =="" || $listDetail->row()->house_rules ==""){?>
             <p class="price_text_links ovrvw_para"><?php if($this->lang->line('Wanttowrite') != '') { echo stripslashes($this->lang->line('Wanttowrite')); } else echo "Want to write even more? You can also";?> <a href="detail_list/<?php echo $listDetail->row()->id;?>"> <?php if($this->lang->line('addadetaileddescription') != '') { echo stripslashes($this->lang->line('addadetaileddescription')); } else echo "add a detailed description";?></a><?php if($this->lang->line('toyourlisting') != '') { echo stripslashes($this->lang->line('toyourlisting')); } else echo "to your listing";?></p>
             <?php }?>
            </div>
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                <div class="left-calender_comment">
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    </div>
					<div class="right-calender_comment">
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('Agreattitle') != '') { echo stripslashes($this->lang->line('Agreattitle')); } else echo "A great summary";?></h2>
                    
                        <p><?php if($this->lang->line('Agreattitleisunique') != '') { echo stripslashes($this->lang->line('Agreattitleisunique')); } else echo "A great summary is rich and exciting! It should cover the major features of your space and neighborhood in 250 characters or less.";?></p>
                        
                        <p><strong><?php if($this->lang->line('example') != '') { echo stripslashes($this->lang->line('example')); } else echo "Example";?>:</strong><?php if($this->lang->line('Ourcooland') != '') { echo stripslashes($this->lang->line('Ourcooland')); } else echo "Our cool and comfortable one bedroom apartment with exposed brick has a true city feeling! It comfortably fits two and is centrally located on a quiet street, just two blocks from Washington Park. Enjoy a gourmet kitchen, roof access, and easy access to all major subway lines!";?>  </p>
                        
                    
                    </div></div>
                    
                    
                
                </div>
            
            </div>
            
        
        </div>
        
    </div>
	
	
	<?php 	
	if($this->lang->line('err_summary') != '')
			{ 
				$err_summary = stripslashes($this->lang->line('err_summary')); 
			} 
			else
			{
				$err_summary = "You can not type more than 150 words";
			}	
	?>
					
<input type="hidden" value="<?php echo $err_summary; ?>" name="err_summary" id="err_summary">



					
<input type="hidden" value="<?php echo "You can not type more than 15 words"; ?>" name="err_title" id="err_title">


    <script type="text/javascript" language="javascript">
        function limitKeyword(limitCount, limitNum) {
        var limitField = document.getElementById("product_name");
            if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
                } else {
                limitCount.value = limitNum - limitField.value.length;
            }
        }
</script>
    
<!---DASHBOARD-->

<script type="text/javascript">

	 // function checkSpcialChar(event){
	 
		// if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))){
		   // event.returnValue = false;	
		   // return;
		// }
		// event.returnValue = true;
	 // }

</script>
</script>

<!--<script>
function Changepay_option(evt,catID){
	var title = evt.value;
	//alert(title);
		$.ajax({
			type:'post',
			url:baseURL+'site/product/savepay_option',
			data:{'catID':catID,'title':title},
			
			complete:function(){
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Done').delay(800).text('');
			}
		});
}
</script>old instant Pay-->

<script type="text/javascript">
function CheckStatus(){
	
	var req=$('input[name="request_to_book"]:checked').val();
	var prd_id="<?php echo $listDetail->row()->id; ?>";
	
	
				var instant=$('input[name="instant_pay"]:checked').val();
				if (req=='No' && instant==null){
				alert("<?php 	if($this->lang->line('err_choose_yes') != '')
							{ 
								echo   stripslashes($this->lang->line('err_choose_yes')); 
							} 
							else
							{
								echo  "Please Choose Yes";
							} ?>");
				return false;
				}
	
	if (req=='No'){
		
		//$('#instant_y').attr('checked', 'checked');
		$('#instant_y').prop('checked', true);
	}
	
	ChangeRequestToBook(req,prd_id);
}
function CheckStatusTwo(){
	//alert("two");
	var instant=$('input[name="instant_pay"]:checked').val();
	var prd_id="<?php echo $listDetail->row()->id; ?>";
	if (instant=='No'){
		
		//$('#req_id_y').attr('checked', 'checked');
		$('#req_id_y').prop('checked', true);
	}
	
	ChangeInstantPay(instant,prd_id);
}
</script>

<script type="text/javascript">
function ChangeRequestToBook(evt,catID){
	//var title = evt.value;
		var title = evt;
	
	
		$.ajax({
			type:'post',
			url:baseURL+'site/product/saveRequestToBook',
			data:{'catID':catID,'title':title},
			
			complete:function(){
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Done').delay(800).text('');
			}
		});
}


function ChangeInstantPay(evt,catID){
	//var title = evt.value;
	var title = evt;
	//alert(title);
		$.ajax({
			type:'post',
			url:baseURL+'site/product/saveInstantPay',
			data:{'catID':catID,'title':title},
			
			complete:function(){
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Done').delay(800).text('');
			}
		});



}
</script>



<script type="text/javascript">
function validate_form()
{
	var title=$("#title");
	var summary=$("#summary");
	var contents = summary.val();
	var title_contents = title.val();
	var words = contents.split(/\b\S+\b/g).length - 1;
	var title_words = title_contents.split(/\b\S+\b/g).length - 1;


	var req=$('input[name="request_to_book"]:checked').val();
	var instant=$('input[name="instant_pay"]:checked').val();
	if (req=='No' && instant==null)
	{
		alert("<?php 	if($this->lang->line('err_choose_yes') != '')
		{ 
			echo   stripslashes($this->lang->line('err_choose_yes')); 
		} 
		else
		{
			echo  "Please Choose Yes";
		} ?>");
		return false;
	}
	if(title.val()=="" || summary.val()=="")
	{
		alert("<?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?>");
		return false;
	}	
	if(words > 150)
	{
		alert("Total of "+words+" words found! Summary should not exceed 150 words!");
		return false;
	}
	if (title_words > 15) {
		alert("Total of "+title_words+" words found! Tittle should not exceed 15 words!");
		return false;
	}
	
}
/* 
function control_words(data)
{
	var contents = data.value;
	var words = contents.split(/\b\S+\b/g).length;
	
	 if(words > 150)
	{
		$("#words-left").html("Summary should not exceed 150 words!");
		return false;
	}
	else
	{ 
		var words_remaining=151-parseInt(words);
		
		if(words_remaining!="0")
		{
			$("#words-left").html("You can add "+words_remaining+" more words!");
			return false;
		}
		 else if(words_remaining=="0")
		{
			$("#words-left").html("You reached the words limit!!");
			return false;
		} 

		ChangeOVerviewdesc(data,<?php echo $listDetail->row()->id; ?>);
	}
} */




var wordLenSum = 150,
		lenSum; 			
$('#summary').keydown(function(event) {	
	lenSum = $('#summary').val().split(/[\s]+/);
	if (lenSum.length > wordLenSum) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	}
	wordsLeftSum = (wordLenSum) - lenSum.length;
	if(wordsLeftSum < 0) {	
		 document.getElementById("words-left").innerHTML = "150 Words Reached";
	}else{
		$("#words-left").html("You can add "+wordsLeftSum+" more words!");
	}

//ChangeOVerviewdesc(description,<?php echo $listDetail->row()->id; ?>);
});


</script>

<!-- <script type="text/javascript">

var wordLen = 150,
		len; 
		
		var err=$("#err_summary").val();
		
		
$('#summary').keydown(function(event) {	
	len = $('#summary').val().split(/[\s]+/);
	if (len.length > wordLen) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	}
	
	wordsLeft = (wordLen) - len.length;
	//alert(wordsLeft);
	if(wordsLeft == 0) {
	
	//$('.words-left').html('You Can not Type More then 150 Words...!');
	 document.getElementById("words-left").innerHTML = err;
		
	}
});

</script> -->

<script type="text/javascript">
var wordLen1 = 15,
		len1; 
		var err1=$("#err_title").val();	
		
$('#title').keydown(function(event) {	
	len1 = $('#title').val().split(/[\s]+/);
	if (len1.length > wordLen1) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	}
	wordsLeft = (wordLen1) - len1.length;
	if(wordsLeft <= 0) {	
		 document.getElementById("words_left_title").innerHTML = err1;
	}else{
		$("#words_left_title").html("You can add "+wordsLeft+" more words!");
	}
});
</script>

<script>

/*$("#title").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("title_error").style.display = "inline";
  $("#title").focus();
  $("#title_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});

$("#summary").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("summary_error").style.display = "inline";
  $("#summary").focus();
  $("#summary_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});*/


</script>


<?php
$this->load->view('site/templates/footer');
?>

