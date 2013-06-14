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
		$HTML .= $OSM_NoScoutsLinkedToParent;
	}
	else
	{
		// loop all scouts
		$ScoutIDs = DB_GetParentScouts($_POST['ParentID']);
		for($ScoutIDs as $ScoutID)
		{
			$HTML .= DisplayScoutOverview($ScoutID, &$AmountDue, &$UrgantAmount);
		}
		if($AmountDue > 0)
		{
			$HTML = "<p>Total Amount Owed to the group $AmountDue <br/> Minimum amount to pay £$UrgantAmount</p>" . $HTML;
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

function DisplayScoutOverview($ScoutID, &$AmountDue, &$UrgantAmount)
{
	$OSM 		= new OSM;
	$Scout 		= OSM->GetScout($ScoutID);
	$Section 	= DB_GetSection($Scout->GetSectionID());
	
	$HTML .= "<h2>" . $Scout->GetFullName() . " - " . $Scout->GetAge() . "</h2>";
	
	// If enabled for the section show the moving on date
	if($Section['sectionMovingDate'])
	{
		$HTML .= "<p>";
		$HTML .= $Scout->GetFirstName();
		if($Scout->MovingDateEstimated())
		{
			$HTML .= $OSM_ScoutMovingDateEstimated;
		}
		else
		{
			$HTML .= $OSM_ScoutMovingDate;
		}
		$HTML .= $Scout->GetMovingSection() . " on " .$Scout->GetMovingDate();
		$HTML .= "</p>";
	}
	
	// If Section Subs is enabled 
	if($Section['sectionSubs'])
	{
		$HTML .= "<p>";
		if($Scouts->GetDueSubs() > 0)
		{
			$HTML .= $Scout->GetFirstName() . $OSM_SubsPaid;
		}
		else
		{
			$HTML .= "£" . $Scouts->GetDueSubs() . $OSM_SubsDue . $Scout->GetFirstName();
			$UrgantAmount += $Scouts->GetDueSubs();
		}
		$HTML .= "</p>";
	}
	
	if($Section['sectionScoutDetails'])
	{
		$HTML .= "<p>To view the details that are stored for " .$Scout->GetFirstName() . ' <a href"?ParentPage=ViewScoutDetails&ampScoutID='.$Scout->GetScoutID().'">Click Here</a></p>';
	}
	
	$AmountDue += $UrgantAmount;
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
