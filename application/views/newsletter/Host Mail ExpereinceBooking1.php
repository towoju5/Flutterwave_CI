<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>

</head><body><div style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="0" cellpadding="0" width="600" align="left">
<tbody>
<tr>
<td align="left"><img style="margin-bottom: 10px; border: none;" src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="<?php echo $meta_title; ?>" width="120" /></td>
</tr>
<tr>
<td class="editable" align="left" valign="middle">
<h1 style="font-size: 20px;">Hi <?php echo $renter_fname; ?> <?php echo $renter_lname; ?></h1>
</td>
</tr>
<tr>
<td align="left">
<p style="font-size: 16px; margin-bottom: 20px; line-height: 1.7; font-weight: normal;">We're excited to tell you that, your <?php echo $rental_name; ?> is now booked for you. To help make check-in seamless, we suggest you continue the conversation with your guest <?php echo $first_name; ?> <?php echo $last_name; ?></p>
</td>
</tr>
<tr>
<td align="left">
<p style="font-size: 16px; margin-bottom: 20px; line-height: 1.7; font-weight: normal;">through <span>Vacason</span>&nbsp;message system to confirm your guest arrival time, ask any questions you may have, and help them figure out how to best get to your Experience hosting.</p>
</td>
</tr>
<tr>
<td align="left" valign="top">
<h2 style="font-size: 18px;">Itinerary</h2>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<div><img style="display: block; margin-bottom: 10px;" src="<?php echo $rental_image; ?>" alt="" width="300" />
<p style="display: block; margin-bottom: 10px;"><?php echo $rental_name; ?></p>
</div>
</td>
</tr>
<tr>
<td align="left">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td align="left" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="600" bgcolor="#EAEAEA">
<tbody style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;">
<tr>
<th width="75">Time</th> <th width="75">Date</th>
</tr>
<tr align="left">
<td bgcolor="#FFFFFF">Checkin</td>
<td bgcolor="#FFFFFF"><?php echo $checkin; ?></td>
</tr>
<tr align="left">
<td bgcolor="#FFFFFF">Checkout</td>
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
<td style="color: #4f595b; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px; padding: 10px 0px;" width="300px" align="left" valign="top">
<table style="width: 100%; font-size: 13px;">
<tbody>
<tr>
<td style="color: #4f595b; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px; padding: 10px 0px;" width="300px" align="left" valign="top">
<table style="width: 100%; font-size: 13px;">
<tbody>
<tr>
<td style="border-bottom: 1px solid #bbb;"><?php echo $currency_symbol; ?> <?php echo $currency_price; ?>*<?php echo $days; ?> Experience</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">
<p><?php echo $currency_symbol; ?><?php echo $currency_amount; ?> <?php echo $currency_type; ?></p>
</td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb;">Security Deposit</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $currency_symbol; ?><?php echo $securityDeposite; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb;">Other Fee</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $currency_symbol; ?><?php echo $cleaningFee; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">Total</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $currency_symbol; ?><?php echo $host_currency_netamount; ?> <?php echo $currency_type; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<p>Thanks!</p>
<p>The <span>Vacason</span>&nbsp;Team</p>
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
</tbody>
</table>
</div></body></html>