<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div class="container" style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<div><img style="width: 120px;" src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="" />&nbsp;&nbsp;</div>
<div>
<h1 style="font-size: 20px;"><span>Hi</span><label><?php echo $username; ?>,</label></h1>
<div style="margin-bottom: 10px;">Welcome to&nbsp;Occupyproperties Please confirm your email to get started.</div>
<div class="p ">
<div class="btn btn-primary space1" style="margin-bottom: 10px;"><strong>Email</strong> : <?php echo $email; ?>&nbsp;&nbsp;</div>
<div class="btn btn-primary space1" style="margin-bottom: 10px;"><strong>Password</strong> : <?php echo $password; ?>&nbsp;&nbsp;</div>
<div class="btn btn-primary space1" style="width: 300px; margin-bottom: 10px;"><span><strong><a style="font-size: 20px; text-align: center; display: block; background-color: #752b7e; color: #fff; padding: 8px; margin: 20px 0; text-decoration: none;" href="<?php echo $cfmurl; ?>"> Confirm Email</a></strong></span></div>
</div>
<div class="smallHorizontal" style="width: 70px; height: 1px; background-color: #cacaca; margin: 15px 0;">&nbsp;</div>
<p style="color: #484848; font-size: 16px;">Thanks for your patience!</p>
<p style="color: #484848; font-size: 16px;">The <?php echo $email_title; ?> Team</p>
</div>
</div></body></html>