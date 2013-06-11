<?php 
/*
 * This file contains a number of functions that are useful for createing a website linked with OSM
 * All return a HTML formated response in either a
 * Table
 * Unordered List
 * 
 * It is assumed that if you are using file, you are calling these function with your own user checking as
 * the function will return / update information from OSM
 */


require_once 'OSM_API.php';
require_once 'OSM_Functions_Config.php';


// Setup the OSM API connection 
$OSM = new OSM;

/*
 * Update the amount of subs paid for the specified scout in the current term
 * 
 * Return - The total amount of subs paid this term.  If the return is -1 then there has been an error
 */
function UpdateSubs($ScoutID, $Amount)
{
	// Get the Scout details
	// This function assumes that only one account is likley to be updating subs records
	// at once. If this is not the case, call GetScout_NoCache instead, however this will 
	// slow the execution of this function.
	$Scout = $OSM->GetScout($ScoutID);
	
	// Update the amount paid
	$Scout->Subs = $Scout->Subs + $Amount;
	
	// Update the Scout record to OSM
	if(!$OSM->UpdateScout($Scout))
	{
		//TODO add error handling
		return -1;
	}
	
	return $Scout->Subs;
}

/*
 * Returns the badge records in a HTML table for a individual scout
 */
function GetBadgeRecords($ScoutID)
{
	
}

/*
 * Returns the badge records in a HTML table for a section
 */
function GetSectionBadgeRecords($SectionID)
{
	
}

/*
 * Returns a flexi record in a HTML table for the specified flexi record
 */
function GetFlexiRecord($FlexiID)
{
	
}

/*
 * Returns the due badges in a HTML unordered list
 * 
 * If no badges are due, returns the OSM_NoDueBadges
 */
function GetDueBadges($Section)
{
	
}

/*
 * Returns the birthdays in the next 4 weeks in a HTML unordered list
 *
 * If no badges are due, returns the OSM_NoCloseBirthdays
 */
function GetCloseBirthdays($Section)
{
	
}

/*
 * Returns a HTML unordered list of the scouts that have been away for the 
 * specified number of weeks. This does not include authorised absences
 */
function GetScoutAway($Section, $Weeks)
{
	
}

/*
 * Returns a HTML table with the current badge stocks for the specified section
 */
function GetBadgeStocks($Section)
{
	
}

/*
 * Returns a unordered list of scouts that have not paid the 
 * specified amount of Subs
 * 
 * If all the subs have been paid, returns OSM_NoDueSubs
 */
function GetDueSubs($Section, $Amount)
{
	$Scouts = DB_GetScoutsInSection($Section);
	
	// Loop all the Scouts
	foreach($Scouts as $ScoutID)
	{
		// Get the scouts details
		$Scout = $OSM->GetScout($ScoutID)
		
		// Check the Subs amount
		if($Scout->GetSubs() < $Amount)
		{
			$HTML .= "<li>";
			$HTML .= $Scout->FullName " owes £";
			$HTML .= ($Amount - $Scout->GetSubs());
			$HTML .= "</li>";
		}
	}
	
	if(isset($HTML))
	{
		return "<ul>" . $HTML . "</ul>";
	}
	else
	{
		return $OSM_NoDueSubs;
	}

}

/*
 * Returns the percentage completion of the specified badge for the specified scout
 */
function GetBadgePercentage($ScoutID, $BadgeID)
{
	
}

?>
