<?php 

function GeneratePassword()
{
	// The length of the password
	const $passLength = 8;
	
	$password = "";
		
	// Allowed password characters
	$passwordChrs = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0',  '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
	// Make the password of the specifed length
	for(i = 1; i < $passLength; i++)
	{
		// Add a random character to the password
		$password .= $passwordChrs[rand(0, count($passwordChrs) -1)];
	}
	
	return $password;
}


?>
