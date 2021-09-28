<?php $this->load->view('site/templates/header'); ?>
<script>
$(document).ready(function(){
	$(".help-search").keyup(function () {
        var that = this,
        value = $(this).val();
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>site/help/ajaxquestionanswer",
                data: {
                    'search_keyword' : value
                },
                success: function(msg){
                  $('#leftMenu').html(msg);
                }
            });
        }
    });
	
	$(".buttonClick").click(function() {
		if($(this).is(':checked'))
		{
			var type = $(this).val();
			$("#buttonClick_"+type).click();
		}
		else
		window.location.href = baseURL+'help';
		
	});
});
</script>
<section>
	<div class="banner">
		<div class="help-banner"><img src="<?php echo base_url(); ?>images/help-banner.png"></div>
		<div class="help-banner-inner">
			<div class="container">
				<div class="col-md-3">
				</div>
				
				
				<div class="col-md-6 helpguest_centercol6">
					<div class="help-banner-top">
						<h1><?php if($this->lang->line('help_center') != '') { echo stripslashes($this->lang->line('help_center')); } else echo "Help center";?></h1>
						<form action="<?php echo base_url()?>help" id="help_submit_page" method="POST">
							<input type="text" class="help-search" placeholder="<?php if($this->lang->line('find_answer') != '') { echo stripslashes($this->lang->line('find_answer')); } else echo "Search and find the answer to your question";?>">
							<a href="#">
								<img src="<?php echo base_url(); ?>images/search-icon.png" class="search-icon">
							</a>
							<form>
							<div class="option-fliter">
								<ul class="sear-resu-option">
									<li class="description-option">
										<div class="checkbox-1">
											<input id="check1" class="buttonClick" name="check[]" value="User" <?php if($type == 'guest') echo 'checked = "checked"';?> type="checkbox">
											<label for="check1"><?php if($this->lang->line('search_guest') != '') { echo stripslashes($this->lang->line('search_guest')); } else echo "Search as Guest";?></label>
										</div>
									</li>
									<li class="description-option">
										<div class="checkbox-1">
											<input id="check2" class="buttonClick" name="check[]" value="Host" <?php if($type == 'host') echo 'checked = "checked"';?> type="checkbox">
											<label for="check2">													<?php if($this->lang->line('search_ghost') != '') { echo stripslashes($this->lang->line('search_ghost')); } else echo "Search as Host";?></label>
										</div>
									</li>
								</ul>
							</div>
							</form>
							<a href="<?php echo base_url();?>help/guest/home/guest-home">
								<div class="gust-host" id="buttonClick_User">
									<img src="<?php echo base_url(); ?>images/guest.png"><br>
									<?php if($this->lang->line('i_am_guest') != '') { echo stripslashes($this->lang->line('i_am_guest')); } else echo "I am a guest";?>
								</div>
							</a>
							<a href="<?php echo base_url();?>help/host/home/host-home">
								<div class="gust-host-1" id="buttonClick_Host">
									<img src="<?php echo base_url(); ?>images/host-1.png"><br>
									<?php if($this->lang->line('i_am_host') != '') { echo stripslashes($this->lang->line('i_am_host')); } else echo "I am a host";?>
								</div>
							</a>	
							
						</form>
					</div>
				
				</div>
				
			</div>
		</div>
	</div>
</section>


<section>
	<div class="container" id="helpguest_containr">
		<div class="col-md-3 helpguest_col3">
			<div id="MainMenu" >
			  <div class="list-group panel">

				<?php foreach($mainmenu->result() as $main) {?>
				<a href="<?php echo base_url().'help/'.$type.'/'.$main->seo;?>" class="list-group-item list-group-item-success" <?php if($mainSeo == $main->seo) {?>style="color:#fff;"<?php }?>><?php echo $main->name?></a>
				<div class="in" id="demo3">
				
				<?php if($mainSeo == $main->seo) {
				foreach($submenu->result() as $sub){?>
				
				  <a href="<?php echo base_url().'help/'.$type.'/'.$main->seo.'/'.$sub->seo;?>" class="list-group-item" <?php if($subSeo == $sub->seo) {?>style="color:color:rgb(246, 167, 48);"<?php }?>><i class="fa fa-angle-double-right" aria-hidden="true"></i><span style="margin-left:2%;"><?php echo $sub->name;?></span></a>
				<?php }}?>
				</div>
				<?php }?>
			  </div>
			</div>
		</div>
		<?php if($questions){ ?> 
		<div class="col-md-9 helpguest_col9">
			<div class="accordion" id="leftMenu">
				<div class="accordion-group">
					<?php foreach($questions->result() as $qus){?>
					<div class="accordion-heading">
						<a class="accordion-toggle <?php if($qusSeo != $qus->seo)echo "collapsed";?>" href="<?php echo base_url().'help/'.$type.'/'.$mainSeo.'/'.$subSeo.'/'.$qus->seo; ?>"><?php echo $qus->question;?>? <span style="float:right;"><img src="<?php echo base_url();?>images/small-arrow.png"></span></a>
					</div>
					<div id="<?php echo $qus->seo; ?>" class="accordion-body <?php if($qusSeo != $qus->seo)echo "collapse";else echo "in";?>">
						<div class="accordion-inner-content">
							<div class="col-md-11" style="color: #333333;font-family: 'Conv_DaxLight';font-size: 14px;line-height: 22px;">
								<p><?php echo $qus->answer; ?></p>
							</div>
						</div>
					</div>
					<?php }?>	
				</div>
			</div>
		</div>
		<?php }?>
	</div>
	
	

<style>
@media only screen and (max-width: 767px){
}

</style>




	
</section>

<?php $this->load->view('site/templates/footer'); ?>