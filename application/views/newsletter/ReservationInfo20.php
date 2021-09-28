<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table class="ui-sortable-handle currentTable" border="0" width="100%" align="left">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" width="100%" align="left">
<tbody>
<tr>
<td align="left"><img style="margin-bottom: 10px;" src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="logo" width="120" /></td>
</tr>
<tr>
<td class="editable" align="left" valign="middle">
<h1 style="font-size: 20px;">Hi <?php echo $travellername; ?></h1>
</td>
</tr>
<tr>
<td height="10">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top">Your reservation request for <?php echo $productname; ?> has been submitted to the Host/Agent.</td>
</tr>
<tr>
<td height="20">&nbsp;</td>
</tr>
<tr>
<td>
<p style="margin-bottom: 10px;">Your Host will respond to you in 24 hrs time, but most of our Hosts or Agents will reply more quickly than that! Once <?php echo $hostname; ?> ACCEPTS or DECLINES your reservation, we'll let you know.</p>
</td>
</tr>
<tr>
<td>
<p style="margin-bottom: 10px;">We have authorized your payment method for <?php echo $currencySymbol; ?><?php echo $totalprice; ?>, the full amount of the reservation. If your request is declined or expires, you will not be charged.</p>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<div><a style="color: #ffffff; text-decoration: none;" href="<?php echo base_url(); ?>rental/<?php echo $prd_id; ?>"><img src="<?php echo base_url(); ?>server/php/rental/<?php echo $prd_image; ?>" alt="" width="300" /> (<?php echo $productname; ?>)</a></div>
</td>
</tr>
<tr>
<td align="left">
<table border="0" width="100%" align="left">
<tbody>
<tr>
<td align="left" valign="top">
<p style="padding: 10px 0px; margin: 0px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; background: #f1f1f1;">Reservation Request</p>
<table border="0" cellspacing="1" cellpadding="5" width="100%" bgcolor="#EAEAEA">
<tbody style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;">
<tr>
<th>Time</th> <th>Date</th>
</tr>
<tr align="left">
<td bgcolor="#FFFFFF">Checkin<br /></td>
<td bgcolor="#FFFFFF"><?php echo $checkindate; ?></td>
</tr>
<tr align="left">
<td bgcolor="#FFFFFF">Checkout<br /></td>
<td bgcolor="#FFFFFF"><?php echo $checkoutdate; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="0">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="middle">
<p>Thanks!</p>
<p>The Occupyproperties Team</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div></body></html>