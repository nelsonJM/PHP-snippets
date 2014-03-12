<?php

// // For the short form 
// if (isset($_POST['submit'])) {

	// Hidden Google fields
$hidden1 = $_POST['LEADCF7'];
$hidden2 = $_POST['LEADCF8'];
$hidden3 = $_POST['LEADCF9'];
$hidden4 = $_POST['LEADCF10'];
$hidden5 = $_POST['LEADCF11'];

// Form fields
// $FirstName = $_POST['First_Name'];
// $LastName = $_POST['Last_Name'];
$_POST['First_Name'];
// $_POST['Last_Name'];
$company = $_POST['Company'];
$_POST['Email'];
// $Email = $_POST['Email'];
$phone = $_POST['Phone'];
$prodRequest = $_POST['LEADCF31'];
$leadMessage = $_POST['LEADCF1'];
$esdPackage = $_POST['LEADCF3'];
$overheadLight = $_POST['LEADCF4'];
$undershelfLight = $_POST['LEADCF16'];
$lowerShelfHalf = $_POST['LEADCF17'];
$lowerShelfFull = $_POST['LEADCF18'];
$upperShelf = $_POST['LEADCF19'];
$binRail = $_POST['LEADCF20'];
$powerStrip = $_POST['LEADCF21'];
$profileDrawer = $_POST['LEADCF22'];
$utilityDrawer = $_POST['LEADCF23'];
$fileDrawer = $_POST['LEADCF24'];
$monitorRail = $_POST['LEADCF25'];
$artMonitorArm = $_POST['LEADCF26'];
$keyboardMouse = $_POST['LEADCF27'];
$totalLock = $_POST['LEADCF28'];

// Zoho, form and site-specific fields
$data = array();
$data['xnQsjsdp']='XYfoWhvuBL4$';
$data['zc_gad']='';
$data['xmIwtLD']='mMzujjf7ou9l3RTtxFB6ShRJ0yGCedn5';
$data['actionType']='TGVhZHM=';
$data['returnURL']='http://www.steelsentry.com/thank-you';
$data['LEADCF29']='QB';
$data['LEADCF30']='SSentry.com';
$post_str = '';
foreach($data as $key=>$value){
	$post_str .= $key.'='.urlencode($value).'&';
}
$post_str = substr($post_str, 0, -1);
$errors = '';
	if ($_POST['heyo'] != ""){

			$errors .= 'This appears to be spam.<br>';

		}
	if ($_POST['First_Name'] != ""){
		$httpPattern = '/^http/';
		$firstName = filter_var($_POST['First_Name'], FILTER_SANITIZE_STRING);
		if ($_POST['First_Name'] == "") {
			$errors .= 'Please enter a valid name.<br/>';
		} else {
			if (preg_match($httpPattern, $firstName)) {
				$errors .= 'Your first name is spam.<br>';
			}
		}
	} else {
		$errors .= 'Please enter your name.<br/>';
	}

	if ($_POST['Email'] != "") {  
            $email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);  
            if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {  
                $errors .= "$email is <strong>NOT</strong> a valid email address.<br/>";  
            }  
        } else {  
            $errors .= 'Please enter your email address.<br/>';  
    }

    if ($_POST['Phone'] != "") {  
    		$httpPattern = '/^http/';
            $Phone = filter_var($_POST['Phone'], FILTER_SANITIZE_STRING);  
            if ($_POST['Phone'] == "") {  
                $errors .= "$Phone is <strong>NOT</strong> a valid phone number.<br/>";  
            }  else {
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
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str."&First Name=$firstName&Company=$company&Email=$email&Phone=$phone&LEADCF31=$prodRequest&LEADCF1=$leadMessage&LEADCF3=$esdPackage&LEADCF4=$overheadLight&LEADCF16=$undershelfLight&LEADCF17=$lowerShelfHalf&LEADCF18=$lowerShelfFull&LEADCF19=$upperShelf&LEADCF20=$binRail&LEADCF21=$powerStrip&LEADCF22=$profileDrawer&LEADCF23=$utilityDrawer&LEADCF24=$fileDrawer&LEADCF25=$monitorRail&LEADCF26=$artMonitorArm&LEADCF27=$keyboardMouse&LEADCF28=$totalLock&LEADCF7=$hidden1&LEADCF8=$hidden2&LEADCF9=$hidden3&LEADCF10=$hidden4&LEADCF11=$hidden5");
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
Full Name: $firstName
Email: $email
Phone: $phone
Company: $company
Product Request: $prodRequest
Accessories
	ESD Package: $esdPackage
	48″ Overhead Light: $overheadLight
	48″ Undershelf Light: $undershelfLight
	Lower Shelf – Half Depth: $lowerShelfHalf
	Lower Shelf – Full Depth: $lowerShelfFull
	Upper Shelf: $upperShelf
	Bin Rail: $binRail
	Power Strip: $powerStrip
	3″ Profile Drawer: $profileDrawer
	6″ Utility Drawer: $utilityDrawer
	12″ File Drawer: $fileDrawer
	Monitor Rail: $monitorRail
	Articulating Monitor Arm: $artMonitorArm
	Keyboard Pullout w/ Mouse Tray: $keyboardMouse
	Total Lock Casters: $totalLock
Additional Info: $leadMessage
Web form: QB
Web Source: SSentry.com
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
    	echo "The following errors were found. Please go back to correct them: <br>
    	<div style='color:red;'>.$errors.</div>
    	<p>If you need assistance, please contact us at (866) 683-7999 or info(at)steelsentry(dot)com.</p>";
    }



?>

