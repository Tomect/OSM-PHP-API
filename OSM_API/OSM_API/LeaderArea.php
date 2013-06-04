<?php 
require_once 'OSM_Functions.php';

$OSM = new OSM;

function CheckAdmin()
{
	//TODO write the admin check
	return false;
}

function AddParentForm()
{
	$HTML = "Add Parent Form";
	
	return $HTML;
}

// Manage Parents
function AddParent()
{
	$Parent = new ParentType();
	
	$Parent->Email = $_GET['ParentEmail'];
	$Parent->Password = GeneratePassword();
	$Parent->Scouts = $_GET['Scouts'];
	
	DB_AddParent($Parent);
	
	//TODO write add parent
	$OSM->SendEmail($ParentEmail, "", "", $DefaultEmail, $Subject, $Body, $Section);
}

function RemoveParent($ParentID)
{
	//TODO Remove Parent
}

function AddParentScoutLink($ParentID, $ScoutID)
{
	
}

function RemoveParentScoutLink($ParentID, $ScoutID)
{
	
}


// Manage Payments
function AddPayment(PaymentType $Payment)
{
	
	if($Payment->Description == "Subs")
	{
		UpdateSubs($Payment->ScoutID, $Payment->Amount);
	}
}

function RemovePayment($PaymentID)
{
	
}

function ListLeaderPayments($StartDate, $EndDate, $TotalPayments)
{
	
}


// Manage Events
function AddEvent(EventType $Event)
{
	// TODO validate Event
	$Event = $OSM->AddEvent($Event);
	
	// If an ID has been set, the event has been created in OSM
	if($Event->ID > 0)
	{
		// Add the event to the DB
		if(DB_AddEvent($Event))
		{
			DB_AddEvent($Event);
			return $Event;
		}
		
	}
	
}

function UpdateEvent(EventType $Event)
{
	
}

function RemoveEvent($EventID)
{
	
}


// Registers
/*
 * Print the Attendance sheet for the section term
 */
function PrintAttendanceSheet($SectionID, $TermID)
{
	
}

/* 
 * Print the Register for the section and term
 */
function PrintRegister($SectionID, $TermID)
{
	
}


?>