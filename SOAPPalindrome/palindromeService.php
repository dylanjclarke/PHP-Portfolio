<?php
include "vendor/autoload.php";
use palindrome\Palindrome;
date_default_timezone_set('America/Louisville');

//wrap method as a function for the service
function checkPalindrome($possiblepalindrome)
{
	$palindrome = new Palindrome();
	return $palindrome->checkPalindrome($possiblepalindrome);
}
$server = new nusoap_server();

$server->configureWSDL("SOAP Palindrome","urn:soappalindrome"); // Configure WSDL file

$server->register(
	"checkPalindrome", // name of function
	array("possiblepalindrome"=>"xsd:string"),  // inputs
	array("return"=>"xsd:integer")   // outputs
);

$server->service(file_get_contents("php://input"));
