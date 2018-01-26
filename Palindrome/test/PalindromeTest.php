<?php
namespace palindrome\test;
require "vendor/autoload.php";

use \palindrome\Palindrome;

class PalindromeTest extends \PHPUnit_Framework_TestCase
{
	//test that an empty string gives the result false.
	public function testEmpty()
    	{
        	$possiblePalindrome = '';
        	$expectedResult = false;
		$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);

        	$this->assertEquals($expectedResult, $result);	
    	}

	//test that a null value gives the result false.
    	public function testNull() 
    	{
        	$possiblePalindrome = null;
        	$expectedResult = false;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result);    

	}
        
    	//test that a simple non-palindrome gives the result false.
    	public function testNonPalindrome() 
    	{
        	$possiblePalindrome = 'ab';
        	$expectedResult = false;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result);   
 	}
    
	//test that a single letter gives the result true.
    	public function testSingleLetter() 
    	{
        	$possiblePalindrome = 'a';
        	$expectedResult = true;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result);  
  	}    

	//test that a simple palindrome gives the result true.
    	public function testPalindrome() 
    	{
        	$possiblePalindrome = 'racecar';
        	$expectedResult = true;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result);   
 	}   
	
	//test that a multi-word palindrome gives the result true.
    	public function testPalindromeWithSpaces() 
    	{
        	$possiblePalindrome = 'racecar racecar';
        	$expectedResult = true;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result);   
 	}  
    
	//test that a mixed case palindrome gives the result true.
    	public function testCapitalisedPalindrome() 
    	{
        	$possiblePalindrome = 'Racecar';
        	$expectedResult = true;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result);   
 	}   
	//test that a string with characters that are not alphanumeric
	//or punctuation gives the result false even if it otherwise has
	//the structure of a palindrome.
    	public function testNonAlpha() 
    	{
        	$possiblePalindrome = '%a%';
        	$expectedResult = false;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result); 
   	} 

	//test that a palindrome with punctuation 
	//gives the result true.
	public function testPalindromeWithPunctuation() 
    	{
        	$possiblePalindrome = "Madam, I'm Adam.";
        	$expectedResult = true;
        	$palindrome = new \palindrome\Palindrome(); 
        	$result = $palindrome->checkPalindrome($possiblePalindrome);
        
        	$this->assertEquals($expectedResult, $result); 
   	}
  	
	//test that a string containing only punctuation
	//gives the result false.
	public function testPalindromeWithOnlyPunctuation()
    	{
        	$possiblePalindrome = “.’.”;
        	$expectedResult = false;
        	$palindrome = new \palindrome\Palindrome();
        	$result = $palindrome->checkPalindrome($possiblePalindrome);

        	$this->assertEquals($expectedResult, $result);
   	} 

}
