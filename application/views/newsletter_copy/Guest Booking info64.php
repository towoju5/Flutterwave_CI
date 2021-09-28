<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="0" cellpadding="0" width="600" align="center">
<tbody>
<tr>
<td align="left"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="logo" width="200" /></td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">HI <?php echo $TRAVELLERNAME; ?></td>
</tr>
<tr>
<td height="40">&nbsp;</td>
</tr>
<tr>
<td align="center" valign="top">Your reservation request for <?php echo $productname; ?> has been submitted to Space Provider.</td>
</tr>
<tr>
<td height="40">&nbsp;</td>
</tr>
<tr>
<td align="center">Your Space Provider will respond to you in 24 hrs time, but most of our Space Providers will reply more quickly than that! Once <?php echo $hostname; ?> ACCEPTS or DECLINES your reservation, we'll let you know.</td>
</tr>
<tr>
<td align="center">We have authorized your payment method for <?php echo $totalprice; ?>, the full amount of the reservation. If your request is declined or expires, you will not be charged.</td>
</tr>
<tr>
<td align="center" valign="middle">
<div><a href="<?php echo base_url(); ?>rental/<?php echo $prd_id; ?>"><img src="<?php echo base_url(); ?>server/php/rental/<?php echo $prd_image; ?>" alt="" width="300" />(<?php echo $PRODUCTNAME; ?>)</a></div>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td align="center" valign="top">
<p>Reservation Request</p>
<table border="0" cellspacing="1" cellpadding="5" width="600" bgcolor="#EAEAEA">
<tbody>
<tr>
<th width="75">Time</th><th width="75">Date</th>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Arrive</td>
<td bgcolor="#FFFFFF"><?php echo $checkindate; ?></td>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Depart</td>
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
<p>The HomeStayDnn Team</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></body></html>