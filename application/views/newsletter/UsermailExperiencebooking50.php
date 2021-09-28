<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>

</head><body><div style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td align="left"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="<?php echo $meta_title; ?>" width="120" /></td>
</tr>
<tr>
<td height="20">&nbsp;</td>
</tr>
<tr>
<td class="editable" align="left" valign="middle">
<h1 style="font-size: 20px;">Hi <?php echo $first_name; ?> <?php echo $last_name; ?></h1>
</td>
</tr>
<tr>
<td align="left">
<p style="font-size: 16px; line-height: 1.7; margin-bottom: 10px;">We're excited to tell you that you have booked <?php echo $rental_name; ?> To help make experience seamless, we suggest you continue the conversation with <?php echo $renter_fname; ?> <?php echo $renter_lname; ?></p>
</td>
</tr>
<tr>
<td align="left">
<p style="font-size: 16px; line-height: 1.7; margin-bottom: 10px;">through Vacason&nbsp;message system to confirm their arrival time, ask any questions you may have, and help them figure out how to best get to your listing.</p>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top">
<h2 style="font-size: 18px;">Itinerary</h2>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<div><a href="http://vacason.com/<?php echo $prd_id; ?>"><img src="<?php echo $rental_image; ?>" alt="" width="300" /></a></div>
<div><a style="display: block; margin: 10px 0px;" href="https://vacason.com/<?php echo $prd_id; ?>"><?php echo $RENTAL_NAME; ?></a></div>
</td>
</tr>
<tr>
<td align="left">
<table border="0" width="100%" align="left">
<tbody>
<tr>
<td align="left" valign="top">
<table border="0" width="100%">
<tbody>
<tr>
<th align="left">Time</th><th align="left">Date</th>
</tr>
<tr align="left">
<td bgcolor="#FFFFFF">Start Date</td>
<td bgcolor="#FFFFFF"><?php echo $checkin; ?></td>
</tr>
<tr align="left">
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
<td align="left">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td align="left" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="100%">
<tbody>
<tr>
<th align="left">Your Guest<br /></th>
</tr>
<tr>
<td width="150px"><img src="<?php echo $renter_image; ?>" alt="" width="130px" /></td>
<td>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
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
<td align="left">
<h2 style="font-size: 18px; margin-top: 10px;">Payment</h2>
</td>
</tr>
<tr>
<td>On the day after the experience, the payout method you supplied will be credited. For details, see your Transaction History.</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td align="left">
<h2 style="font-size: 18px;">Cancellation Policy</h2>
</td>
</tr>
<tr>
<td>$cancel_policy</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td width="100%" align="left" valign="top">
<table>
<tbody>
<tr>
<td width="100%" align="left" valign="top">
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
<td>Cleaning Fee</td>
<td>&nbsp;</td>
<td><?php echo $currency_symbol; ?> <?php echo $cleaningFee; ?><?php echo $currency_type; ?></td>
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
<p>The Vacason&nbsp;Team</p>
</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td align="left">&nbsp;</td>
</tr>
<tr>
<td height="50">&nbsp;<br /><br /></td>
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
</div></body></html>