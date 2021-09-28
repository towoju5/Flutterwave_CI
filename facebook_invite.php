<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
appId:'161491604244904',
cookie:true,
status:true,
xfbml:true
});

function FacebookInviteFriends()
{
FB.ui({
method: 'apprequests',
message: 'Your Message diaolog'
});
}
</script>


Add This Code Where Ever You Want To Show The Invite Button
<div id="fb-root"></div>
<a href='#' onclick="FacebookInviteFriends();"> 
<img src="https://lh3.googleusercontent.com/-ESoug2foJBs/T-ntmH-Vs3I/AAAAAAAAGIM/FUQoD54w1oQ/s267/bringfriends.png">
</a>