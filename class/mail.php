<?php 
if(is_file('../../PHPMailer/PHPMailerAutoload.php')){
    require_once '../../PHPMailer/PHPMailerAutoload.php';
}
else if(is_file('../PHPMailer/PHPMailerAutoload.php')){
    require_once '../PHPMailer/PHPMailerAutoload.php';
}
else{
    require_once 'PHPMailer/PHPMailerAutoload.php';
}

class ngs_mail{
	var $subject="";
	var $body="";
	var $obj_mail;
	var $address=array();
	var $names=array();
	var $atachment_url='';
	var $fromName='';
        function __construct($sender) {
            $this->fromName=$sender;
        }
	
	function sendmail(){
                print 'Start sending mail';
		$mail = new PHPMailer;
		$mail->isSMTP();
		//$mail->Host = 'smtp.gmail.com';
		$mail->Host = 'smtp.zoho.com';
		$mail->Port=587;
		$mail->SMTPAuth = true;
		//$mail->SMTPDebug=3;
		//$mail->Username = 'kumarahhc.ngs@gmail.com';
		//$mail->Password = 'Ngsadmin@123';
		$mail->Username = 'serviceadmin@ngslanka.com';
		$mail->Password = 'uhb@rdx#885';
		$mail->SMTPSecure = 'tls';
		$mail->From = 'serviceadmin@ngslanka.com';
		$mail->FromName = $this->fromName;
		//$mail->addReplyTo('lasantha@energynetlk.com', 'Lasantha');
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		$mail->Subject = $this->subject;
		$mail->Body    = $this->body;
		if($this->atachment_url!=''){
			$mail->AddAttachment($this->atachment_url);      // attachment
		}
		
		$i=0;
		foreach ($this->address as $email){
			$mail->addAddress($email,$this->names[$i]);
			$i++;
		}
		if(!$mail->send()) {
		   return false;
		}
		else {
			return true;
		}
	}
	
}
?>