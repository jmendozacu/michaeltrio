<?php
phpinfo();
$to = "mr.bhupi@gmail.com";
$name="jason";
$subject="test message";
$header="From: $name";
$message="blah blah blah";
$sentmail=mail($to,$subject,$message,$header);

echo $sentmail;

?>
