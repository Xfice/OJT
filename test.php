<?php
extract($_POST);
if(isset($send)){
	require 'resource/phpmailer/PHPMailerAutoload.php';
		require 'resource/phpmailer/login.php';

		$mail = new PHPMailer; 
		$mail->SMTPDebug = 4;
		$mail->isSMTP();                                      
		$mail->Host = 'smtp.gmail.com';  
		$mail->SMTPAuth = true;                               
		$mail->Username = 'nelrgsantiago@gmail.com';                 
		$mail->Password = 'neilthegreatest1495';                           
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                    

		$mail->setFrom('nelrgsantiago@gmail.com', 'Central Luzon State University Office');
		
		$mail->addAddress($email);               
		$mail->addReplyTo('nelrgsantiago@gmail.com', 'Central Luzon State University Office');   
		$mail->isHTML(true);                                  

		$mail->Subject = 'Your Document: '.$doctitle.' is ready to be claimed';
		$mail->Body    = '<div>Good day! Your document has been approved and has been signed by the proper signee. You can claim it now anytime. Thanks!</div>';
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
}
?>
<form action="#" method="post">
<input type="text" name="email">
<input type="text" name="message">
<input type="submit" name="send">

</form>