<?php
require_once './vendor/autoload.php';
date_default_timezone_set('America/Louisville');
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

//Sends possible palindrome to SOAP webservice and displays result

$palindrome_submitted = false;
$is_palindrome = false;
$text = "";
if (isset($_POST['palindrome']))
{
	
	$palindrome_submitted = true;
	$text = $_POST['palindrome'];
	//contact webservice

	$client = new nusoap_client("http://localhost/SOAPPalindrome/palindromeService.php?wsdl"); // Create a instance for nusoap client
	$response = $client->call('checkPalindrome',array("possiblepalindrome"=>$text));

	if(!empty($response))
	{
		$is_palindrome = $response;
	}
    
}

echo $twig->render("checkPalindrome.html", array("palindromesubmitted" => $palindrome_submitted,"ispalindrome" => $is_palindrome, "text" => $text));

