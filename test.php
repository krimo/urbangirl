<?php
$to = "krimo.hafsaoui@misterassur.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "someonelse@96.30.54.222";
$headers = "From:" . $from;
var_dump(mail($to,$subject,$message,$headers));
echo "Mail Sent.";
?>