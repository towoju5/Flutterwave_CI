<?php 

$this->load->view('site/templates/header');
?>

<script type="text/javascript">
function setPagination(id) {
  $('#paginationId').val(id);
  $('#search_result_form').submit();
}
</script>
<style>
@media only screen and (max-width: 515px) {
	
#cboxLoadedContent{width: 100% !important;}
#cboxContent{width: 315px !important;
    left:0px; background: transparent;}
#inline_wishlist #form{    width: 100%; }
#cboxMiddleLeft{width: 0;}

}


@media only screen and (max-width: 475px) {
#cboxContent{width: 295px !important;   left:8px; top: 0;}
}

@media only screen and (max-width: 450px) {
#cboxContent{left:0px;     width: 310px !important;}
}

@media screen and (max-width: 425px) {
#cboxContent {left:0px;}
}


@media only screen and (max-width: 414px) {
#cboxContent { left: 3px; width: 300px !important;}	

}


@media only screen and (max-width: 390px) {
#cboxContent {  left:5px;  width:300px !important;}	
#cboxLoadedContent{margin-top:0;}
}


@media only screen and (max-width: 370px) {
#cboxContent {left:4px;}

}

@media only screen and (max-width: 352px) {
#cboxContent {  left:7px;}	
	
}

@media only screen and (max-width: 344px) {
#cboxContent {  left:7px; }

}

@media only screen and (max-width: 340px) {
#cboxContent {  left: 11px; width: 290px !important;}	
}

@media only screen and (max-width: 335px) {
#cboxContent {  left: 18px;  width: 276px !important;}
}


@media only screen and (max-width: 324px) {
	#cboxContent {  left: 16px;}
}




</style>

		  <form action="<?php echo base_url().'popular';?>" method='POST' id='search_result_form'>
      <input type="hidden" name="paginationId" id="paginationId" value="<?php if($paginationId!='')echo $paginationId;else echo '0';?>" />
      </form>

 <div class="yourlisting bgcolor" id="popul_li">
<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li class="active"><a href="<?php echo base_url(); ?>popular" class="write_title"><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a></li>
          <?php if($loginCheck!=''){ ?>
          <!--<li><a href="<?php echo base_url(); ?>browsefriends" class="write_title"><?php if($this->lang->line('Friends') != '') { echo stripslashes($this->lang->line('Friends')); } else echo "Friends"; ?></a></li>-->
          <li><a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists" class="write_title"><?php if($this->lang->line('MyWishLists') != '') { echo stripslashes($this->lang->line('MyWishLists')); } else echo "My Wish Lists"; ?></a></li>
          <?php } ?>
              <li></li>
            </ul> </div></div></div>

<div class="body_content popular_body_cont">
	<div class="container">


    <div>
      <input type="hidden" value="1" id='page_number' /> 
    <?php  if($product->num_rows()>0)
          { ?>
      <ul class="popular-listing" id="dev_prodcut_load_section">
   <?php  //echo("<pre>");print_r($product->result());die; ?>
       <?php  $count=0;
      
   	foreach($product->result_array() as $product_image )
   	{ $count++;
   	if(($count%5)==0)
   	{ 
   		$li_class_name='big-poplr';
   	}else {
   		$li_class_name='';
   	}
   	?>
   <li class="<?php echo $li_class_name; ?>">
   <div class="img-top">
           <div class="figures-cobnt">
         <?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/rental/'.$product_image['product_image'])))
           {?>
            <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
			<img src="<?php echo base_url();?>server/php/rental/<?php echo $product_image['product_image'];?>">
               </a>
              <?php }else if($product_image['product_image']!='' && strpos($product_image['product_image'], 's3.amazonaws.com') > 1){?> 
               <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
              <img src="<?php echo  $product_image['product_image'];?>">
              </a>
              <?php } else {?>
			   <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
              <img src="<?php echo  base_url();?>server/php/rental/dummyProductImage.jpg">
              </a>
			  <?php } ?>
            </div>
           <div class="posi-abs" id="popular_star">
            <!-- <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>"  class="heart"> </a>-->
			<?php if($loginCheck==''){?>
              <a class="ajax cboxElement heart reg-popup" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"></a>
			 
			 <?php } else { ?>
            <a class="ajax cboxElement <?php if(in_array($product_image['id'],$newArr))echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"></a>
			<?php }?>
            
           <label class="pric-tag"><?php

		  // echo  $this->session->userdata('currency_s').' '.stripslashes($product_image['price']) * $this->session->userdata('currency_r'); 
		  
		 
		   
		   
		   if($product_image['currency'] != $this->session->userdata('currency_type'))
                      {
						echo convertCurrency($product_image['currency'],$this->session->userdata('currency_type'),$product_image['price']);
                     }
                     else{
						 
						$priceP= $product_image['price'];
						 echo number_format($priceP,2);
                     }
		   
		   
		   ?></label>
         
<?php 
$base =base_url();
$url=getimagesize($base.'images/users/'.$product_image['user_image']);
if(!is_array($url))
{
 $img="1"; //no
}
else {
 $img="0";  //yes
}

//To Check whether the image is exist in Local Directory..
?>	

		 
		 
 <a class="aurtors num2" href="<?php echo base_url();?>users/show/<?php echo $product_image['user_id'];?>">
<img src="<?php echo base_url();?><?php

 if($product_image['user_image']!='' && $img=='0'){
 echo 'images/users/'.$product_image['user_image'];
 }else if ($img=='1'){
 echo 'images/user_unknown.jpg';
 }
 
 
 ?>" style="border-radius: 50%;">
</a>
   <label class="headlined23"><a href="" title="<?php  echo $product_image['product_title'];?>"><?php  echo $product_image['product_title'];?></a></label>
  
          </div>
           </div>
           <div class="img-bottom">
           <?php
               $result = 0;
        if($product_image['id'] != '') {
       // $this->db->select('*');
        $this->db->select('*,AVG(total_review) as tot_rev');
        $this->db->from(REVIEW);
        $this->db->where('product_id',$product_image['id']);
        //$this->db->group_by('product_id');
       // $result = $this->db->get()->num_rows();
        $result = $this->db->get();

        }
	

         $result1 = 0;
        if($product_image['id'] != '') {
        $this->db->select('*');
        $this->db->from(REVIEW);
        $this->db->where('product_id',$product_image['id']);
        //$this->db->group_by('product_id');
        $result1 = $this->db->get()->num_rows();
        //$result1->row();

        }
		
       $tot_rev=$result->row()->tot_rev;
	   
        if($result->num_rows() > 0){
        ?>
		   <label class="star11"><span class="review_img"><span class="review_st" style="width:<?php echo $tot_rev * 20?>%"></span></span><span class="rew"><?php echo $result1; ?>  <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span></label><?php } else {?><span class="review_img"><span class="review_st" style="width:<?php echo $tot_rev * 20?>%"></span></span><span class="rew"><?php echo $result1; ?>  <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span><?php } ?>
		   
         
             <p class="describ"><?php echo $product_image['city'];?></p>
            </div>
          
            </li>
           
  <?php  	
   } ?>
             
             
          


    


    </ul>
    <?php } ?>
	<div class="ajax-loading" style="display: none"><img src="<?php echo base_url(); ?>/css/pre-loader/loader.gif" /></div>
		<div id="footer_pagination"><?php //echo $newpaginationLink; ?></div>
	
		<!--<div id="infscr-loading" style="display: none;">-->
					<!--img alt='Loading...' src="/_ui/images/site/common/ajax-loader.gif"-->
					<!--<span class="loading"><?php// if($this->lang->line('Loading') != '') { echo stripslashes($this->lang->line('Loading')); } else echo "Loading";?>...</span>
				</div>
				<div class="pagination" style="display: block" id="sample">
				<?php //echo $paginationDisplay; ?>
				</div>-->

</div></div>
    </div>
    
  <script>
    var $win     = $(window);
    var loading=false;
    	$(window).scroll(function()  
    //function xx(evt)
    { 
    		if(($(window).scrollTop() + $(window).height()) > ($(document).height()-500)) //user scrolled to bottom of the page?
    		{
        		
    		  	var surl= $('.btn-more').attr('href');
    	if(!surl) surl='';
    			if(surl != '' && loading==false) //there's more data to load
    			{
        			
    				loading = true; //prevent further ajax loading
    				//$('#infscr-loading').show(); 
    	$.ajax({
    					type : 'get',
    						url : surl,
    						
    						dataType : 'html',
    						success : function(response)
    						{
        				
    				var responce_html=$(response);
    				var res_val=responce_html.find('ul.popular-listing li');
    				$('ul.popular-listing').append(res_val);
    				$('.pagination a').remove();
    				var respo_val=responce_html.find('a.btn-more');
    				$('.pagination').append(respo_val);
    	            $('#infscr-loading').hide(); //hide loading image once data is received
    					
    					loading = false; 
    					after_ajax_load();
    				
    						}
    					});return false;
    	}}});
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
            url: '<?php echo base_url("load_popular_pagination"); ?>'+'?page=' + page,
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
$this->load->view('site/templates/footer');
?>
 
 

    
   