<?php
// Set up
$from = 'steve@crownrockdesign.com';
$sendTo = 'sstout7576@gmail.com';
$subject = 'New message from Villa Francesca contact form';
$fields = array('firstname' => 'firstName', 'lastname' => 'lastName', 'areaCode' => 'areaCode','telNum' => 'telNum', 'email' => 'Email', 'purpose' => 'Reason for message', 'feedback' => 'Message', 'emailSignup' => 'Sign Up Yes!'); 
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// Actions

if (empty($_POST['message'])) {
	exit;
}

try
{
    $emailText = "New message from Villa Francesca contact form\n_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
   	}
	
	mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}