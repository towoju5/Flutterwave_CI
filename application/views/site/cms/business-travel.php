<?php
$this->load->view('site/templates/header');
?>
<link rel="stylesheet" href="css/site/datepicker.css" type="text/css">
<script typ="text/javascript">
$.getScript("<?php echo base_url();?>js/site/bootstrap-datepicker.js", function(){

var startDate = '<?php echo date('m/d/Y');?>';
var FromEndDate = new Date();
var ToEndDate = new Date();

ToEndDate.setDate(ToEndDate.getDate()+365);

$('.from_date').datepicker({
    
    weekStart: 1,
    startDate: '<?php echo date('m/d/Y');?>',
    //endDate: FromEndDate, 
    autoclose: true
})
    .on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('.to_date').datepicker('setStartDate', startDate);
    }); 
$('.to_date')
    .datepicker({
        
        weekStart: 1,
        startDate: startDate,
        endDate: ToEndDate,
        autoclose: true
    })
    .on('changeDate', function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('.from_date').datepicker('setEndDate', FromEndDate);
    });

  
  
  
  
});
</script>
<section>


<div class="banner-container businessbannner">
    <div class="row">
        <div class="col-md-12">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              
                <ul class="carousel-inner">
                     <?php 
					 $slider_loop=1;
					 foreach ($SliderList->result() as $Slider){ 
				if($Slider->image !=''){
					$ImgSrc=$Slider->image;
				}else{
					$ImgSrc='dummyProductImage.jpg';
				}
				  ?>
				<li class="item <?php if($slider_loop==1){ $slider_loop=2;?>active<?php }?>">
				<img src="images/slider/<?php echo $ImgSrc; ?>" alt="<?php echo $Slider->slider_title; ?>">
				</li>
				<?php }?> 
                </div>
               
            </ul>
            <div class="main-text hidden-xs">
                <div class="col-md-12 text-center">

                    <div class="container">
                      <h1><?php if($this->lang->line('Business Travel') != '') { echo stripslashes($this->lang->line('Business Travel')); } else echo "Business Travel";?></h1>
                    <div class="searching-section">
                 <form method="get" action="property" id="property_search_form" accept-charset="UTF-8">
                        <input name="city" id="city_landing" class="where" placeholder="<?php if($this->lang->line('Where do you want to go') != '') { echo stripslashes($this->lang->line('Where do you want to go')); } else echo "Where do you want to go";?>?" type="text">
						

                        <input  name="datefrom" class="chek from_date" placeholder="<?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "Check in";?>" type="text" contenteditable="false">

                        <input  name="dateto" class="chek-in to_date" placeholder="<?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "Check out";?>" type="text" contenteditable="false">

                         <!--<input name="guests" class="guest" placeholder="Number of guest" type="text">-->
						 <select name="guests" class="home_select">
						 <option value=""><?php if($this->lang->line('Guest') != '') { echo stripslashes($this->lang->line('Guest')); } else echo "Guest";?></option>
						 <?php for($i=1;$i<=16;$i++) {
                        if($i==1){
						 ?>
						 <option value="<?php echo $i;?>"><?php echo $i.' Guest'?></option>
						 <?php } else {?>
						 <option value="<?php echo $i;?>"><?php echo $i.' Guests'?></option>
						 <?php }?>
						 <?php }?>
						 </select>

                         <input class="fom-subm" value="Submit" type="button" onclick="property_search_form()">
                 </form>
                     <span id="city_warn"></span>			 
                </div>
            </div>
        </div>

         </div>
    </div>
</div>
<div id="push">
</div>
</div>
</section>

<?php echo stripslashes($cmsbusinesstravel->row()->description);?>

<script type="text/javascript">
function property_search_form()
{
$('#city_warn').html('');
var city=$('#city_landing').val();
if(city=="")
{
$('#city_warn').html('<?php if($this->lang->line('Please Enter City') != '') { echo stripslashes($this->lang->line('Please Enter City')); } else echo "Please Enter City";?>');
$('#city_landing').focus();
}
else{
$('#property_search_form').submit();
}

}
</script>

<?php
$this->load->view('site/templates/footer');
?>