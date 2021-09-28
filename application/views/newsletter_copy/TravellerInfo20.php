<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#4f595b">
<tbody>
<tr>
<td>
<table class="devicewidth" style="background-color: #f8f8f8;" border="0" cellspacing="0" cellpadding="0" width="600" align="center">
<tbody>
<tr>
<td height="30" bgcolor="#4f595b">&nbsp;</td>
</tr>
<tr>
<td align="left" bgcolor="#4f595b"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="logo" width="200" /></td>
</tr>
<tr>
<td height="30" bgcolor="#4f595b">&nbsp;</td>
</tr>
<tr>
<td class="editable" style="color: #ffffff; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px 20px; background-color: #752b7e;" align="center" valign="middle">Hi <?php echo $travellername; ?></td>
</tr>
<tr>
<td height="40">&nbsp;</td>
</tr>
<tr>
<td style="color: #000; padding: 0px 10px; font-weight: bold; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center" valign="top">Your reservation request for <?php echo $productname; ?> has been submitted to Space Provider.</td>
</tr>
<tr>
<td height="40">&nbsp;</td>
</tr>
<tr>
<td style="color: #000; padding: 0px 20px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center">Your Space Provider will respond to you in 24 hrs time, but most of our Space Providers will reply more quickly than that! Once <?php echo $hostname; ?> ACCEPTS or DECLINES your reservation, we'll let you know.</td>
</tr>
<tr>
<td style="color: #000; padding: 10px 20px 10px 20px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center">We have authorized your payment method for <?php echo $totalprice; ?>, the full amount of the reservation. If your request is declined or expires, you will not be charged.</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center" valign="middle">
<div style="background-color: #752b7e; display: table; border-radius: 5px; color: #ffffff; font-family: Open Sans, Arial, sans-serif; font-size: 13px; text-transform: uppercase; font-weight: bold; padding: 7px 12px; text-align: center; text-decoration: none; width: 140px; margin: auto;"><a style="color: #ffffff; text-decoration: none;" href="<?php echo base_url(); ?>rental/<?php echo $prd_id; ?>"><img src="<?php echo base_url(); ?>server/php/rental/<?php echo $prd_image; ?>" alt="" width="300" /> (<?php echo $productname; ?>)</a></div>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr style="padding: 10px; float: left;">
<td align="center" valign="top">
<p style="margin: 0px; padding: 8px 10px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; background: #f1f1f1;">Reservation Request</p>
<table border="0" cellspacing="1" cellpadding="5" width="600" bgcolor="#EAEAEA">
<tbody style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;">
<tr>
<th width="75">Time</th> <th width="75">Date</th>
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
<td>&nbsp;</td>
</tr>
<tr>
<td height="0">&nbsp;</td>
</tr>
<tr>
<td style="padding: 0px 20px; color: #444444; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="left" valign="middle">
<p>Thanks!</p>
<p>The HomeStayDnn Team</p>
</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td height="30" bgcolor="#4f595b">&nbsp;</td>
</tr>
<tr>
<td align="center" bgcolor="#4f595b">&nbsp;</td>
</tr>
<tr>
<td height="50" bgcolor="#4f595b">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></body></html>