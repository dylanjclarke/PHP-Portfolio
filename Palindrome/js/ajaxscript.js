function checkPalindrome()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		//when response received from web service
    		if (this.readyState == 4 && this.status == 200) 
		{
 			var obj = JSON.parse(xhttp.responseText);   
   			if(obj.palindrome)
    			{
      				alert (document.getElementById("palindrome").value + " is a palindrome");
    			}
    			else
    			{
      				alert (document.getElementById("palindrome").value + " is not a palindrome");
    			}
    }
};

	xhttp.open("GET", "http://localhost/palindrome/checkPalindrome.php?word="+document.getElementById("palindrome").value, true);
	xhttp.send();
	return false;
}
