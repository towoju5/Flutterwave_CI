<!DOCTYPE html>
<html>
   <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
      <?php
	  
	
         /*Setting current url page if user not logged in*/
         if ($this->session->fc_session_user_id == "") {
             $current_url = uri_string();
             $this->session->set_userdata(array('current_page_url' => $current_url));
         }
         /*Close*/
         if ($this->config->item('google_verification')) {
             echo stripslashes($this->config->item('google_verification'));
         }
         if ($this->lang->line('list_your') != '') {
             $listSpace = stripslashes($this->lang->line('list_your'));
         } else $listSpace = "List Your Space";
         if ($this->lang->line('create_experience') != '') {
             $listExprience = stripslashes($this->lang->line('create_experience'));
         } else $listExprience = "Create Experience";
         if ($heading == '') {
             ?>
      <title>
         <?php echo $meta_title; ?>
      </title>
      <?php
         } else {
             ?>
      <title>
         <?php echo $heading; ?>
      </title>
      <?php }
         ?>
      <script type="text/javascript">
         var IsHomePage = 1;
         var IsExpriencePage = 0;
             <?php if ($this->uri->segment(1) != "") { ?>var IsHomePage = 0;<?php }?>
             <?php if ($current_controller != "experience") { ?>var IsExpriencePage = 1;<?php }?>
         var BaseURL = '<?php echo base_url();?>';
         var baseURL = '<?php echo base_url();?>';
      </script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="title" content="<?php echo $meta_title; ?>"/>
      <meta name="keywords" content="<?php echo $meta_keyword; ?>"/>
      <meta name="description" content="<?php echo $meta_description; ?>"/>
      <link rel="shortcut icon" type="image/x-icon"
         href="<?= base_url(); ?>images/logo/<?php echo $this->config->item('fevicon_image'); ?>">
      <!-- <link href="https://fonts.googleapis.com/css?family=Mukta+Malar:300,400,500" rel="stylesheet"> -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-muktamalar.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap3.3.7.min.css">
      <!-- Owl Stylesheets -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/owlcarousel/assets/owl.carousel.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/owlcarousel/assets/owl.theme.default.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
      <!-- script for image croping -->
      <script src="<?php echo base_url(); ?>js/jquery3.2.1.min.js"></script>
      <script src="<?php echo base_url(); ?>js/bootstrap3.3.7.min.js"></script>
      <!-- Owl javascript -->
      <script src="<?php echo base_url(); ?>assets/owlcarousel/owl.carousel.js"></script>
      <!-- Location Autocomplete API -->
      <script
         src="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http'; ?>://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('google_developer_key'); ?>&libraries=places&dummy=.js"></script>
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
      <!-- Custom Jquery -->
      <script src="<?php echo base_url(); ?>js/customJs.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      
   </head>
   <body>
      <header>
         <div class="clear">
            <div class="headerLeft">
               <div class="logo">
			   
			   
			   
              <?php if($_SESSION['language_code']=="ar") {  ?>
	  
			   <a href="<?php echo base_url();?>"><img src="images/logo/<?php echo $this->config->item('logo_image_arabic');?>" alt=""></a>
			   
			   <?php } else { 
			   
			  if($this->uri->segment(1) != '') { ?>
			  
			   <!--logo image part-->
			  
			   <a href="<?php echo base_url();?>">
					<?php if (file_exists('./images/logo/' . $this->config->item('logo_image'))) { ?>
						 <img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image'); ?>"
						 alt="Logo">
					<?php } else {
						echo $this->config->item('email_title');  } ?>
			   </a>
			  
			   <!--end logo image part-->
			   
			   <?php } else { ?>
			   
			   <!--homepage logo part-->
			  
			  <a href="<?php echo base_url(); ?>"> 
					<?php if (file_exists('./images/logo/' . $this->config->item('home_logo_image'))) { ?> 
						<img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('home_logo_image'); ?>"  alt="Logo">
					<?php } else {
						echo $this->config->item('email_title');  } ?>
			  </a>
			  
			  
			  <!--end homepage logo part-->
			  
			  <?php } }  ?>
				  
				  
                  <div class="menuArrow"><span class="icon"> > </span></div>
               </div>
               <div class="searchLocation">
                  <form
                     action="<?= base_url(); ?><?php if ($current_controller != "experience") { ?>property<?php } else { ?>explore-experience<?php } ?>"
                     name="search_properties" autocomplete="off" method="get" id="property_search_form"
                     accept-charset="utf-8">
                     <i class="fa fa-search" aria-hidden="true"></i>
                     <?php if ($this->lang->line('try') != '') {
                        $try= stripslashes($this->lang->line('try'));
                        } else {
                        $try="Try";
                        } ?>
                     <input id="autocomplete" class="searchInput" value="<?php if ($this->input->get('city') != '') {
                        echo $this->input->get('city');
                        } else {
                        echo '';
                        } ?>" placeholder= '<?php echo $try . " Nairobi"; ?>'  name="city" type="text">
                     <button type="submit" class="searchBtn"><?php if ($this->lang->line('Search') != '') {
                        echo  stripslashes($this->lang->line('Search'));
                        } else {
                        echo "Search";
                        } ?></button>
                     <div class="exploreDetail">
                        <h6><?php if ($this->lang->line('explore_homestay') != '') {
                           echo stripslashes($this->lang->line('explore_homestay'));
                           } else echo "Explore Homestay"; ?></h6>
                        <div class="clear">
                           
                           <a href="<?php echo base_url(); ?>explore_listing"
                              class="exploreBtn <?php if ($this->uri->segment(1) == 'explore_listing') { ?>active<?php } ?>"><?php if ($this->lang->line('Homes') != '') {
                              echo stripslashes($this->lang->line('Homes'));
                              } else echo "Homes"; ?></a>
                           <a href="<?php echo base_url(); ?>explore-experience"
                              class="exploreBtn <?php if ($this->uri->segment(1) == 'explore-experience') { ?>active<?php } ?>"><?php if ($this->lang->line('Experiences') != '') {
                              echo stripslashes($this->lang->line('Experiences'));
                              } else echo "Experiences"; ?></a>
							  
							  <a href="<?php echo base_url(); ?>all_listing" class="exploreBtn <?php if ($this->uri->segment(1) == 'all_listing') { ?>active<?php } ?>"><?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All'));  } else { echo "All"; } ?></a>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="responsiveMenu">
                  <div class="logo">
                     <?php if (file_exists('./images/logo/' . $this->config->item('logo_image'))) { ?>
                     <img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image'); ?>"
                        alt="Logo">
                     <?php } else {
                        echo $this->config->item('email_title');
                        } ?>
                     <div class="menuArrow"><span class="icon"> > </span></div>
                  </div>
                  <ul class="clearLeft">
                     <li><a href="<?= base_url(); ?>"><?php if ($this->lang->line('home') != '') {
                        echo stripslashes($this->lang->line('home'));
                        } else echo "Home"; ?> <i class="fa fa-home" aria-hidden="true"></i></a></li>
                     <li class="divider"></li>
                     <?php if ($this->session->userdata('fc_session_user_id')) { ?>
                     <li><?php echo anchor('list_space', $listSpace . '<i class="fa fa-building" aria-hidden="true"></i>'); ?></li>
                     <li><?php echo anchor('manage_experience', $listExprience . '<i class="fa fa-calendar-check-o" aria-hidden="true"></i>'); ?></li>
                     <?php } else { ?>
                     <li><a data-toggle="modal" data-target="#signUp"
                        onclick="javascript:set_signup_and_login_link('list_space');"><?php echo $listSpace; ?></a>
                     </li>
                     <li><a data-toggle="modal" data-target="#signUp"
                        onclick="javascript:set_signup_and_login_link('manage_experience');"><?php echo $listExprience; ?></a>
                     </li>
                     <?php } ?>
                     <?php if ($this->session->userdata('fc_session_user_id')) { ?>
                     <li class="divider"></li>
                     <li>
                        <a href="<?php echo base_url(); ?>dashboard"><?php if ($this->lang->line('header_dashboard') != '') {
                           echo stripslashes($this->lang->line('header_dashboard'));
                           } else echo "Dashboard"; ?> <i class="fa fa-user-o" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>listing/all"><?php if ($this->lang->line('header_listing') != '') {
                           echo stripslashes($this->lang->line('header_listing'));
                           } else echo "Your Listings"; ?> <i class="fa fa-suitcase" aria-hidden="true"></i></a>
                     </li>
                     <?php
                        if ($experienceExistCount > 0) {
                            ?>
                     <li>
                        <a href="<?php echo base_url(); ?>experience/all"><?php if ($this->lang->line('my_experience_list') != '') {
                           echo stripslashes($this->lang->line('my_experience_list')); } else echo "My Experiences List"; ?> <i class="fa fa-map-marker"
                           aria-hidden="true"></i></a>
                     </li>
                     <?php } ?>
                     <li>
                        <a href="<?php echo base_url(); ?>listing-reservation"><?php if ($this->lang->line('YourReservations') != '') {
                           echo stripslashes($this->lang->line('YourReservations'));
                           } else echo "Your Reservations"; ?> <i class="fa fa-map-o" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>trips/upcoming"><?php if ($this->lang->line('your_trips') != '') {
                           echo stripslashes($this->lang->line('your_trips'));
                           } else echo "Your Trips"; ?> <i class="fa fa-motorcycle" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="users/<?php echo $loginCheck; ?>/wishlists"><?php if ($this->lang->line('wish_list') != '') {
                           echo stripslashes($this->lang->line('wish_list'));
                           } else echo "Wish List"; ?> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>settings"><?php if ($this->lang->line('settings_edit_prof') != '') {
                           echo stripslashes($this->lang->line('settings_edit_prof'));
                           } else echo "Edit Profile"; ?> <i class="fa fa-edit" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>account-payout"><?php if ($this->lang->line('referrals_account') != '') {
                           echo stripslashes($this->lang->line('referrals_account'));
                           } else echo "Account"; ?> <i class="fa fa-dashboard" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>your-wallet">oyy<?php if ($this->lang->line('Wallet') != '') {
                           echo stripslashes($this->lang->line('Wallet'));
                           } else { echo "Wallet"; }
                           echo " (" . $currencySymbol . ' ' . currency_conversion('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount) . ")"; ?>
                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                        </a>
                     </li>
                     <?php
                        if ($this->session->userdata('fc_session_user_login_type') == "facebook") {
                            ?>
                     <li><?php echo anchor('fb-user-logout', 'Logout  <i class="fa fa-sign-out" aria-hidden="true"></i>'); ?></li>
                     <?php
                        } else {
                            ?>
                     <li><?php echo anchor('user-logout', 'Logout  <i class="fa fa-sign-out" aria-hidden="true"></i>'); ?></li>
                     <?php
                        }
                        } else {
                        ?>
                     <li class="divider"></li>
                     <li><a data-toggle="modal"
                        data-target="#signUp"
                        onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('login_signup') != '') {
                        echo stripslashes($this->lang->line('login_signup'));
                        } else echo "Create  Account"; ?> <i class="fa fa-user-plus" aria-hidden="true"></i></a>
                     </li>
                     <li><a data-toggle="modal"
                        data-target="#signIn"
                        onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('header_login') != '') {
                        echo stripslashes($this->lang->line('header_login'));
                        } else echo "Log in"; ?> <i class="fa fa-sign-in " aria-hidden="true"></i></a>
                     </li>
                     <?php
                        }
                        ?>
                  </ul>
               </div>
            </div>
            <div class="headerRight">
               <ul class="clear list_li">
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button"
                           onclick="set_signup_and_login_link('<?= uri_string(); ?>');window.location.href='<?php echo base_url(); ?>popular'">
                        <?php if ($this->lang->line('popular') != '') {
                           echo stripslashes($this->lang->line('popular'));
                           } else echo "Popular"; ?>
                        </button>
                     </div>
                  </li>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button"
                           data-toggle="dropdown"><?php if ($this->lang->line('Become_Host') != '') {
                           echo stripslashes($this->lang->line('Become_Host'));
                           } else echo "Become a Host"; ?>
                        </button>
                        <ul class="dropdown-menu">
                           <div class="dropdownIcon"></div>
                           <?php
                              if ($this->session->userdata('fc_session_user_id')) { ?>
                           <li><?php echo anchor('list_space', $listSpace); ?></li>
                           <li><?php echo anchor('manage_experience', $listExprience); ?></li>
                           <?php } else { ?>
                           <li><a data-toggle="modal" data-target="#signUp"
                              onclick="javascript:set_signup_and_login_link('list_space');"><?php echo $listSpace; ?></a>
                           </li>
                           <li><a data-toggle="modal" data-target="#signUp"
                              onclick="javascript:set_signup_and_login_link('manage_experience');"><?php echo $listExprience; ?></a>
                           </li>
                           <?php } ?>
                        </ul>
                     </div>
                  </li>
                  <?php if ($this->session->userdata('fc_session_user_id')) {
                     if ($MyWishLists->num_rows() > 0) {
                         ?>
                  <li>
                     <div class="dropdown">
					 
					 
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><?php if ($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save"; ?>
                        </button>
                        <ul class="dropdown-menu listings wishLis">
                           <div class="dropdownIcon"></div>
                           <div class="heading">
                              <div><?php if ($this->lang->line('Wish_list') != '') {
                                 echo stripslashes($this->lang->line('Wish_list'));
                                 } else echo "Wishlist"; ?></div>
                              <div onclick="javascript:window.location.href='<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists'"
                                 style="cursor: pointer;"><?php if ($this->lang->line('view_wish_list') != '') {
                                 echo stripslashes($this->lang->line('view_wish_list'));
                                 } else echo "View Wish Lists"; ?>	
                              </div>
                           </div>
                           <?php
                              foreach ($MyWishLists->result() as $myWishes) {
                                  ?>
                           <div class="listings_R">
                              <div>
                                 <div class="h7"><?php echo $myWishes->name; ?></div>
                                 <a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $myWishes->id; ?>"><?php if ($this->lang->line('view_wish_list') != '') {
                                 echo stripslashes($this->lang->line('view_wish_list'));
                                 } else echo "View Wish Lists"; ?></a>
                              </div>
                              <div>
                                 <a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $myWishes->id; ?>"
                                    class="imgBlock"></a>
                              </div>
                           </div>
                           <?php
                              }
                              ?>
                        </ul>
                     </div>
                  </li>
                  <?php }
                     if ($latestBookedTrips->num_rows() > 0) { ?>
                  <li>
                     <div class="dropdown">
					 
					 
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><?php if ($this->lang->line('tribs') != '') {
                                 echo stripslashes($this->lang->line('tribs'));
                                 } else echo "Trips"; ?>
                        </button>
                        <ul class="dropdown-menu listings">
                           <div class="dropdownIcon"></div>
                           <div class="heading">
                              <div><?php if ($this->lang->line('tribs') != '') {
                                 echo stripslashes($this->lang->line('tribs'));
                                 } else echo "Trips"; ?></div>
                              <div
                                 onclick="javascript:window.location.href='<?php echo base_url(); ?>trips/upcoming'"
                                 style="cursor: pointer;"><?php if ($this->lang->line('view_tribs') != '') {
                                 echo stripslashes($this->lang->line('view_tribs'));
                                 } else echo "View Trips"; ?>
                              </div>  
                           </div>
                           <?php
                              foreach ($latestBookedTrips->result() as $bookedRentals):
                                  ?>
                           <div class="listings_R">
                              <div>
                                 <a href="<?php echo base_url(); ?>rental/<?php echo $bookedRentals->seourl; ?>"
                                    class="color1">
                                    <div>
                                       <span
                                          class="h7"><?php echo ucfirst($bookedRentals->product_title); ?> </span>
                                       - <?php if ($this->lang->line('Booked') != '') {
                                 echo stripslashes($this->lang->line('Booked'));
                                 } else echo "Booked"; ?>
									   
									   
                                    </div>
                                    <div class="reduceFont"><span
                                       class="number_s120"> <?php echo date('d', strtotime($bookedRentals->checkin)); ?> </span> <?php echo date('M', strtotime($bookedRentals->checkin)); ?>
                                       - <span
                                          class="number_s120"> <?php echo date('d', strtotime($bookedRentals->checkout)); ?> </span> <?php echo date('M', strtotime($bookedRentals->checkout)); ?>
                                       · <span
                                          class="number_s120"> <?php echo $bookedRentals->NoofGuest; ?> </span> <?php echo ($bookedRentals->NoofGuest > 1) ? 'guests' : 'guest'; ?>
                                    </div>
                                 </a>
                              </div>
                              <div>
                                 <?php
                                    $imageUrl = 'dummyProductImage.jpg';
                                    if ($bookedRentals->product_image != "" && file_exists('./images/rental/' . $bookedRentals->product_image)) {
                                        $imageUrl = $bookedRentals->product_image;
                                    }
                                    ?>
                                 <a href="#" class="imgBlock"
                                    style='background-image: url("<?php echo base_url(); ?>images/rental/<?php echo $imageUrl; ?>");'></a>
                              </div>
                           </div>
                           <?php endforeach; ?>
                        </ul>
                     </div>
                  </li>
                  <?php } ?>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><?php if ($this->lang->line('mm_messages') != '') {
                                 echo stripslashes($this->lang->line('mm_messages'));
                                 } else echo "Messages"; ?>
                        </button>
						
								 
						
                        <ul class="dropdown-menu listings msg">
                           <div class="dropdownIcon"></div>
                           <a href="<?php echo base_url(); ?>inbox">
                              <li class="listings_R">
									<?php
									$user_id=$userDetails->row()->id;									$msg_unread_count=0;									if($user_id!=''){ 										$sql=" select m.*,p.user_id as host_id from ".MED_MESSAGE." as m,".PRODUCT." as p where m.productId=p.id and m.receiverId=".$user_id." and ( ( m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No')) and m.msg_status=0";										$result=$this->db->query($sql);										$msg_unread_count=$result->num_rows();									}									$total=$msg_unread_count;
                                    ?>
                                 <div>
                                    <h6><?php if ($this->lang->line('Message') != '') {
                                 echo stripslashes($this->lang->line('Message'));
                                 } else echo "Message"; ?> <span class="number_s120">(<?php echo $total; ?>)</span></h6>
	
									
                                 </div>
                                 <div><span class="viewAll"
                                    onclick="javascript:window.location.href='<?php echo base_url(); ?>inbox'"> <?php if ($this->lang->line('view_all') != '') {
                                 echo stripslashes($this->lang->line('view_all'));
                                 } else echo "View All"; ?></span>
                                 </div>
                              </li>
							 
								 
							  
                           </a>
                           <?php
                              if ($experienceExistCount > 0) {
                                  if (!empty($userDetails)) {
                                      $total_exp = 0;
                                      $msg_unread_count_exp = 0;
                                      if ($user_id != '') {
                                          $sql = " select m.*,p.user_id as host_id from " . EXPERIENCE_MED_MSG . " as m," . EXPERIENCE . " as p where m.productId=p.experience_id and m.receiverId=" . $user_id . " and ( ( m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No')) and m.msg_status=0";
                                          $result = $this->db->query($sql);
                                          $msg_unread_count_exp = $result->num_rows();
                                      }
                                      $total_exp = $msg_unread_count_exp;
                                      ?>
                           <a href="<?php echo base_url(); ?>experience_inbox">
                              <li class="listings_R">
                                 <div>
                                    <h6><?php if ($this->lang->line('experience_message') != '') {
                                 echo stripslashes($this->lang->line('experience_message'));
                                 } else echo "Experience Message"; ?> <span
                                       class="number_s120">(<?php echo $total_exp; ?>
                                       )</span>
                                    </h6>
									
									
									
                                 </div>
                                 <div><span class="viewAll"
                                    onclick="javascript:window.location.href='<?php echo base_url(); ?>experience_inbox'"><?php if ($this->lang->line('view_all') != '') {
                                 echo stripslashes($this->lang->line('view_all'));
                                 } else echo "View All"; ?></span>
                                 </div>
                              </li>
                           </a>
                           <?php }
                              } ?>
                        </ul>
                     </div>
                  </li>
				  
				  
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                           <div class="userIcon">
                              <?php
                                 if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
                                     $imgSource = "images/users/" . $userDetails->row()->image;
                                 } else {
                                     $imgSource = "images/users/profile.png";
                                 }
                                 echo img($imgSource, TRUE, array());
                                 ?>
                           </div>
                        </button>
                        <ul class="dropdown-menu">
                           <div class="dropdownIcon"></div>
                           <li>
                              <a href="<?php echo base_url(); ?>dashboard"><?php if ($this->lang->line('header_dashboard') != '') {
                                 echo stripslashes($this->lang->line('header_dashboard'));
                                 } else echo "Dashboard"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>listing/all"><?php if ($this->lang->line('header_listing') != '') {
                                 echo stripslashes($this->lang->line('header_listing'));
                                 } else echo "Your Listings"; ?></a>
                           </li>
                           <?php
                              if ($experienceExistCount > 0) {
                                  ?>
                           <li>
                              <a href="<?php echo base_url(); ?>experience/all"><?php if ($this->lang->line('my_experience_list') != '') {
                                 echo stripslashes($this->lang->line('my_experience_list'));
                                 } else echo "My Experiences List"; ?></a>
                           </li>
                           <?php } ?>
                           <li>
                              <a href="<?php echo base_url(); ?>listing-reservation"><?php if ($this->lang->line('YourReservations') != '') {
                                 echo stripslashes($this->lang->line('YourReservations'));
                                 } else echo "Your Reservations"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>trips/upcoming"><?php if ($this->lang->line('your_trips') != '') {
                                 echo stripslashes($this->lang->line('your_trips'));
                                 } else echo "Your Trips"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists"><?php if ($this->lang->line('wish_list') != '') {
                                 echo stripslashes($this->lang->line('wish_list'));
                                 } else echo "Wish List"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>settings"><?php if ($this->lang->line('settings_edit_prof') != '') {
                                 echo stripslashes($this->lang->line('settings_edit_prof'));
                                 } else echo "Edit Profile"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>account-payout"><?php if ($this->lang->line('referrals_account') != '') {
                                 echo stripslashes($this->lang->line('referrals_account'));
                                 } else echo "Account"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>your-wallet"><?php if ($this->lang->line('Wallet') != '') {
                                 echo stripslashes($this->lang->line('Wallet'));
                                 } else echo "Wallet";
                                 echo " (" . $currencySymbol . ' ' . currency_conversion('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount) . ")"; ?></a>
                           </li>
						   <?php if ($this->lang->line('logout_single') != '') {
                           $logout= stripslashes($this->lang->line('logout_single'));
                           } else $logout="Logout"; ?>
						   
						   
                           <?php
                              if ($this->session->userdata('fc_session_user_login_type') == "facebook") {
                                  ?>
                           <li><?php echo anchor('fb-user-logout', "$logout"); ?></li>

						   
						   
                           <?php
                              } else {
                                  ?>
                           <li><?php echo anchor('user-logout', "$logout"); ?></li>
                           <?php
                              }
                              ?>
                        </ul>
                     </div>
                  </li>
                  <?php } else { ?>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" data-toggle="modal" data-target="#signUp"
                           type="button"
                           onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('login_signup') != '') {
                           echo stripslashes($this->lang->line('login_signup'));
                           } else echo "Create  Account"; ?>
                        </button>
                     </div>
                  </li>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" data-toggle="modal" data-target="#signIn"
                           type="button"
                           onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('header_login') != '') {
                           echo stripslashes($this->lang->line('header_login'));
                           } else echo "Log in"; ?>
                        </button>
                     </div>
                  </li>
                  <?php } ?>
               </ul>
            </div>
         </div>
      </header>
      <!--Alert model-->
      <div id="model-alert" class="modal fade" role="dialog">
         <div class="modal-dialog modal-confirm">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="icon-box">
                     <i class="material-icons">check_circle</i>
                     
                  </div>
                  <h4 class="modal-title"><?php if ($this->lang->line('Successfully_saved') != '') {
                           echo stripslashes($this->lang->line('Successfully_saved'));
                           } else echo "Successfully saved"; ?> !</h4>
               </div>
			   
			   
               <div class="modal-body">
                  <div class="signUpIn">
                     <div>
                        <p class="text-center" id="alert_message_content"></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php if ($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close "; ?></button>
               </div>
            </div>
         </div>
      </div>


         <div id="model-alert-success" class="modal fade" role="dialog">
         <div class="modal-dialog modal-confirm">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="icon-box">
                     <i class="material-icons">&#xE87C;</i>
                     
                  </div>
                  <h4 class="modal-title">Success..!</h4>
               </div>
            
            
               <div class="modal-body">
                  <div class="signUpIn">
                     <div>
                        <p class="text-center" id="alert_message_content_success"></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php if ($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close "; ?></button>
               </div>
            </div>
         </div>
      </div>
	  
	  
	  <div id="model-alert-error" class="modal fade" role="dialog">
         <div class="modal-dialog modal-confirm">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="icon-box">
                     <i class="material-icons">&#xE87C;</i>
                     
                  </div>
                  <h4 class="modal-title" style="color: #f15e5e;">Warning..!</h4>
               </div>
            
            
               <div class="modal-body">
                  <div class="signUpIn">
                     <div>
                        <p class="text-center" id="alert_message_content_error"></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php if ($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close "; ?></button>
               </div>
            </div>
         </div>
      </div>