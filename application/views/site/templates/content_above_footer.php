<section>
	<div class="bottom-section">
<div class="container">
<div class="host-section">
<?php foreach($this->data['prefooter_results']->result() as $prefooter_result):?>

<div class="col-md-4">
<div class="host-area cenralize">

	<span class="host-container"><img src="images/prefooter/<?php echo $prefooter_result->image;?>"><span class="image-shadow"></span></span>
<div class="overla-text">
<span class="stat-text"><?php echo stripslashes($prefooter_result->footer_title);?></span>

<ul class="host-list">
<?php $short_descriptions=explode('//',$prefooter_result->short_description);
foreach($short_descriptions as $short_description):?>
<li><?php echo stripslashes($short_description);?></li>
<?php endforeach;?>
</ul>
</div>
<!--<a class="devlop-link" href="<?php echo $prefooter_result->footer_link;?>">
<?php echo $prefooter_result->footer_title;?> </a>-->
</div>	
</div>
<?php endforeach;?>
</div>
</div>
</div>
</section>