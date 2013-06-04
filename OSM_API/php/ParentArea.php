<?php 

$CheckedLeader = false;
$Leader = false;
$LoggedIn = false;


function GetParentPage()
{
	$Page = $_GET['ParentPage'];
	$HTML = "<h1>Parent Area</h1>";

	Logger("Parent Area - Open page ," . $Page, LogTypes::Debug);


	switch ($Page)
	{
		case "EmailResponse" :
			$Data = $_GET['Data'];
			if($Response = CheckEmailResponseCode($Data) != false)
			{
				$OSM = new OSM();
				$OSM->UpdateEventRecord($Response[0], 
										$Response[1], 
										$SectionID, 
										"attending", 
										$Response[2]);
										
				
			}
			
			break;
	}

	return $HTML;
}

function GetDashboard()
{
	// Check Login
	if(!CheckLogin())
	{
		// Not Logged in
		Logger("Attemped to get the dashboard - not logged in" . $Page, LogTypes::Log);

		// Display the login form
		LoginForm();
		exit;
	}

	Logger("Load Dashboard", LogTypes::Debug);

	$Scouts = DB_GetParentScouts($ParentID);
	
	// check 1 scout link to account
	if(count($Scouts == 0))
	{
		$HTML .= "You have no Scouts linked to your account.  Please talk to your leader to have oyur child linked to your account.";
	}
	else
	{
	// loop all scouts
		for(;1 == 1;)
		{
			// 
			$HTML .= DisplayScoutOverview($ScoutID);
		}
	}
	
	
	
	return $HTML;
}

function GetInvertations($ScoutID)
{

}

function GetAttending($ScoutID)
{

}

function RespondToInvertation($ScoutID, $EventID, $Response)
{
	
}

function ListParentPayments($ScoutID, $TotalPayments)
{
	
}

function GetScoutDetails($ScoutID)
{
	
}

function RequestScoutDetailsChange(ScoutType $Scout)
{
	
}

function GetEventDetails($EventID)
{
	
}

function DisplayScoutOverview($ScoutID)
{
	
}

function CheckEmailResponseCode($EmailResponseCode)
{
	
	$plaintext = mcrypt_decrypt(MCRYPT_BLOWFISH, $ResponseCodeKey, $EmailResponseCode, MCRYPT_MODE_CFB);
	
	try
	{
		list($ScoutID, $EventID, $Response) = explode(":", $data);
		
		if(is_int($ScoutID) && is_int($EventID) && ($Response == "yes" || $Response == "no"))
		{
			return array($ScoutID, $EventID, $Response);
		}
	}
	reurn false;
	
}

function GenerateEmailResponseCode($ScoutID,  $EventID, $Response)
{
	// Create the verification code for the email
	global $ResponseCodeKey;
	$ResponseCode = mcrypt_encrypt(MCRYPT_BLOWFISH, $ResponseCodeKey, $ScoutID . ":" . $EventID . ":" . $Response, MCRYPT_MODE_CFB);

	// Return the Code
	return $ResponseCode;
}
// Login Functions
function LoginForm()
{

}

function Login()
{
	// Write Login Function
}

function CheckLogin()
{
	if($LoggedIn) return true;

	Logger("Check Login", LogTypes::Debug);

	//TODO Write Check Login Script
	return true;
}

function CheckLeader()
{
	// if the user has already checked, return the leader status
	if($CheckedLeader)return $Leader;

	Logger("Check Leader Permissions", LogTypes::Debug);

	//TODO Write Check Leader Script

}

?>
