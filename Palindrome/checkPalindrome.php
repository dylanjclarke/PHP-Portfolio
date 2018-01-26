<?php

namespace palindrome;
include "vendor/autoload.php";
use palindrome\Palindrome;
$word = $_GET['word'];
$palindrome = new Palindrome();
echo (json_encode( array('palindrome' => $palindrome->checkPalindrome($word))));

