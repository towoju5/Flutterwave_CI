<?php
//echo '<pre>';print_r($file_lang_values);die;
$this->load->view('admin/templates/header.php');
 if (is_file('./fc_smtp_settings.php'))
{
	include('fc_smtp_settings.php');
}

?>
<script type="text/javascript">
function change_the_another_file(fileName){
	filenameId = $('#language_select').val();
 		if(fileName != '' && filenameId != ''){
 			window.open("admin/multilanguage/edit_language/"+fileName+"/"+filenameId,"_self");
		}
}
</script>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Language - <?php echo $selectedLanguage;?> - <?php echo 'Page'.' '.$current_file_no;?></h6>
                        <?php $NewOpArr=''; for($i=1;$i<$get_total_files;$i++) { 
                             $NewOpArr.= '<option value="'.$i.'"';
							 			 if($current_file_no == $i){   $NewOpArr.= 'selected="selected"';} 
                              $NewOpArr.='>Page '.$i.'</option>';
                          } ?>
                          <div style="float:right">
                        <select name="language_select" id="language_select"   style="float:left;margin: 9px 10px 0px; width:80px">
                          <?php echo $NewOpArr; ?>		
                          </select>
                          <button type="button" class="btn_small btn_blue" style="float:right !important; margin:4px 20px 0 0" onclick="javascript:change_the_another_file('<?php echo $selectedLanguage; ?>');"><span>Submit</span></button>
                         </div> 
					</div>
					<div class="widget_content">
                    <label class="error" style="font-size:18px;">Note: Dont Edit The Values Inside Of Curly Braces Eg: {SITENAME}</label>
                    <p style="font-size:12px;">Eg: Join {SITENAME} today  ---  Rejoignez {SITENAME} aujourd'hui</p>
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'languageEdit','accept-charset'=>'UTF-8');
						echo form_open('admin/multilanguage/languageAddEditValues',$attributes) 
					?>
                      <input type="hidden" value="<?php echo $selectedLanguage;?>" name="selectedLanguage"/>
                     <input type="hidden" value="<?php echo $file_name_prefix;?>" name="file_name_prefix"/>
                     <input type="hidden" value="<?php echo $current_file_no;?>" name="current_file_no"/>
	 						<ul>                            
                            
                            	<?php
									$loopNumber = 0;
									foreach($file_key_values as $language_keys_item)
									{									
										if($loopNumber != '0') {
									?>
                            
								<li>
                                      <div class="form_grid_12">
                                        <label class="field_title" for="language_vals<?php echo $loopNumber;?>"><?php echo stripslashes($file_lang_values[$loopNumber]); ?> <span class="req">*</span></label>
                                        <div class="form_input">
                                          <input name="language_vals[]" id="language_vals<?php echo $loopNumber;?>" value="<?php  echo stripslashes($this->lang->line($language_keys_item)); ?>"  type="text" tabindex="1" required class="required large tipTop" title="Please enter the language"/>
                                          <input name="languageKeys[]" value="<?php echo stripslashes($language_keys_item); ?>" id="smtp_host" type="hidden" tabindex="1" class="required large tipTop" required title="Please enter the language"/>                                          
                                        </div>
                                      </div>
                                    </li>
                                    
								<?php 
									}
									$loopNumber = $loopNumber+1;} 
                                ?>
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
                                     	
										<button type="submit" class="btn_small btn_blue"><span>Save</span></button>
									</div>
								</div>
								</li>
							</ul>
                           
						</form>
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
