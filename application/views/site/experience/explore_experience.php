<?php 

$this->load->view('site/templates/header');
?>
<link rel="stylesheet" href="css/site/jquery.datePicker.css"/>
<script type="text/javascript">
function setPagination(id) {
  
  $('#paginationId').val(id);
  $('#search_result_form').submit();
}

</script>

<style>
input[type="text"]{
	width: 210px;
	height:auto;
}
input[type="text"] {
    background-image: url(<?php echo base_url(); ?>images/cald.png);
    background-position: 97% center;
    background-repeat: no-repeat;
    
}
#openModal-date{
	padding: 20px 17px 0;
}
.jqueryDatePicker{
	z-index:99999;
}
@media only screen and (max-width: 515px) {
  
#cboxLoadedContent{ width: 100% !important;}
#cboxContent{width:315px !important;
    left:0px; background: transparent;}
#inline_wishlist #form{    width: 100%; }
#cboxMiddleLeft{width: 0;}

}

@media only screen and (max-width: 475px) {
#cboxContent{width: 295px !important;   left:8px; top: 0;}
}

@media only screen and (max-width: 450px) {
#cboxContent{left:0px;     width:310px !important;}
}

@media screen and (max-width: 425px) {
#cboxContent {left:0px;}
}


@media only screen and (max-width: 414px) {
#cboxContent { left: 3px; width: 300px !important;}  

}


@media only screen and (max-width: 390px) {
#cboxContent {  left:5px;  width: 300px !important;}  
#cboxLoadedContent{margin-top:0;}
}


@media only screen and (max-width: 370px) {
#cboxContent {left: 4px;}

}

@media only screen and (max-width: 352px) {
#cboxContent {  left:7px;}  
  
}

@media only screen and (max-width: 344px) {
#cboxContent {  left:7px; }

}

@media only screen and (max-width: 340px) {
#cboxContent {  left: 11px;     width: 290px !important;} 
}

@media only screen and (max-width: 335px) {
#cboxContent {  left: 18px;  width: 276px !important;}
}

@media only screen and (max-width: 324px) {
  #cboxContent {  left: 16px;}
 
}

 .header.active
 {
  box-shadow: none;
 } 
</style>
<div class="yourlisting bgcolor" id="popul_li">
    <div class="fixedtabs">
      <div class="experiecne-page">
          <div class="main">   
            <ul id="">
            <?php /*
                <li class="active"><a href="<?php echo base_url(); ?>exprience/immersion" class="write_title"><?php if($this->lang->line('immersion_experience') != '') { echo stripslashes($this->lang->line('immersion')); } else echo "Immersions"; ?></a></li> */ ?>
                 <li><a href="<?php echo base_url(); ?>" class=""><?php if($this->lang->line('for_you') != '') { echo stripslashes($this->lang->line('for_you')); } else echo strtoupper("For you"); ?></a></li>

                 <li style="text-transform:uppercase;"><a href="<?php echo base_url(); ?>explore_listing" class=""><?php if($this->lang->line('places') != '') { echo stripslashes($this->lang->line('places')); } else echo strtoupper("Places"); ?></a></li>                

                 <li class="active"><a href="<?php echo base_url(); ?>explore_experience" class=""><?php if($this->lang->line('experience') != '') { echo stripslashes($this->lang->line('experience')); } else echo strtoupper("Experience"); ?></a></li>

                 

              <li></li>
            </ul> 
          </div>
      </div>

        <div class="clear customTabs">
            <form action="<?php echo base_url().'explore_experience';?>" method='POST' id='search_result_form'>
           
		   <input type="hidden" name="paginationId" id="paginationId" value="<?php if($paginationId!='')echo $paginationId;else echo '0';?>" />
		   
            <div class="tabs"><span class="title myModal" data-customModal="openModal-types"><?php if($this->lang->line('Type') != '') { echo stripslashes($this->lang->line('Type')); } else echo "Type"; ?> <i class="fa fa-angle-down" aria-hidden="true"></i></span> 
              <div class="customPopup" id="openModal-types">
                <div class="rows">
                  <label>
                    <div class="left">
                      <input type="checkbox" name="category[]"  value="1" <?php if($_POST['category']!='') { if(in_array(1,$_POST['category'])) echo 'checked'; } ?> >
                    </div>
                    <div class="right">
                      <span><?php if($this->lang->line('immersions') != '') { echo stripslashes($this->lang->line('immersions')); } else echo "Immersions"; ?></span>
                      <p><?php if($this->lang->line('happen_over_days') != '') { echo stripslashes($this->lang->line('happen_over_days')); } else echo "Happen over multiple days"; ?></p>
                    </div>
                  </label>
                </div>

                <div class="rows">
                  <label>
                    <div class="left">
                      <input type="checkbox" name="category[]" value="2" <?php if($_POST['category']!='') { if(in_array(2,$_POST['category'])) echo 'checked'; } ?> >
                    </div>
                    <div class="right">
                      <span><?php if($this->lang->line('experiences') != '') { echo stripslashes($this->lang->line('experiences')); } else echo "Experiences"; ?></span>
                      <p><?php if($this->lang->line('last_two_hours') != '') { echo stripslashes($this->lang->line('last_two_hours')); } else echo "Last 2 or more hours"; ?></p>
                    </div>
                  </label>
                </div>

                <div class="bottom clear">
                   <span class="cancel_popup cursorPointer"><span class="cancel"><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></span></span>
                 
                  <button type="submit" class="apply"><?php if($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?></button>
                </div>
              </div>
            </div>
            <div class="tabs"><span class="title myModal" data-customModal="openModal-category"><?php if($this->lang->line('category') != '') { echo stripslashes($this->lang->line('category')); } else echo "Category"; ?> <i class="fa fa-angle-down" aria-hidden="true"></i></span> 

             <div class="customPopup category" id="openModal-category">
                <?php if($experienceType->num_rows()>0){ 
                      foreach ($experienceType->result() as $type) {
                        ?>
                            <div class="rows">
                                <label>
                                    <div class="left">
                                       <input type="checkbox" name="type_id[]" value="<?php echo $type->id ; ?>" <?php if($_POST['type_id']!='') { if(in_array($type->id,$_POST['type_id'])) echo 'checked'; } ?>>
                                    </div>
                                    <div class="right">
                                        <span><?php echo $type->experience_title;?></span>
                                        <!-- <p>Happen over multiple days</p>  -->
                                    </div>
                                </label>
                            </div>
                        <?php
                      }
                  ?>


                <?php } else {
								echo "No Category Added...!";
								
				}				?>
                

                <div class="bottom clear">
                   <span class="cancel_popup cursorPointer"><span class="cancel"><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></span></span>
                   <button type="submit" class="apply" ><?php if($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?></button>
                </div>
              </div>

            </div>
			<div class="tabs"><span class="title myModal" data-customModal="openModal-date"><?php if($this->lang->line('Date') != '') { echo stripslashes($this->lang->line('Date')); } else echo "Date"; ?> <i class="fa fa-angle-down"  data-backdrop="static" data-keyboard="false"></i></span> 

             <div class="customPopup category" id="openModal-date">
                
                            <div class="rows">
                              
                                   <input type="text" placeholder="<?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "Check in";?>" value="<?php if($_GET['datefrom']!='')echo $_GET['datefrom'];else if($_POST['checkin'])echo $_POST['checkin']; ?>" id="textRangeFrom" name="checkin" readonly style="cursor:pointer;">
									<input type="text" placeholder="<?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "Check out";?>"  id="textRangeTo" value="<?php if($_GET['dateto']!='')echo $_GET['dateto'];else if($_POST['checkout'])echo $_POST['checkout']; ?>" name="checkout" style="cursor:pointer;margin-right:10px;">
                              
                            </div>
                      

                <div class="bottom clear">
                    <span class="cancel_popup cursorPointer"><span class="cancel"><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></span></span>
					<span class="reset_date cursorPointer"><span class="cancel"><?php if($this->lang->line('Reset') != '') { echo stripslashes($this->lang->line('Reset')); } else echo "Reset"; ?></span></span>
                   <button type="submit" class="apply" ><?php if($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?></button>
				   
                </div>
              </div>

            </div>

            </form>
          </div>
          </div>
</div>

<div class="body_content experiecne-body">
    

    <div>
        
        
            <input type="hidden" value="1" id='page_number' />
            <?php if($product->num_rows()>0)
            { ?>
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
                <li class="<?php echo $li_class_name; ?>">
                  <div class="img-top">
                  <div class="figures-cobnt">
                     <?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/experience/'.$product_image['product_image'])))
                      {?>
                         <a href="<?php echo base_url();?>view_experience/<?php echo $product_image['experience_id']; ?>">
                      <img src="<?php echo base_url();?>server/php/experience/<?php echo $product_image['product_image'];?>">
                      </a>
                      <?php }else if($product_image['product_image']!='' && strpos($product_image['product_image'], 's3.amazonaws.com') > 1){?> 
                        <a href="<?php echo base_url();?>view_experience/<?php echo $product_image['experience_id']; ?>">
                           <img src="<?php echo  $product_image['product_image'];?>">
                        </a>
                        <?php } else {?>
                        <a href="<?php echo base_url();?>view_experience/<?php echo $product_image['experience_id']; ?>">
                           <img src="<?php echo  base_url();?>server/php/experience/dummyProductImage.jpg">
                        </a>
                      <?php } ?>
                  </div>
                  <div class="posi-abs" id="popular_star">
                     
                    <?php  if($loginCheck==''){?>
                    <a class="ajax cboxElement heart reg-popup" href="site/experience/AddWishListForm/<?php echo $product_image['experience_id'];?>" style='top:5px'></a>

                    <?php } else { ?>
                    <a class="ajax cboxElement <?php if(in_array($product_image['experience_id'],$newArr)) echo 'heart-exist'; else echo 'heart';?>" href="site/experience/AddWishListForm/<?php echo $product_image['experience_id'];?>"  style='top:5px'></a>
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
                          echo $product_image['price'];
                        }
                      }else{
                          echo  $product_image['price'];
                        }
                      ?>



                    </label>

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



                  <!--  <a class="exp-aurtor num2" href="<?php echo base_url();?>users/show/<?php echo $product_image['user_id'];?>">
                       <img src="<?php echo base_url();?><?php

                        if($product_image['user_image']!='' && $img=='0'){
                        echo 'images/users/'.$product_image['user_image'];
                        }else if ($img=='1'){
                        echo 'images/user_unknown.jpg';
                        }


                        ?>" style="border-radius: 50%;">
                        </a>-->


                    <span class="exp-title"><a class="expDesc" href="view_experience/<?php echo $product_image['experience_id']; ?>" title="<?php echo $product_image['experience_title'];?>"><?php 

					
					
					$ExpTit=$product_image['experience_title'];
					
								if (strlen($ExpTit) > 23){
									
									echo substr($ExpTit, 0, 22) . '...';
								}else{
									
									echo $product_image['experience_title'];
								}
					
					
					
					?></a></span>
                    </div>

                  </div>
                  </div>
                  <div class="img-bottom">
                 <?php 	
					
					$avg_val=0;
					$num_reviewers=0;
				
					
                    if($product_image['experience_id'] != '') {		
						$id=$product_image['experience_id'];
						$res=$controller->get_review_exp($id);
						$avg_val=round($res->avg_val);	
						$num_reviewers=$res->num_reviewers;	
                    }
					
                    if($num_reviewers>0){
						
						
						
						?>
						
						<label class="stars">
						<span class="review_img">
							<span class="review_st" style="width:<?php echo ($avg_val * 20); ?>%"></span>
						</span>
						<span class="rew"><?php echo $num_reviewers; ?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span>
						</label>
						<?php 
					
					}else{ 
					
					?>
					
					<label class="stars">
					<span class="review_img">
						<span class="review_st" style="width:<?php echo $avg_val * 20 ?>%"></span>
					</span>
					<span class="rew"><?php echo $num_reviewers; ?> <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span>
					</label> 
					<?php 
					
					} ?>


                  <p class="describ"><?php  echo $product_image['city'];?></p>
                  </div>

                  </li>

              <?php   
                  }
             
            ?>








      </ul>
      <?php } else{ 
      
      
        if($this->lang->line('no_experience') != '') 
        { 
          $no_experience = stripslashes($this->lang->line('no_experience')); 
        } 
        else 
        {
          $no_experience = "No Experience";
        }
      
              echo "<li class='noDataTxt'>$no_experience</li>";
        
        
        
              }?>
              <div class="ajax-loading" style="display: none"><img src="<?php echo base_url(); ?>/css/pre-loader/loader.gif" /></div>
              <div id="infscr-loading" style="display: none;">
              <!--img alt='Loading...' src="/_ui/images/site/common/ajax-loader.gif"-->
                  <span class="loading"><?php if($this->lang->line('Loading') != '') { echo stripslashes($this->lang->line('Loading')); } else echo "Loading";?>...</span>
              </div>
			  
			  <?php /*
              <div class="pagination" style="display: block" id="sample">
                  <?php //echo $paginationDisplay; ?>
              </div>
			  
              <div id="footer_pagination"><?php echo $newpaginationLink; ?></div>
			  */
			  ?>

          </div>

</div>


<input type="hidden" id="ses_che_in" name="ses_in" value="<?php echo $this->session->userdata('check_in_ses');?>">
<input type="hidden" id="ses_che_out" name="ses_out" value="<?php echo $this->session->userdata('check_out_ses');?>">

    
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
	  modal_id=$(this).attr("data-customModal");
	 
	  if(modal_id=='openModal-date'){
		vi=$('.jqueryDatePicker').is(':visible');
		//alert(vi);
	  }
	  
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
   
   $('.cancel_popup').click(function(event){
      $('.customPopup').hide();
   });
   $('.reset_date').click(function(event){
		$('#textRangeFrom').val('');
		$('#textRangeTo').val('');
		
		var ses_in=$("#ses_che_in").val();
		var ses_out=$("#ses_che_out").val();
		
		$.ajax({ 
			type:'POST',
			data:{ses_in:ses_in,ses_out:ses_out},
			url:'<?php echo base_url() ?>site/experience/unset_dates',
			success:function(response){
				//alert(response);
			}
		});  
		
		
		
   });
   
  $(window).click(function(e) {
	  
    if( $(e.target).closest(".myModal").length > 0 ) {
        return false;
    }else{
		vi_d=$('#textRangeFrom').is(':visible');
		
		vi=$('.jqueryDatePicker').is(':visible');
		hide=1;
		textRangeFrom='';
		textRangeTo='';
		
		if(vi_d==true){
			textRangeFrom=$('#textRangeFrom').val();
			//minDate: textRangeFrom,
			//alert(textRangeFrom);
			textRangeTo=$('#textRangeTo').val();
		}
		
		if((vi==false && vi_d==false) || (vi_d==false) || (hide==2) || (textRangeFrom=='' && textRangeTo=='')){
			$('.customPopup').hide();
			$(".myModal .fa-angle-down.up").removeClass("up");
		}
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
            url: '<?php echo base_url("load_experience_pagination"); ?>'+'?page=' + page,
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
            if(data.length == 505){
            
               
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
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment-with-locales.min.js"></script>
  <script type="text/javascript" src="js/jquery.datePicker.js"></script>

  <script type="text/javascript">
	
	//$('#textRangeFrom').datePicker({ minDate: 0, monthCount: 2, range: ['#textRangeFrom','#textRangeTo'] });
	//$('#textRangeFrom').datePicker({ minDate: 0, monthCount: 2, range: ['#textRangeFrom','#textRangeTo'] });
	//check this 
	//equalsDatePart, end(applying class) in jquery date picker 
	
	$('#textRangeFrom').datePicker({
	minDate: 0,
    monthCount: 2,
	range: ['#textRangeTo'],
   /* disabled: [
        
        function(moment) {
           return moment.date() > 20;
        }
    ]*/
	});

	$(".jqueryDatePicker").on( "click", function() {
		//alert('clicked');
	  //console.log( $( this ).text() );
	});
	
	$(".jqueryDatePicker").click(function(){
		alert("The paragraph was clicked.");
	});


	
</script>

    