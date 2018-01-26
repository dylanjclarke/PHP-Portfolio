<?php

namespace palindrome;

Class Palindrome
{

	public function checkPalindrome($word)
	{
		if (!isset($word))
       		{
           		return false;
       		}
   
       		//remove punctuation and spaces
       		$word = preg_replace("/[\\s\\.,';:\"]/", "",$word);   
       		
		// not a palindrome if it contains characters other than letters
        	if (preg_match("/^.*[^a-zA-Z0-9 ].*$/",$word))
       		{
            		return false;
        	}
	
		// not a palindrome if the empty string after punctuation and spaces 			// removed
		if ($word==='')
		{
			return false;
		}
	
        	//remove any capitalisation
        	$word = strtolower($word);
       
       	 	// check each pair of letters for equality
        	// and return false if they're inequal
        	for ($i=0; $i<(strlen($word)/2);$i++)
        	{
            		if (substr($word,$i,1) != substr($word,strlen($word)-$i-1,1))
            		{
                		return false;
           		}
        	}
        	return true;

	}
}
