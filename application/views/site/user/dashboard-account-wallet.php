<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting">

  <div class="top-listing-head">
 <div class="main">   
           <?php $this->load->view('site/user/main_nav_header');   ?>
		   </div></div>
	<div class="dash_brd">
    	<div id="command_center">
    
               
			<div class="lispg_top">	
            <!--Side nav header -->
            <?php 
             $this->load->view('site/user/sub_nav_header');  
            ?>
            	<div class="listiong-areas wallet-right">
    <div class="box">
      <div class="middle">
       
          <h2><?php //echo $heading;?> <?php if($this->lang->line('your_wallet') != '') { echo stripslashes($this->lang->line('your_wallet')); } else echo "Your Wallet";?></h2>
          <div class="section notification_section">
              <?php if($userDetail->row()->totalReferalAmount >0 ) {
                if($wallet_usage->row()->usedWallet!=null)
                {
                  $usedWallet = $wallet_usage->row()->usedWallet;
                  $usetCurrency = $wallet_usage->row()->currency_code;
                }else 
                  $usedWallet = "0.00";
               ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
                      <thead>
                        <tr >          
                          <td><strong><?php if($this->lang->line('user') != '') { echo stripslashes($this->lang->line('user')); } else echo "User";?></strong></td>
                          <td><strong><?php if($this->lang->line('total_wallet_amount') != '') { echo stripslashes($this->lang->line('total_wallet_amount')); } else echo "Total Wallet Amount";?></strong></td>
                          <td><strong><?php if($this->lang->line('used_from_wallet') != '') { echo stripslashes($this->lang->line('used_from_wallet')); } else echo "Used from Wallet";?></strong></td>
                          <td><strong><?php if($this->lang->line('balance_in_wallet') != '') { echo stripslashes($this->lang->line('balance_in_wallet')); } else echo "Balance in Wallet";?></strong></td>
                        </tr>
                      </thead>
                      
                      <tbody>
                        <tr>
                          <td><?php echo $userDetail->row()->firstname . ' '.$userDetail->row()->lastname;?></td>

                          <td>
                            <?php  echo $currencySymbol; ?>
                            <?php 
                            if($userDetail->row()->referalAmount_currency !=$this->session->userdata('currency_type'))
                            {

                              echo $cnt_referalAmnt =  convertCurrency($userDetail->row()->referalAmount_currency,$this->session->userdata('currency_type'),$userDetail->row()->totalReferalAmount);
                            }
                            else {
                              echo $cnt_referalAmnt =  $userDetail->row()->totalReferalAmount;
                            }  

                            echo ' '.$this->session->userdata('currency_type'); ?>
                          </td>
                          <td>
                            <?php // echo $usedWallet;?>
                            <?php  echo $currencySymbol; ?>
                            <?php 
                            if($usetCurrency !=$this->session->userdata('currency_type'))
                            {

                              echo $cnt_usedWallet = convertCurrency($usetCurrency,$this->session->userdata('currency_type'),$usedWallet);
                            }
                            else {
                              echo $cnt_usedWallet = $usedWallet;
                            }  

                            echo ' '.$this->session->userdata('currency_type'); ?>

                          </td>
                          
                          <td>
                          <?php  echo $currencySymbol.' '; 
                           echo ($cnt_referalAmnt - $cnt_usedWallet);
                           echo ' '.$this->session->userdata('currency_type'); 
                           ?></td>
                        </tr>
                      </tbody>
                      
                    </table>
                    <?php } else{ ?>
                    <h3 class="status-text"><strong><?php if($this->lang->line('wallet_empty_message') != '') { echo stripslashes($this->lang->line('wallet_empty_message')); } else echo "Your wallet Empty. Use invite friends for credit your wallet.";?></strong></h3><?php } ?>
           
          </div>

      

        <div class="clearfix"></div>
      </div>
    </div>



  </div></div>
         
  </div>
    </div>
</div>
<script type="text/javascript">
function dashboard_account_setting()
{
$('#country_warn').text('');
var country=$('#country').val();
if(country=='')
{
$('#country_warn').text('<?php if($this->lang->line('Please_Select_Country') != '') { echo stripslashes($this->lang->line('Please_Select_Country')); } else echo "Please Select Country";?>');
return false;
}
else
{
$('#dashboard_account_setting').submit();
}
}
		
	 
function removeError(idval){
	$("#"+idval+"_warn").html('');}
	
function changebotton(){
	$("#change_button").removeAttr('disabled');
	}
</script>
<!---DASHBOARD-->
<!---FOOTER-->
<?php 
$this->load->view('site/templates/footer');
?>