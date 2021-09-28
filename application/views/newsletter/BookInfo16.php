<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#fff">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="5" cellpadding="5" width="600" align="center">
<tbody>
<tr>
<td align="left"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="logo" width="130" /></td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">GREAT NEWS! YOU HAVE A RESERVATION REQUEST FROM <?php echo $travellername; ?>.</td>
</tr>
<tr>
<td align="center" valign="top"><?php echo $travellername; ?> would like to stay at (accommodation type) from <?php echo $checkindate; ?> to&nbsp;<?php echo $checkoutdate; ?></td>
</tr>
<tr>
<td align="center">Based on your price of <?php echo $currencySymbol; ?><?php echo $price; ?> per night along with Occupyproperties fees, your potential payout for this reservation is&nbsp;<?php echo $currencySymbol; ?><?php echo $totalprice; ?>.</td>
</tr>
<tr>
<td align="center" valign="middle">
<div><a href="<?php echo base_url(); ?>inbox">Accept</a> /  <a href="<?php echo base_url(); ?>inbox">Decline</a></div>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="5" cellpadding="5" width="100%" align="center">
<tbody>
<tr>
<td align="center" valign="top">
<p>Reservation Request</p>
<table style="margin-bottom: 20px;" border="0" cellspacing="5" cellpadding="5" width="100%" bgcolor="#EAEAEA">
<tbody>
<tr>
<th width="75">Time</th> <th width="75">Date</th>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Checkin<br /></td>
<td bgcolor="#FFFFFF"><?php echo $checkindate; ?></td>
</tr>
<tr align="center">
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
<td align="left" valign="middle"><span><?php echo $travellername; ?></span>&nbsp;request will expire after 24 hours, if you do not officially ACCEPT or DECLINE it.</td>
</tr>
<tr>
<td align="left" valign="middle">We appreciate your response as quickly as possible so your guest can plan their stay!</td>
</tr>
<tr>
<td valign="middle"><a href="#">(Remember: Not responding to this booking will result in your listing being ranked lower.)</a></td>
</tr>
<tr>
<th valign="middle">If you need help or have any questions, please visit <a href="#"><span class="__cf_email__">[email&nbsp;protected]</span> </a></th>
</tr>
<tr>
<td height="50">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="middle">
<p>Thanks!</p>
<p>The Occupyproperties Team</p>
</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td height="50">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div></body></html>