



<?php if ($loginCheck != '' && !empty($productList)){
?>

<style>
@media only screen and (max-width: 515px) {
 
#cboxLoadedContent{width: 100% !important;}
#cboxContent{width: 430px !important; left: 34px; background: transparent;}
#inline_wishlist #form{    width: 100%; }
#cboxMiddleLeft{width: 0;}

}


@media only screen and (max-width: 475px) {
#cboxContent{width: 430px !important;   left: 18px; top: 0;}
}

@media only screen and (max-width: 450px) {
#cboxContent{left: 23px;     width: 390px !important;}
}

@media screen and (max-width: 425px) {
#cboxContent {left: 15px;}
}


@media only screen and (max-width: 414px) {
#cboxContent { left: 24px; width: 359px !important;}  

}


@media only screen and (max-width: 390px) {
#cboxContent {  left: 28px;  width: 330px !important;}  
#cboxLoadedContent{margin-top:0;}
}


@media only screen and (max-width: 370px) {
#cboxContent {left: 19px;}

}

@media only screen and (max-width: 352px) {
#cboxContent {  left: 11px;}  
 
}

@media only screen and (max-width: 344px) {
#cboxContent {  left: 6px;}

}

@media only screen and (max-width: 340px) {
#cboxContent {  left: 11px;     width: 320px !important;} 
}

@media only screen and (max-width: 335px) {
#cboxContent {  left: 18px;  width: 300px !important;}
}

@media only screen and (max-width: 324px) {
 #cboxContent {  left: 11px;}
 
}
.header.active
{
 box-shadow: none;
} 
</style>
<script type="text/javascript">
function CreateWishListCat(){
	$("#wishlist_warn").html("");
	var rental_id = $("#pid").val();
	//var user_id = $("#renter_id").val();
	var list_name= $("#list_name").val();
	$("#list_name").val("");
		if(list_name==""){
		$("#wishlist_warn").html("<?php if($this->lang->line('Please_enter_wishlist_category') != '') { echo stripslashes($this->lang->line('Please_enter_wishlist_category')); } else echo "Please enter wishlist category";?>.");
		return false;
		}else{
		$.ajax({
	        type: 'POST',
	        url: 'site/rentals/rentalwishlistcategoryAdd',
	        data: {"list_name":list_name,"rental_id":rental_id},
	        dataType: 'json',
	        success: function(json){
					if(json.result == '0'){
					 $('#WishListUl').prepend(json.wlist);
					}
					if(json.result == '1'){
						$("#wishlist_warn").html("<?php if($this->lang->line('This_category_already_exists') != '') { echo stripslashes($this->lang->line('This_category_already_exists')); } else echo "This category already exists";?>.");
					}
					return false;
			}
	    });
		}
		return false;

}
</script>


<!-- add_to_list overlay -->
<div class="popup ly-title update add-to-list animated newstaynest pdct_popup" id="inline_wishlist" >
<a class="close-btn" data-dismiss="modal" onclick="click_test()" id="pre-approve-close" style="cursor:pointer;"><span class="">x</span></a>
	<div class="default" style="display: block;">
		<p class="ltit"><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Add to List"; ?><!--<a class="clos-ars" href="javascript:void(0);">x</a>--></p>
        <h3><?php echo $productList->row()->product_title; ?></h3>
	<form action="site/rentals/AddToWishList" method="post" id="form" enctype="multipart/form-data" accept-charset="UTF-8">
	
		<div class="fancyd-item">
			<!-- <div class="image-wrapper">
				<div class="item-image"><img width="400" src="<?php if(strpos($productList->row()->product_image, 's3.amazonaws.com') > 1)echo $productList->row()->product_image;else base_URL().'server/php/rental/'.$productList->row()->product_image;?>"></div>
			</div> -->
            
			<div class="item-categories">
			
			<div class="detaild-area"><span><?php echo $productList->row()->product_title; ?></span>
            <span><?php  echo $productList->row()->CityName.', '.$productList->row()->State_name.', '.$productList->row()->Country_name; ?></span>
		</div>
		
		<span class="wishgarea">0 <?php if($this->lang->line('Wish_list') != '') { echo stripslashes($this->lang->line('Wish_list')); } else echo "Wish list";?></span>
				
                <input type="hidden" id="pid" name="pid" value="<?php echo $productList->row()->id; ?>" />
				<div class="ful-feld-areas">


				<fieldset class="list-categories">
					<div class="list-box">
					<ul id="WishListUl">
                    <?php 
					if(count($WishListCat->result()) > 0){
						foreach($WishListCat->result() as $wishlist){ 
							$WishRentalsArr=explode(',',$wishlist->product_id);
						?>
<li><label><input type="checkbox" class="messageCheckbox" name="wishlist_cat[]" value="<?php echo $wishlist->id; ?>" <?php if(in_array($productList->row()->id,$WishRentalsArr)){ ?>checked="checked" <?php } ?> /><?php echo $wishlist->name; ?></label></li>
<?php } 
 } ?>

</ul></div></fieldset>
					<fieldset class="new-list">
						
						<input type="text" placeholder="<?php if($this->lang->line('Create New List') != '') { echo stripslashes($this->lang->line('Create New List')); } else echo "Create New List"; ?>" value="" name="list_name" id="list_name">
                        <p id="wishlist_warn " style="color:#FF0000; background:#CCCCCC;"></p>
						<a class="btn-create" href="javascript:void(0);" onclick="return CreateWishListCat();" ><?php if($this->lang->line('Create') != '') { echo stripslashes($this->lang->line('Create')); } else echo "Create"; ?></a>
					</fieldset>
					
					
				
			</div>
			
			
			<div class="notes-area"><span class="add-text"><?php if($this->lang->line('Add Notes') != '') { echo stripslashes($this->lang->line('Add Notes')); } else echo "Add Notes"; ?></span>
					<?php if(count($notesAdded->result()) == 0){?>
					<textarea name="add-notes" class="add-notes"></textarea>
					<input type="hidden" id="nid" name="nid" value="" />
					<?php }
					if(count($notesAdded->result()) == 1){?>
						<textarea name="add-notes" class="add-notes"><?php echo $notesAdded->row()->notes;?></textarea>
						<input type="hidden" id="nid" name="nid" value="<?php echo $notesAdded->row()->id;?>" />
					<?php }?> 
				   </div>
		</div></div>
		<div class="btn-area">
				<input class="btn-add-to-list btn-done" type="submit" onclick="return validate();" name="submit" value="<?php if($this->lang->line('Done') != '') { echo stripslashes($this->lang->line('Done')); } else echo "Done"; ?>"/>
				
			</div>
            </form>
	</div>
    </div>
<script>
$(document).ready(function(){
  $(".wishgarea").click(function(){
    $(".ful-feld-areas").addClass("disply-imputant");
  });
});

function click_test(){

$('#cboxOverlay').click();

}
</script>
<script type="text/javascript">
function validate(){
var checkedValue = $('.messageCheckbox:checked').val();
if (!checkedValue){
alert("<?php if($this->lang->line('please_Choose_Wishlist_Name') != '') { echo stripslashes($this->lang->line('please_Choose_Wishlist_Name')); } else echo "please Choose Wishlist Name";?>");
return false;
}
else{
return true;
}


}
</script>



<?php }?>