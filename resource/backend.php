<?php

class Backend{
	public $db_host = "localhost";
	public $db_user = "root";
	public $db_pass = "";
	public $db_name = "ojt";
	
	public function conDB(){
		$con = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
		if($con->connect_error){
			echo "Connection error".$con->connect_eror;
		}else
			return $con;
	}
	
	public function logOut(){
		unset($_SESSION['user']);
		header("location:../index.php");
	}
	
	public function logIn($user,$pass){
		$vrfy = $this->conDB();
		$qry = "select username,replace(cast(aes_decrypt(password,'key1234') as char(100)), salt, ''), salt from users";
		$res = $vrfy->query($qry);
		//echo 'alert("Invalid Username or Passwordasd");';
		if($res)
				while($row=$res->fetch_assoc()){
					if($row['username']==$user && $row['replace(cast(aes_decrypt(password,\'key1234\') as char(100)), salt, \'\')']==$pass)
					if($user=='admin'){
							$_SESSION['user']=$user;
							header('location:resource/addash.php');
									  }
							
						else if($user=='associate'){
							$_SESSION['user']=$user;
							header('location:resource/asdash.php');
												   }
				}
			
		 echo 'alert("Invalid Username or Password");';
	}
	
	public function addDocs($paramname, $paramtitle, $paramemail){
		$con = $this->conDB();
		
		$qry = "insert into dashboard (date,title, sender, email) values (CURDATE(),'$paramtitle', '$paramname', '$paramemail');";
		$res = $con->query($qry);
		if($res){

		}else {
			
		}
	}
	
	public function displayDocsDash(){
		$con = $this->conDB();
		return $sql='SELECT * FROM dashboard order by id asc';
	}
	
	
	public function displayArchive(){
		$con = $this->conDB();
		return $sql='SELECT * FROM archive';
	}
	
	public function claimedDoc($claimid){
		$con=$this->conDB();
		$qry="select * from dashboard where id=".$claimid."";
		$res=$con->query($qry);
		while($row=mysqli_fetch_assoc($res)){
			$qry2="insert into archive (daterec, dateclaim, title, sender, email) values ('".$row['date']."',CURDATE(),'".$row['title']."','".$row['sender']."','".$row['email']."')";
			$res2=$con->query($qry2);
			$qry3="delete from dashboard where id=".$claimid."";
			$res3=$con->query($qry3);
		}
		
	}
	
	public function deleteDocDash($id){
		$con = $this->conDB();
		$sql="delete from dashboard where id=".$id."";
		$res=$con->query($sql);
	
	}
	
	public function deleteDocArc($id){
		$con = $this->conDB();
		$qry="delete from archive where id=".$id."";
		$res=$con->query($qry);
	
	}
	
	public function notifySender($id){
		require 'phpmailer/PHPMailerAutoload.php';
		require 'phpmailer/login.php';

		$mail = new PHPMailer; 
		//$mail->SMTPDebug = 4;
		//$mail->isSMTP();                                      
		$mail->Host = 'smtp.gmail.com';  
		$mail->SMTPAuth = true;                               
		$mail->Username = email;                 
		$mail->Password = pass;                           
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                    

		$mail->setFrom(email, 'Central Luzon State University Office');
		

		$con = $this->conDB();
		$qry = "select * from dashboard where id=".$id."";
		$res = $con->query($qry);
		$row = mysqli_fetch_assoc($res);
		$address=$row['email'];
		$doctitle = $row['title'];
		$sender=$row['sender'];
		
		$mail->addAddress($address);               
		$mail->addReplyTo(email, 'Central Luzon State University Office');   
		$mail->isHTML(true);                                  

		$mail->Subject = 'Your Document: '.$doctitle.' is ready to be claimed';
		$mail->Body    = '<div>Good day '.$sender.',<br><br> Your document has been approved and has been signed by the proper signee. You can claim it now anytime today in our office. <br><br>Regards!</div>';
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		
		}
	}

	public function updateDoc($id,$sender,$title,$email){
		$con = $this->conDB();
		$sql="update dashboard set title='".$title."', sender='".$sender."', email='".$email."' where id=".$id."";
		$res=$con->query($sql);
	}
}	
?>