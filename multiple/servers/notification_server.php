<?php
include (dirname(__FILE__).'/../vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\network\Curl;
use prodigyview\system\Security;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/**
 * The class for sending emails
 */
class Emailer {

	function send($data) {
		$response = '';

		try {
			$mail = new PHPMailer(true);

			$mail->Host = 'smtp1.example.com;smtp2.example.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'user@example.com';
			$mail->Password = 'secret';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			$mail->setFrom('from@example.com', 'Mailer');
			$mail->addAddress($data['email'], $data['to']);

			$mail->isHTML(true);
			$mail->Subject = $data['subject'];
			$mail->Body = $data['message_html'];
			$mail->AltBody = $data['message_text'];

			$mail->send();

			$response = 'Email Sent';
		}
		catch (Exception $e) {
			$response = 'Email Not Sent';
		}

		return $response;
	}

}

/**
 * The class for sending push notifications
 */
class PushNotification {

	public function send($data) {

		$curl = new Curl('https://fcm.googleapis.com/fcm/send');
		
		$curl->addHeader('Authorization', 'key=<API_ACCESS_KEY>');
		$curl->addHeader('Content-Type', 'application/json');
		
		$curl->send('post', array(
			'notification' => json_encode($data['payload']),
			'priority' => 10
		));

		if ($curl->hasError) {
			return $curl->getError();
		} else {
			return $curl->getResponse();
		}

	}

}

//Start The Server
$server = new Socket('127.0.0.1', 8502, array(
	'bind' => true,
	'listen' => true
));


$server->startServer('', function($message) {

	echo "Processing...\n";

	//Decrypt our encrypted message
	Security::init();
	$message = Security::decrypt($message);

	//Turn the data into an array
	$data = json_decode($message, true);

	$response = 'Not Sent';

	//Verify that the correct token is being used
	if (isset($data['token']) && $data['token'] == 'ABC123-NotRealToken') {

		/**
		 * Route the request based on the type
		 */
		if ($data['type'] == 'email') {
			$email = new Emailer();
			$response = $email->send($data);
		} else if ($data['type'] == 'push_notification') {
			$notification = new PushNotification();
			$response = $notification->send($data);
		}
	}

	//Return an encrypted message
	return Security::encrypt($response);

}, 'closure');
