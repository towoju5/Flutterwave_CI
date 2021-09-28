<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#4f595b">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="0" cellpadding="0" width="600" align="center">
<tbody>
<tr>
<td height="30" bgcolor="#4f595b">&nbsp;</td>
</tr>
<tr>
<td align="left" bgcolor="#4f595b"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="<?php echo $meta_title; ?>" width="200" /></td>
</tr>
<tr>
<td height="30" bgcolor="#4f595b">&nbsp;</td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">HI <?php echo $first_name; ?> <?php echo $last_name; ?></td>
</tr>
<tr>
<td height="50">&nbsp;</td>
</tr>
<tr>
<td align="center">We're excited to tell you that you have booked <?php echo $rental_name; ?> To help make experience &nbsp;seamless, we suggest you continue the conversation with <?php echo $renter_fname; ?> <?php echo $renter_lname; ?></td>
</tr>
<tr>
<td align="center">through HomestayDnn message system to confirm their arrival time, ask any questions you may have, and help them figure out how to best get to your listing.</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center" valign="top">Itinerary</td>
</tr>
<tr>
<td align="center" valign="middle">
<div><a href="http://airbnb.zoplay.com/rental/<?php echo $prd_id; ?>"><img src="<?php echo $rental_image; ?>" alt="" width="300" /><?php echo $RENTAL_NAME; ?></a></div>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td align="center" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="600" bgcolor="#EAEAEA">
<tbody>
<tr>
<th width="75">Time</th><th width="75">Date</th>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Start Date</td>
<td bgcolor="#FFFFFF"><?php echo $checkin; ?></td>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">End Date</td>
<td bgcolor="#FFFFFF"><?php echo $checkout; ?></td>
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
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td align="center" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="600">
<tbody>
<tr>
<th align="left">Your Renter</th>
</tr>
<tr bgcolor="#EAEAEA">
<td width="150px"><img src="<?php echo $renter_image; ?>" alt="" width="161px" /></td>
<td>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td><?php echo $renter_fname; ?> <?php echo $renter_lname; ?></td>
</tr>
<tr>
<td><?php echo $ph_no; ?></td>
</tr>
</tbody>
</table>
</td>
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
<td align="left">Payment</td>
</tr>
<tr>
<td>On the day after the experience, the payout method you supplied will be credited. For details, see your Transaction History.</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td align="left">Cancellation Policy</td>
</tr>
<tr>
<td>$cancel_policy</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td width="300px" align="left" valign="top">
<table>
<tbody>
<tr>
<td width="300px" align="left" valign="top">
<table>
<tbody>
<tr>
<td><?php echo $currency_symbol; ?> <?php echo $currency_price; ?> &nbsp;per person</td>
<td>&nbsp;</td>
<td>
<p><?php echo $currency_symbol; ?><?php echo $currency_amount; ?> <?php echo $currency_type; ?></p>
</td>
</tr>
<tr>
<td>Security Deposit</td>
<td>&nbsp;</td>
<td><?php echo $currency_symbol; ?> <?php echo $securityDeposite; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td>Service Fee</td>
<td>&nbsp;</td>
<td><?php echo $currency_symbol; ?><?php echo $currency_serviceFee; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td>Total</td>
<td>&nbsp;</td>
<td><?php echo $currency_symbol; ?><?php echo $currency_netamount; ?> <?php echo $currency_type; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="middle">
<p>Thanks!</p>
<p>The HomeStayDnn&nbsp;Team</p>
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
<td height="50" bgcolor="#4f595b">&nbsp;<br /><br /></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></body></html>