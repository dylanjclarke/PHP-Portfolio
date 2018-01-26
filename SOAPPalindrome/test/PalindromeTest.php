<?php
namespace palindrome\test;
require "vendor/autoload.php";

use \palindrome\Palindrome;

class PalindromeTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $possiblePalindrome = '';
        $expectedResult = false;
	$palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);

        $this->assertEquals($expectedResult, $result);
    }

    public function testNull() 
    {
        $possiblePalindrome = null;
        $expectedResult = false;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result);    

	}
    
        
    
    public function testNonPalindrome() 
    {
        $possiblePalindrome = 'ab';
        $expectedResult = false;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result);   
 }
    
    public function testSingleLetter() 
    {
        $possiblePalindrome = 'a';
        $expectedResult = true;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result);  
  }    

    public function testPalindrome() 
    {
        $possiblePalindrome = 'racecar';
        $expectedResult = true;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result);   
 }   

    public function testPalindromeWithSpaces() 
    {
        $possiblePalindrome = 'racecar racecar';
        $expectedResult = true;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result);   
 }  
    
    public function testCapitalisedPalindrome() 
    {
        $possiblePalindrome = 'Racecar';
        $expectedResult = true;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result);   
 }   

    public function testNonAlpha() 
    {
        $possiblePalindrome = '%a%';
        $expectedResult = false;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result); 
   } 
    public function testPalindromeWithPunctuation() 
    {
        $possiblePalindrome = "Madam, I'm Adam.";
        $expectedResult = true;
        $palindrome = new \palindrome\Palindrome(); 
        $result = $palindrome->checkPalindrome($possiblePalindrome);
        
        $this->assertEquals($expectedResult, $result); 
   }  
    public function testPalindromeWithOnlyPunctuation()
    {
        $possiblePalindrome = ",.'";
        $expectedResult = false;
        $palindrome = new \palindrome\Palindrome();
        $result = $palindrome->checkPalindrome($possiblePalindrome);

        $this->assertEquals($expectedResult, $result);
   } 

}
