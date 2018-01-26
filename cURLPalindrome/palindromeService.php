<?php
namespace curlpalindrome;
include "vendor/autoload.php";
use palindrome\Palindrome;
$palindrome = new Palindrome();
$word = $_POST['palindrome'];
echo (json_encode( array('palindrome' => $palindrome->checkPalindrome($word))));
 
