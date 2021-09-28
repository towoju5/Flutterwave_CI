<?php 
//echo $this->config->item ( 'site_pagination_per_page' );
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
#cboxContent{width:315px !important;
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
#cboxContent {  left: 11px;    width: 290px !important;} 
}

@media only screen and (max-width: 335px) {
#cboxContent {  left: 18px;  width: 276px !important;}
}

@media only screen and (max-width: 324px) {
  #cboxContent {  left: 16px; width: 276px !important;}
  
}

 .header.active
 {
  box-shadow: none;
 } 

 /*Pagination*/
 /*Pagination*/
    a {
    color: #42495b;
    text-decoration: none;
}
a h1 {
    padding: 2rem;
    color: #42495b;
    text-align: center;
}
a:hover {
    text-decoration: underline;
}
/*
a[class^="simple-pagination-navigation-"] + a[class^="simple-pagination-navigation-"] {
    margin-right: 0;
}*/
 a[class*="simple-pagination-navigation-disabled"] {
    color: black;
    cursor: default;
}
/*
Styles used to page things look nice :)
*/
 * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
}
body {
    
}
#header {
    border-radius: .5rem;
}

.simple-pagination-navigation-previous, .simple-pagination-navigation-next {
    float: left;
}
.simple-pagination-page-numbers{
  float: left;
  margin-left: 6px;
}
.ajax-loading
{
  width: 100%;
  overflow: hidden;
  text-align: center;
}
</style>
<div class="yourlisting bgcolor" id="popul_li">
    <div class="fixedtabs">
      <div class="experiecne-page">
          <div class="main">   
            <ul id="">
            <?php 
            /*
                <li class="active"><a href="<?php echo base_url(); ?>exprience/immersion" class="write_title"><?php if($this->lang->line('immersion_experience') != '') { echo stripslashes($this->lang->line('immersion')); } else echo "Immersions"; ?></a></li> */ ?>
                <li><a href="<?php echo base_url(); ?>" class=""><?php if($this->lang->line('for_you') != '') { echo stripslashes($this->lang->line('for_you')); } else echo strtoupper("For you"); ?></a></li>

                 <li style="text-transform: uppercase;" class="active"><a href="<?php echo base_url(); ?>explore_listing" class=""><?php if($this->lang->line('places') != '') { echo stripslashes($this->lang->line('places')); } else echo strtoupper("Places"); ?></a></li>

                 <li> <a href="<?php echo base_url(); ?>explore_experience" class=""><?php if($this->lang->line('experience') != '') { echo stripslashes($this->lang->line('experience')); } else echo strtoupper("Experience"); ?></a></li>

                
                 

              <li></li>
            </ul> 
          </div>
      </div>

       
		  
		  
		  
          </div>
</div>

<div class="body_content exp_listing_page">
  <div class="">
  
    <form action="<?php echo base_url().'explore_listing';?>" method='POST' id='search_result_form'>
      <input type="hidden" name="paginationId" id="paginationId" value="<?php if($paginationId!='')echo $paginationId;else echo '0';?>" />
      </form>
	  
	  
    <div>
        
        <input type="hidden" value="1" id='page_number' /> 
        <?php if($product->num_rows()>0)
            { ?>
          <!-- <div id="container"> -->
            <ul class="popular-listing experienceBlocks" id="dev_prodcut_load_section">
            
            <?php  $count=0;
            
              foreach($product->result_array() as $product_image )
              { 
                  $count++;
                  if(($count%5)==0)
                  { 
                   $li_class_name='big-poplr';
                  }else {
                   $li_class_name='';
                  }
              ?>
                <li class="<?php echo $li_class_name; ?>" >
                  <div class="img-top">
                  <div class="figures-cobnt">
                     <?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/rental/'.$product_image['product_image'])))
                      {?>
                         <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
                      <img src="<?php echo base_url();?>server/php/rental/<?php echo $product_image['product_image'];?>">
                      </a>
                      <?php }else if($product_image['product_image']!='' && strpos($product_image['product_image'], 's3.amazonaws.com') > 1){?> 
                        <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
                           <img src="<?php echo $product_image['product_image'];?>">
                        </a>
                        <?php } else {?>
                        <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
                           <img src="<?php echo  base_url();?>server/php/rental/dummyProductImage.jpg">
                        </a>
                      <?php } ?>
                  </div>
                  <div class="posi-abs" id="popular_star">
                     
                    <?php  if($loginCheck==''){?>
                    <a class="ajax cboxElement heart reg-popup" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>" style='top:5px'></a>

                    <?php } else { ?>
                    <a class="ajax cboxElement <?php if(in_array($product_image['id'],$newArr)) echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"  style='top:18px'></a>
                    <?php }  ?>
                    <div class="textOverflow">
                    <label class=""><?php if($product_image['currency']!=''){  echo $this->session->userdata('currency_s'); }else echo $this->session->userdata('currency_s');
                          $cur_Date = date('Y-m-d');
                      if($product_image['currency']!=''){     
                        if($product_image['currency'] != $this->session->userdata('currency_type'))
                        {
                          echo convertCurrency($product_image['currency'],$this->session->userdata('currency_type'),$product_image['price']);
  
                        }
                        else{
							
                        
						 
                           $priceEx= $product_image['price'];
						   
						    echo number_format($priceEx,2);
						  
                        }
                      }else{
						  
                        
						 
						 
						 $priceEx1= $product_image['price'];
						   
						    echo number_format($priceEx1,2);
						  
                        }
                      ?>



                    </label>

                    <?php 
                    $base =base_url();
                    $url=getimagesize($base.'images/users/'.$product_image['user_image']);
                    if(!is_array($url))
                    {
                      $img="1"; 
                    }
                    else {
                      $img="0";  
                    }

                    
                    ?>  



                  
          <label style="display: inline;"><a class="expDesc" href="rental/<?php echo $product_image['id']; ?>" title="<?php echo $product_image['product_title'];?>"><?php 

					
					$property=$product_image['product_title'];	
					
								if (strlen($property) > 23){
									
									echo substr($property, 0, 22) . '...';
								}else{
									
									echo $product_image['product_title'];
								}
					
					
					?></a></label>
                    </div>

                  </div>
                  </div>
                  <div class="img-bottom">
                     <?php 	
					
					//$avg_val=round($product_image['avg_val']);
					$avg_val=round($product_image['rate']);
					$num_reviewers=$product_image['num_reviewers'];
				
                   ?>
						
						<label class="stars">
						<span class="review_img">
							<span class="review_st" style="width:<?php echo ($avg_val * 20); ?>%"></span>
						</span>
						<span class="rew"><?php echo  $num_reviewers; ?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span>
						</label>
                  <p class="describ"><?php  echo $product_image['city'];?></p>
                  </div>

                  </li>

              <?php   
                  }
            ?>








      </ul>

      <!-- <div class="my-navigation">
           
            <div class="nav-wrap">
                <div class="simple-pagination-previous"></div>
                <div class="simple-pagination-page-numbers"></div>
                <div class="simple-pagination-next"></div>
                </div>
        </div> -->
    <!-- </div> -->
    <?php } 
       else{ 
          echo '<li>No Listings</li>';
    } ?>
    <div class="ajax-loading" style="display: none"><img src="<?php echo base_url(); ?>/css/pre-loader/loader.gif" /></div>
              <div id="infscr-loading" style="display: none;">
             
                  <span class="loading"><?php if($this->lang->line('Loading') != '') { echo stripslashes($this->lang->line('Loading')); } else echo "Loading";?>...</span>
              </div>
			  
              <div class="pagination" style="display: block" id="sample">
                  
                  

              </div>
			  
			         <!-- <ul id="pagination-demo" class="pagination-sm"></ul> -->
              <!-- <div id="footer_pagination"><?php //echo $newpaginationLink; ?></div> -->

          </div>

    </div>


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

 <?php
$this->load->view('site/templates/footer');
?>
 

<script>
  $(document).on("click",".myModal", function(){
      var attr = "#" + $(this).attr("data-customModal");
      $(".customPopup:not("+attr+")").hide();
      $(attr).toggle();
      var notThisUp = $(this).children(".fa-angle-down");
      $(".myModal .fa-angle-down.up").not($(this).find(".fa-angle-down")).toggleClass("up");
      $(this).children(".fa-angle-down").toggleClass("up");
    });
    
    $('.customPopup').click(function(event){
       event.stopPropagation();
   });

  $(window).click(function(e) {
    if( $(e.target).closest(".myModal").length > 0 ) {
        return false;
    }
    else{
      $('.customPopup').hide();
      $(".myModal .fa-angle-down.up").removeClass("up");
    }
  });
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
            url: '<?php echo base_url("load_places_pagination"); ?>'+'?page=' + page,
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
 <script type="text/javascript" src="<?php echo base_url()?>/js/pagination/jquery-simple-pagination-plugin.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var pagination = $('#container').simplePagination({
        previous_content: '<i class="fa fa-arrow-left"></i>', //e.g. '<'
        next_content: '<i class="fa fa-arrow-right"></i>', //e.g. '>'
        number_of_visible_page_numbers: 4,
        items_per_page: 5,
        pagination_container: 'ul',
        html_prefix: 'simple-pagination',
        navigation_element: 'a', //button, span, div, et cetera
    });
    });
</script>