<?php 
$this->load->view('site/templates/header',$this->data);
?>
<div class="container">
			<div>
			<?php if($this->lang->line('Edit_Wish_List') != '') { echo stripslashes($this->lang->line('Edit_Wish_List')); } else echo "Edit Wish List";?>: 
			</div>
			
			<form action="" method="post" accept-charset="UTF-8">
			<label><?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?></label>
			<input type="text" name="title">
			<label><?php if($this->lang->line('Whocanseethis') != '') { echo stripslashes($this->lang->line('Whocanseethis')); } else echo "Who can see this";?>?</label>
			<select type="select" >
			
			</select>
			</form>
		
		 </div>
<?php 
$this->load->view('site/templates/footer',$this->data);
?>