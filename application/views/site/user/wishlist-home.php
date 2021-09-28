<?php 
$this->load->view('site/templates/header',$this->data);
//$this->load->view('site/popup/list',$this->data);

$wuser=$WishlistUserDetails->row();

//echo '<pre>'; print_r($WishListCat->result());die;

?>
<script type="text/javascript">

function CreateWishListCat(){
	$("#wishlist_warn").html("");
	var rental_id = $("#pid").val();
	//var user_id = $("#renter_id").val();
	var list_name= $("#list_name").val();
	$("#list_name").val("");
		if(list_name==""){
		$("#wishlist_warn").html("<?php if($this->lang->line('Please_enter_wishlist_category') != '') { echo stripslashes($this->lang->line('Please_enter_wishlist_category')); } else echo "Please enter wishlist category";?>");
		return false;
		}else{
		$.ajax({
	        type: 'POST',
	        url: 'site/rentals/rentalwishlistcategoryAdd',
	        data: {"list_name":list_name,"rental_id":rental_id},
	        dataType: 'json',
	        success: function(json){
					if(json.result == '0'){
						window.location.reload();
					}
					if(json.result == '1'){
						$("#wishlist_warn").html("<?php if($this->lang->line('This_category_already_exists') != '') { echo stripslashes($this->lang->line('This_category_already_exists')); } else echo "This category already exists";?>");
					}
					return false;
			}
	    });
		}
		return false;
}
</script>

<div style="display:none">
<div style="margin-top: 5px; margin-left: 20.5px; opacity: 1;"  class="popup ly-title update add-to-list animated" id="create_wishlist" >
	<div class="default" style="display: block;">
		<p class="ltit"><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Add to List"; ?></p>
	<div class="fancyd-item" style="padding:10px 0px;">
		<div class="item-categories" style="border:none;">
				
                <input type="hidden" id="pid" name="pid" value="" />
					<fieldset class="list-categories" style="border:none;">
					<div class="list-box">
					<ul id="WishListUl">
                    <?php 
					if(count($WishListCat->result()) > 0){
						foreach($WishListCat->result() as $wishlist){ 
							$WishRentalsArr=explode(',',$wishlist->product_id);
						?>
<!-- <li><label><?php echo $wishlist->name; ?></label></li>  -->
<?php } 
 } ?>

</ul></div></fieldset>
					<fieldset class="new-list" style="border:1px solid #ccc;">
						
						<input type="text" placeholder="<?php if($this->lang->line('header_create_nwlist') != '') { echo stripslashes($this->lang->line('header_create_nwlist')); } else echo "Create New List"; ?>" value="" name="list_name" id="list_name">
                        
						<a class="btn-create create-button" href="javascript:void(0);" onclick="return CreateWishListCat();" ><?php if($this->lang->line('header_create') != '') { echo stripslashes($this->lang->line('header_create')); } else echo "Create"; ?></a>
                        <p id="wishlist_warn" style="color:#FF0000; background:#CCCCCC; display:inline-block; width:100%; "></p>
					</fieldset>
				
			</div>
		</div>
	</div>
    </div>
    </div>
<div class="wishlists-container"><div class="index_view clearfix">
<div class="yourlisting bgcolor">
<div class="top-listing-head"  id="wishli_pg">
 <div class="main">   
 
 
           <ul id="nav">
                <li><a href="<?php echo base_url(); ?>popular" class="write_title pgd_akr"><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a></li>
          <?php if($loginCheck!=''){ ?>
          <!--<li><a href="<?php echo base_url(); ?>browsefriends" class="write_title"><?php if($this->lang->line('Friends') != '') { echo stripslashes($this->lang->line('Friends')); } else echo "Friends"; ?></a></li>-->
          <li class="active"><a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists" class="write_title"><?php if($this->lang->line('MyWishLists') != '') { echo stripslashes($this->lang->line('MyWishLists')); } else echo "My Wish Lists"; ?></a></li>
          <?php } ?>
              <li></li>
            </ul>




			</div></div></div>

  <div class="holder-top-bar">
  <div class="container top-bar">
   
      <div class="top-bar-wishlist">
        <div class="wishlist-header-badge one-line">
        
        
          <a href="users/show/<?php echo $wuser->id; ?>">
          <?php if($_SESSION['login_type'] == 'google'){?>
          	<div class="matte-media-box">
              <img class="users" width="70" height="70" alt="<?php echo ucfirst($wuser->firstname); ?>" src="<?php if($wuser->image !=''){echo $wuser->image;}else{echo 'images/users/user_thumb.png';} ?>">
            </div>
          	<?php } else{?>
            <div class="matte-media-box">
              <img class="users" width="70" height="70" alt="<?php echo ucfirst($wuser->firstname); ?>" src="<?php if($wuser->image !=''){echo 'images/users/'.$wuser->image;}else{echo 'images/users/user-thumb.png';} ?>">
            </div>
           <?php }?> 
          </a>
		  <!--<h1 class="users-name"><?php //echo ucfirst($wuser->firstname); ?>'<?php //if($this->lang->line('s_wish_list') != '') { echo stripslashes($this->lang->line('s_wish_list')); } else echo "s Wish Lists"; ?></h1>-->
          <h1 class="users-counts"><?php if($this->lang->line('wish_list_count') != '') { echo stripslashes($this->lang->line('wish_list_count')); } else echo "Wishlists:"; ?><span class="item-count"> (<?php echo $WishListCat->num_rows(); ?>)</span></h1>
        
        
        </div>
      </div>
      <div class="top-bar-wishlist top-right-container">
        <p class="position-right"><a data-toggle="modal" href="#myModal"  class="my-btn1 gray1 create1"><?php if($this->lang->line('Createnewwishlist') != '') { echo stripslashes($this->lang->line('Createnewwishlist')); } else echo "Create New Wishlist"; ?></a></p>
      </div>
   
  </div>  </div>

    <div class="holder-wishlists-body">

  <div class="container wishlists-body">
  	 <input type="hidden" value="1" id='page_number' /> 
  	<?php if($WishListCat->num_rows() > 0){ ?>
    <ul class="wishlists-list" id="dev_prodcut_load_section">
    <?php 
	
		foreach($WishListCat->result() as $wlist){
			//print_r($wlist);
			//display is based on property only . but have to check for experience also
			/*
			if($wlist->product_id !=''){
				$products=explode(',',$wlist->product_id);
				$productsNotEmy=array_filter($products);
				$CountProduct1=count($productsNotEmy);
				
				if($CountProduct1 > 0){
				$CountProduct = $this->shop->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
				//print_r($CountProduct1);
				
				}
				 ?>
			  	<li  class="wishlists-list-item has-photo-pile">
				<div class="photo-heart-container">
				 
					<div class="photo-pile">
					 
					  <div class="matte-media-box">
					  <div class="top-matte-box">
					  	<div class="pull-left">
					  			<i class="fa fa-bed" aria-hidden="true"></i> <span class="mywish"><?php echo $wlist->name; ?></span>
					  	</div>
					  	<div class="pull-right">
					  		 <a href="user/<?php echo $loginCheck;?>/wishlists/<?php echo $wlist->id;?>">
					  <span class="color-gray font-tiny listings-count listt"><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $CountProduct1." "; ?><?php if($this->lang->line('Listings') != '') { echo stripslashes($this->lang->line('Listings')); } else echo "Listings"; ?></span> </a>
					  	</div>
					  
					  </div>
					  <div class="bottom-matte-box">
					  <a href="user/<?php echo $loginCheck;?>/wishlists/<?php echo $wlist->id;?>"><img class="wish-main-img" alt="Vacation Places" src="<?php if($CountProduct > 0){ $ProductsImg = $this->shop->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); if($ProductsImg->row()->product_image!=''){ echo base_url().PRODUCTPATH.$ProductsImg->row()->product_image;}else{echo 'images/product/dummyProductImage.jpg';}}else{echo 'images/site/empty-wishlist.jpg';} ?>"/></a></div>

                     <!--  <div class="wishlist-label-outer-container">
						<div class="wishlist-label-inner-container">
						  <div class="wishlist-label panel-background-dark-trans inner-glow panel-border">
							
							
							
						  </div>
						</div>
					  </div> -->
                      </div>
					</div>
					 
				 

				</div>
		
			  </li>
				<?php }
				*/
				//display based on both property and experience
				if($wlist->last_added!='0'){ 

					$CountExperience = 0;
					$products 		=	explode(',',$wlist->product_id);
					$productsNotEmy =	array_filter($products);
					$CountProduct1	=	count($productsNotEmy);

					if($experienceExistCount>0)
					{
						$experiences 		= 	explode(',',$wlist->experience_id);
						$experienceNotEmy	=	array_filter($experiences);
						$CountExperience	=	count($experienceNotEmy);
					}
					$totCount = $CountProduct1 + $CountExperience;	

					$imgPath = 'images/site/empty-wishlist.jpg';
					if($wlist->last_added=='1'){
						$CountProduct = $this->shop->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
						if($CountProduct > 0){ 
							$ProductsImg = $this->shop->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
							if($ProductsImg->row()->product_image!=''){
							 $imgPath = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
							}
							else{
								$imgPath = 'images/product/dummyProductImage.jpg';
							}
						}
						
					}else if($experienceExistCount>0){
						 if($wlist->last_added=='2'){
							$CountProduct = $this->shop->get_all_details(EXPERIENCE,array('experience_id'=>end($experienceNotEmy)))->num_rows(); 
							if($CountProduct > 0){ 
								$ProductsImg = $this->shop->get_all_details(EXPERIENCE_PHOTOS,array('product_id'=>end($experienceNotEmy))); 
								if($ProductsImg->row()->product_image!=''){
								 $imgPath = base_url().EXPERIENCEPATH.$ProductsImg->row()->product_image;
								}
								else{
									$imgPath = 'images/product/dummyProductImage.jpg';}
							}
						}
					}
				?>

					<li  class="wishlists-list-item has-photo-pile">
						<div class="photo-heart-container">

							<div class="photo-pile">

								<div class="matte-media-box">
									<div class="top-matte-box">
										<div class="pull-left">
											<i class="fa fa-bed" aria-hidden="true"></i> <span class="mywish"><?php echo $wlist->name; ?></span>
										</div>
										<div class="pull-right">
											<a href="user/<?php echo $loginCheck;?>/wishlists/<?php echo $wlist->id;?>">
											<span class="color-gray font-tiny listings-count listt"><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $totCount." "; ?><?php if($this->lang->line('Listings') != '') { echo stripslashes($this->lang->line('Listings')); } else echo "Listings"; ?></span> </a>
										</div>

									</div>
									<div class="bottom-matte-box">
										<a href="user/<?php echo $loginCheck;?>/wishlists/<?php echo $wlist->id;?>"><img class="wish-main-img" alt="<?php echo $wlist->name; ?>" src="<?php echo $imgPath;?>"/></a></div>

									<!--  <div class="wishlist-label-outer-container">
									<div class="wishlist-label-inner-container">
									<div class="wishlist-label panel-background-dark-trans inner-glow panel-border">



									</div>
									</div>
									</div> -->
								</div>
							</div>



						</div>

					</li>
					<?php
				}
				else{ ?>
                <li  class="wishlists-list-item has-photo-pile">
                            <div class="photo-heart-container">
                                <div class="photo-pile">
                                  <div class="matte-media-box">
                          <div class="top-matte-box">         
					  	<div class="pull-left">
					  			<i class="fa fa-bed" aria-hidden="true"></i> <span class="mywish"><?php echo $wlist->name; ?></span>
					  	</div>
					  	<div class="pull-right" >
					  		
					  <span class="color-gray font-tiny listings-count listt"><?php echo '0 '; ?><?php if($this->lang->line('Listings') != '') { echo stripslashes($this->lang->line('Listings')); } else echo "Listings"; ?></span>
					  	</div></div>
						<div class="bottom-matte-box">
					  	<img alt="Vacation Places" src="images/site/empty-wishlist.jpg" class="wish-main-img"></div>
					 

                                                                    </div>
                                  
                                </div>
                             
                            </div>
                    
                          </li>
                <?php }
                    }
                 ?>
    </ul>
    <div class="ajax-loading" style="display: none"><img src="<?php echo base_url(); ?>/css/pre-loader/loader.gif" /></div>
<?php } ?>
  </div>  </div>

</div></div>











<div id="myModal" class="modal fade in wisthlistpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-create modal-content">
<div class="panel-header"><?php if($this->lang->line('Createnewwishlist') != '') { echo stripslashes($this->lang->line('Createnewwishlist')); } else echo "Create New Wishlist"; ?></div>
<form action="" accept-charset="UTF-8">
<div class="panel-body">
<input type="hidden" value="10042418" name="user_id">
<label for="wishlist_name"><?php if($this->lang->line('WishListName') != '') { echo stripslashes($this->lang->line('WishListName')); } else echo "Wish List Name"; ?></label>
<input  id="wishlist_name" type="text" name="list_name">
<label class="row-space-top-2"><?php if($this->lang->line('Whocanseethis') != '') { echo stripslashes($this->lang->line('Whocanseethis')); } else echo "Who can see this?"; ?></label>
<div class="">
<div class="col-middle">
<div id="wishlist-edit-privacy-setting" class="select-block">
<select id="wish_select" name="wish_select">

 
<option value="0"> <?php if($this->lang->line('Everyone') != '') { echo stripslashes($this->lang->line('Everyone')); } else echo "Everyone";?> </option>

<option value="1"> <?php if($this->lang->line('Only_Me') != '') { echo stripslashes($this->lang->line('Only_Me')); } else echo "Only Me";?> </option>
</select>
</div>
<p id="wishlist_warn_cat" style="color:#FF0000; background:#CCCCCC; display:inline-block; width:100%; "></p>
</div>

</div>
</div>

<div class="panel-footer wish_btn">
<button  onclick="return Create_WishListCat();" class="btn btn-primary save" type="submit"><?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save"; ?></button>
<button style="float: right; " class="cancel" data-dismiss="modal" type="button"><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>

</div>
</form>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function Create_WishListCat(){
	$("#wishlist_warn_cat").html("");
	//var rental_id = $("#pid").val();
	//var user_id = $("#renter_id").val();
	var list_name= $("#wishlist_name").val();
	$("#list_name").val("");
	var select = $("#wish_select").val();
		if(list_name==""){
		$("#wishlist_warn_cat").html("<?php if($this->lang->line('Please_enter_wishlist_category') != '') { echo stripslashes($this->lang->line('Please_enter_wishlist_category')); } else echo "Please enter wishlist category";?>");
		return false;
		}else{

			$.ajax({
		        type: 'POST',
		        url: 'site/rentals/rentalwishlistcategoryAdd',
		        data: {"list_name":list_name,"whocansee":select},
		        dataType: 'json',
		        success: function(json){
						if(json.result == '0'){
							window.location.reload();
						}
						if(json.result == '1'){
							$("#wishlist_warn_cat").html("<?php if($this->lang->line('This_category_already_exists') != '') { echo stripslashes($this->lang->line('This_category_already_exists')); } else echo "This category already exists";?>");
						}
						return false;
				}
		    });
		}
		return false;
}
</script>
<script>
/* Page Scroll Pagination starts */ 
var page = $("#page_number").val(); //track user scroll as page number, right now page number is 1
//load_more(page); //initial content load
$(window).scroll(function() { //detect page scroll
    if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
        page++; //page number increment

        $("#page_number").val(page);

        load_more(page); //load content   
    }
});     
function load_more(page){
  
  $.ajax(
        {
            url: '<?php echo base_url("load_wishlist_pagination"); ?>'+'?page=' + page,
            type: "get",
            datatype: "html",
            beforeSend: function()
            {
                $('.ajax-loading').show();
            }
        })
        .done(function(data)
        {
            console.log(data.length);
            if(data.length == 503){
            
               
                //notify user if nothing to load
                $('.ajax-loading').html('<div class="noDataTxt">No more data</div>');
                return;
            }else{
                $('.ajax-loading').hide(); //hide loading animation once data is received
                $("#dev_prodcut_load_section").append(data); //append data into #results element     
            }     
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            //alert('No response from server');
             
        });
 }

 /* Page Scroll Pagination ends */  
 </script>

<?php 
$this->load->view('site/templates/footer',$this->data);
?>
