<?php
$this->load->view('admin/templates/header.php');
extract($privileges);

?>

<?php 
	if ($ProductList->num_rows()>0){ 
		foreach ($ProductList->result() as $contactRow){
	?>
	  <?php 
	  
	  $RenterTopList .='["'.ucfirst($contactRow->product_title).'",'.$contactRow->productcount.'],';?>
   <?php }
   } ?>
   
   <?php 
	if ($TopRenterList->num_rows()>0){
		foreach ($TopRenterList->result() as $contactRow){
	?>
	  <?php 
	  
	  $RentalTopList .='["'.ucfirst($contactRow->firstname).'",'.$contactRow->productcount.'],';?>
   <?php }
   } ?>
   
   <?php 
   /**To Display Active & InActive Host**/
   $ActivedHost=$InactivedHost=0;
   foreach($TopRenterListBoth->result() as $hostList){
	   if ($hostList->status=='Active'){
		   $ActivedHost++;
	   }else if ($hostList->status=='Inactive'){
		   $InactivedHost++;
	   }
 
   }
   ?>
   
<script type="text/javascript">
$(function(){ 
  plot2 = jQuery.jqplot('chart5',
    [[
	
	<?php echo $RenterTopList;?>
	
	]],
    {
      title: ' ',
      seriesDefaults: {
        shadow: false,
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          startAngle: 180,
          sliceMargin: 4,
          showDataLabels: true }
      },
		grid: {
         borderColor: '#ccc',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: false               // draw a shadow for grid.
    },
      legend: { show:true, location: 'w' }
    }
  );
});
$(function(){
  plot2 = jQuery.jqplot('chart6',
    [[
	
	<?php echo $RentalTopList;?>
	
	]],
    {
      title: 'Actived Host List',
      seriesDefaults: {
        shadow: false,
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          startAngle: 180,
          sliceMargin: 4,
          showDataLabels: true }
      },
		grid: {
         borderColor: '#ccc',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: false               // draw a shadow for grid.
    },
      legend: { show:true, location: 'w' }
    }
  );
});

</script>
<div id="content">
		<div class="grid_container">
            
            <div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Top Booked Properties</h6>
					</div>
					<div class="widget_content">
						<h3>Booked Properties (<?php echo $TopBookedProperties->num_rows(); ?>)</h3>

						<div id="chart5" class="chart_block">
						</div>
					</div>
				</div>
			</div>
            
            <div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Top Properties Added Host </h6>
					</div>
					<div class="widget_content">
						<h3>Host</h3>
						
						<small style="margin-left :20px; ">Actived Host : <?php echo $ActivedHost ?></small><br>
						
						<small style="margin-left :20px; ">InActived Host : <?php echo $InactivedHost ?></small>
					
						<!--<p>
							 Cras erat diam, consequat quis tincidunt nec, eleifend a turpis. Aliquam ultrices feugiat metus, ut imperdiet erat mollis at. Curabitur mattis risus sagittis nibh lobortis vel.
						</p>-->
						
						<div id="chart6" class="chart_block">
						</div>
					</div>
				</div>
			</div>
            
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>