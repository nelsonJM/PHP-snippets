<?php

// Hidden Google fields

$hidden1 = $_POST['LEADCF7'];

$hidden2 = $_POST['LEADCF8'];

$hidden3 = $_POST['LEADCF9'];

$hidden4 = $_POST['LEADCF10'];

$hidden5 = $_POST['LEADCF11'];



// Form fields

$_POST['heyo'];

$_POST['First_Name'];

$_POST['Last_Name'];

$Company = $_POST['Company'];

$_POST['Email'];

$Phone = $_POST['Phone'];

$LeadMessage = $_POST['LEADCF1'];



// Zoho, form and site-specific fields

$data = array();

$data['xnQsjsdp']='XYfoWhvuBL4$';

$data['zc_gad']='';

$data['xmIwtLD']='mMzujjf7ou8yiol0emwDKjSTuCtxKnsO';

$data['actionType']='TGVhZHM=';

$data['returnURL']='http://www.steelsentry.com/thank-you';

$data['LEADCF29']='SF';

$data['LEADCF30']='SSentry.com';

$post_str = '';

foreach($data as $key=>$value){

	$post_str .= $key.'='.urlencode($value).'&';

}

$post_str = substr($post_str, 0, -1);

	if ($_POST['heyo'] != ""){

			$errors .= 'This appears to be spam.<br>';

		}

	if ($_POST['First_Name'] != ""){
		$httpPattern = '/^http/';
		$FirstName = filter_var($_POST['First_Name'], FILTER_SANITIZE_STRING);
		if ($_POST['First_Name'] == "") {
			$errors .= 'Please enter a valid name.<br>';
		} else {
			if (preg_match($httpPattern, $FirstName)) {
				$errors .= 'Your first name is spam.<br>';
			}
		}
	} else {
		$errors .= 'Please enter your first name.<br>';
	}
	
	if ($_POST['Last_Name'] != "") {
		$httpPattern = '/^http/';
		$LastName = filter_var($_POST['Last_Name'], FILTER_SANITIZE_STRING);
		if ($_POST['Last_Name'] == "") {
			$errors .= 'Please enter a valid name.<br>';
		} else {
			if (preg_match($httpPattern, $LastName)) {
				$errors .= 'Your last name is spam.<br>';
			}
		}
	} else {
		$errors .= 'Please enter your last name.<br>';
	}
	


	if ($_POST['Email'] != "") {  

            $Email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);  

            if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {   

                $errors .= "$Email is <strong>NOT</strong> a valid email address.<br/><br/>";
            }
        } else {  

            $errors .= 'Please enter your email address.<br/>';
    	}
	



    if ($_POST['Phone'] != "") {  
    		$httpPattern = '/^http/';
            $Phone = filter_var($_POST['Phone'], FILTER_SANITIZE_STRING);  
            if ($_POST['Phone'] == "") {  
                $errors .= "$Phone is <strong>NOT</strong> a valid phone number.<br/><br/>";
            } else {
				if (preg_match($httpPattern, $Phone)) {
					$errors .= 'Your phone is spam.<br>';
				}
			}
        } else {  

            $errors .= 'Please enter your phone number.<br/>';
    	} 
    



    if (!$errors) {

    	// then send the data to Zoho

    	$ch = curl_init();

    	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);

    	

    	curl_setopt($ch, CURLOPT_HEADER, true);

    	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

		curl_setopt($ch, CURLOPT_URL, 'https://crm.zoho.com/crm/WebToLeadForm');

		curl_setopt($ch, CURLOPT_POST, TRUE);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str."&First Name=$FirstName&Last Name=$LastName&Company=$Company&Email=$Email&Phone=$Phone&LEADCF1=$LeadMessage&LEADCF7=$hidden1&LEADCF8=$hidden2&LEADCF9=$hidden3&LEADCF10=$hidden4&LEADCF11=$hidden5");

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		



		$response = curl_exec($ch);

		// print_r(curl_getinfo($ch));

		header("Location:http://steelsentry.com/thank-you");

		curl_close($ch);

		

	require_once "Mail.php";

	$from_add = "testlead@steelsentry.com"; 



	$to_add = "ssentry1@gmail.com"; //<-- put your yahoo/gmail email address here



	$subject = "New Lead from SteelSentry.com";

	$body = <<<EMAIL

Below is the information for a new lead.

First Name: $FirstName.

Last Name: $LastName.

Email: $Email.

Phone: $Phone.

Company: $Company.

Additional Info: $LeadMessage.

Web Form: SF.

Web Source: SSentry.com.

GA Source: $hidden1

GA Medium: $hidden2

GA Campaign: $hidden3

GA Keyword: $hidden4

GA Content: $hidden5

EMAIL;

	

	$host = "mail.emailsrvr.com";

	$username = "testlead@steelsentry.com";

	$password = "password";



	$headers = array ('From' => $from_add,

		'To' => $to_add,

		'Subject' => $subject);



	$smtp = Mail::factory('smtp',

		array ('host' => $host,

			'auth' => true,

			'username' => $username,

			'password' => $password));

	$mail = $smtp->send($to_add, $headers, $body);



	if (PEAR::isError($mail)) {

				return false;

			} else {

				return true;

			}

	} else {

    	echo "The following errors were found on the submitted form. Please go back to correct them: <br>

    	<div style='color:red;'>.$errors.</div>
    	<p>If you need assistance, please contact us at (866) 683-7999 or info(at)steelsentry(dot)com.</p>";

    }

	 



?>