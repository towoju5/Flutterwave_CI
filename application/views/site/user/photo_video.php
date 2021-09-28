<?php 
$this->load->view('site/templates/header');
?>

<link rel="stylesheet" type="text/css" href="css/colorbox.css" media="all" />
<link href="css/page_inner.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/my-account.css" type="text/css" media="all"/>
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>


<script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
<!-- script added 14/05/2014 -->
<style type="text/css">



#submitbutton{
margin-left: 320px;
margin-top: 5px;
width: 90px;

}
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    /*position: absolute;*/
    top: 1px;
    margin: 0;
    padding: 0;
    font-size: 15px;
    cursor: pointer;
    /*opacity: 0;*/
    filter: alpha(opacity=0);
}

</style>
<!-- script end -->

<!---DASHBOARD-->
<div class="dashboard yourlisting photos bgcolor">

<div class="top-listing-head">
 <div class="main"> 
 <?php 
             $this->load->view('site/user/main_nav_header');  
            ?> 
            </div></div>
	<div class="dash_brd">
    	<div id="command_center">
    <div class="lispg_top">	
	<div class="dashboard-sidemenu">
            
            <ul class="subnav">
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('EditProfile') != '') { echo stripslashes($this->lang->line('EditProfile')); } else echo "Edit Profile";?></a></li>
				<li class="active" ><a href="<?php echo base_url();?>photo-video"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>
				<li ><a href="<?php echo base_url();?>verification"><?php if($this->lang->line('TrustandVerification') != '') { echo stripslashes($this->lang->line('TrustandVerification')); } else echo "Trust and Verification";?></a></li>
                <li ><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>
                <li ><a href="<?php echo base_url();?>display-dispute"><?php if($this->lang->line('Dispute') != '') { echo stripslashes($this->lang->line('Dispute')); } else echo "Dispute";?></a></li>
				<li ><a href="users/show/<?php echo $userDetails->row()->id;?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a></li>
				
                          
            </ul>
			</div>
			<div class="listiong-areas">
            	<div id="account">
    <div class="box">
      <div class="middle">
			


         
  				<h1> <?php if($this->lang->line('Photo') != '') { echo stripslashes($this->lang->line('Photo')); } else echo "Photo";?></h1>
               
                 <div class="section notification_section">
				 
				 
				 <div class="img-left-section">
				 <div class="left-img-container">
         <?php if($_SESSION['login_type'] == 'google'){?>
                <?php if(!empty($userDetails) && $userDetails->row()->image!=''){ ?>
                <img src="<?php echo $userDetails->row()->image; ?>" />
                    <?php } ?>
          <?php }else{?>
				 <?php if(!empty($userDetails) && $userDetails->row()->image!=''){ ?>
					<img src="images/users/<?php echo $userDetails->row()->image; ?>" />
                    <?php } ?>
           <?php }?>         
					
				 </div>
				 </div>
				  <div class="img-right-section">
				  <p><?php if($this->lang->line('Clearfrontal') != '') { echo stripslashes($this->lang->line('Clearfrontal')); } else echo "Clear frontal face photos are an important way for hosts and guests to learn about each other. It's not much fun to host a landscape! Please upload a photo that clearly shows your face.";?></p>
					<div class="button-grops">
					
					<button style="display:none" class="take-photo-btn"><?php if($this->lang->line('TakeaPhoto') != '') { echo stripslashes($this->lang->line('TakeaPhoto')); } else echo "Take a Photo With Your Webcam";?></button>
				
					<!-- <center><button class="take-photo-btn"><?php if($this->lang->line('Uploadafile') != '') { echo stripslashes($this->lang->line('Uploadafile')); } else echo "Upload a file from your computer";?> </button></center> -->
					<center>
            <form class="myform" id="profile_settings_form" method="post" action="photo-video" enctype="multipart/form-data" accept-charset="UTF-8">
            <p style="color:red;"><b>Note: </b> Image type should jpg, jpeg, Png And Image dimensions should 272*272 px. </p>
					<!-- <div class="upload-file">
					<input id="uploadavatar" required class="hidden-file" name="upload-file" type="file">
					
				  </div> -->
        <div class="fileUpload btn btn-primary" >
            <label><?php if($this->lang->line('Uploadafile') != '') { echo stripslashes($this->lang->line('Uploadafile')); } else echo "Upload a file from your computer";?></label>
        	  <input type="file" class="upload" required name="upload-file" id="uploadavatar"/><br><br>
            <div class="error_box"><span id="error_img" style="color:red;"></span>
            <span id="success_img" style="color:green;"></span></div>
            </div>
            <div class="pic-save">
          

	 <input id="commit" type="submit" onclick="return Upload();" value="<?php if($this->lang->line('SaveSetting') != '') { echo stripslashes($this->lang->line('SaveSetting')); } else echo "Save Settings";?>" name="commit" class="blu-btn" ></div>
				 </form></center>
				 
					</div> 
  	       <div id="div-form" style="border:1px solid #000;">
  		
        
            
        
        
        </div> <!-- form befor div closed -->
					
  	       
  			 
          </div>
		  </div>
			  
    
      </div>
    </div>
  </div>
  </div>  </div>
         
  </div>
    </div>
</div>
<script type="text/javascript">
function Upload() {
    //Get reference of FileUpload.
    var fileUpload = document.getElementById("uploadavatar");
 
    //Check whether the file is valid Image.
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if(height > 272 && width > 272){
                        $('#commit').type = 'button';
                        $("#success_img").html("");
                        $("#error_img").html("Height and Width should be 272px x 272px.");
                        return false;
                    }
                    else if(height < 272 && width < 272)
                    {
                      $('#commit').type = 'button';
                      $("#success_img").html("");
                        $("#error_img").html("Height and Width should be 272px x 272px.");
                        return false;
                    }

                    else
                    {
                      $("#error_img").html("");
                      $("#success_img").html("Uploaded image has valid Height and Width.");
                      
                      $("#profile_settings_form").submit();
                      return true;
                    }
                };
 
            }
        } else {
            $("#success_img").html("");
            $("#error_img").html("This browser does not support HTML5.");
            return false;
        }
    } else {
        $("#success_img").html("");
        $("#error_img").html("Please select a valid Image file.");
        return false;
    }
}
</script>
<!---DASHBOARD-->
<?php 
$this->load->view('site/templates/footer');
?>