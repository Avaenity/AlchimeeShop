<?php# Check If Request Is From Ajax & Method Is POSTif(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST') {	# Form Data    $form_json = json_decode($_POST['data'], true);	# The Name	$user_name = $form_json['name'];	# The Email	$user_email = $form_json['email'];	# The Phone	$user_phone = $form_json['phone'];	# The Message	$user_message = $form_json['message'];		# Include Swift Mailer Library    require_once 'swift_mailer/swift_required.php'; 		## Replace With Your SMTP Details !!	$smtp_server = 'SMTP_SERVER';	$smtp_port = 'SMTP_PORT'; //587	$smtp_username = 'SMTP_USERNAME';	$smtp_pass = 'SMTP_PASS';		# The Transport    $transport = Swift_SmtpTransport::newInstance(		$smtp_server, 		$smtp_port	)    ->setUsername($smtp_username)    ->setPassword($smtp_pass);    #Init    $mailer = Swift_Mailer::newInstance($transport);		## Email Headers	## Replace With Your Details !!!	$email_to = 'YOUR_EMAIL';	$email_to_name = 'YOUR_NAME';	$email_from = 'FROM_EMAIL';	$email_from_name = 'FROM_NAME';	$email_subject = 'SUBJECT';	# Responder Email HTML Body	$email_body = '		<b>You Have A New Message:</b><br><br>		Form: <b>'.$user_name.'</b><br>		Email: <b>'.$user_email.'</b><br>		Phone: <b>'.$user_phone.'</b><br><br>		Message: <b>'.$user_message.'</b><br>	';		# The Email	$responder_mail = Swift_Message::newInstance()        ->setFrom(array($email_from => $email_from_name))        ->setSubject($email_subject)        ->setTo(array($email_to => $email_to_name))		->setBody($email_body, 'text/html')    ;	# Send -> -> ->	if($mailer->send($responder_mail)){		#Return Succes JSON for jQuery		$response_array = array(			"status" => "success",			"message" => "Successfully Submitted. Thank You."		);	}else{		#Return Error JSON for jQuery		$response_array = array(			"status" => "error",			"message" => "Error Sending Email."    	);	}	# Return    header('Content-type: application/json');    echo json_encode($response_array);}#Killunset($_POST);exit();?>