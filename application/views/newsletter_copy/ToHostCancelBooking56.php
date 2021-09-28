<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><p>Booking Cancel Message</p>
<div>
<div><span>Hi <?php echo $host_name; ?></span><label>,</label>
<div>The Customer <?php echo $cust_name; ?> is Cancelled Your Property.The Reason is we have mentioned below..</div>
<div class="p ">
<div class="btn btn-primary space1">Property: <?php echo $prd_title; ?>&nbsp;&nbsp;</div>
<div class="btn btn-primary space1">Reason: <?php echo $reason; ?> &nbsp;&nbsp;</div>
<div class="btn btn-primary space1">Booking No: <?php echo $booking_no; ?> &nbsp;&nbsp;</div>
</div>
<div class="p ">Thanks <br />The HomestayDNN Team</div>
</div>
</div></body></html>