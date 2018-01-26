<?php
require_once './vendor/autoload.php';
date_default_timezone_set('America/Louisville');
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);


$palindrome_submitted = false;
$is_palindrome = false;
$text = "";
if (isset($_POST['palindrome']))
{
	
	$palindrome_submitted = true;
	$text = $_POST['palindrome'];
	//contact webservice
	$url = "http://localhost/cURLPalindrome/palindromeService.php";

	$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, "palindrome=".$text);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                       
	$response = curl_exec($ch); 
        curl_close($ch);         
	$decoded_response = json_decode($response);
	$is_palindrome = $decoded_response->palindrome;
}


echo $twig->render("checkPalindrome.html", array("palindromesubmitted" => $palindrome_submitted,"ispalindrome" => $is_palindrome, "text" => $text));

