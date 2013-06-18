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

function SectionConfigForm()
{
	// Section Selection
	$HTML .= "<form method=\"post\"><select name=\"sectionID\" onchange='this.form.submit()'>";
		$HTML .= '<option value="-1">Select Section</option>';
		$Sections = DB_GetSections();
		foreach($Sections as $Section)
		{
			$HTML .= '<option value="{$Section->GetSectionID()}"';
			
			if($_POST['sectionID'] == $Section->GetSectionID())
			{
				$HTML .= ' selected';
			}
			
			$HTML .= '>{$Section->GetName()}</option>'
		}
	$HTML .= "</select>";
	$HTML .= '<noscript><input type="submit" value="Select Section"> /</noscript></form>';
	
	// Section Details
	if(isset($_POST['sectionID']) && $_POST['sectionID'] != -1)
	{
		$Section = DB_GetSection($_POST['sectionID']);
		
		$HTML .= "<form method=\"post\">";
		$HTML .= '<table>';
		$HTML .= '<tr><td colspan="2"><h3>Section Details</h3></td></tr>';
		$HTML .= '<tr><td>Section Name</td>';
		$HTML .= '<td><input type="text" maxlength="50" required value="{$Section->GetName()}" /></td></tr>';
		
		$HTML .= '<tr><td colspan="2"><h3>Section Finances</h3><p>Enter the subs amounts for the various intervals, if you enter 0 then that payment option will not show.</td></tr>';
		$HTML .= '<tr><td>Enable Subs</td>';
		$HTML .= '<td><input name="EnableSubs" type="checkbox" /></td></tr>';
		$HTML .= '<tr><td>Weekly Subs</td>';
		$HTML .= '<td><input name="Weekly" type="number" step="0.01" value="{$Section->GetWeeklySubs()}" /></td></tr>';
		$HTML .= '<tr><td>Half Term Subs</td>';
		$HTML .= '<td><input name="HalfTerm" type="number" step="0.01" value="{$Section->GetWeeklySubs()}" /></td></tr>';
		$HTML .= '<tr><td>Full Term Subs</td>';
		$HTML .= '<td><input name="Term" type="number" step="0.01" value="{$Section->GetWeeklySubs()}" /></td></tr>';
		$HTML .= '<tr><td colspan="2"><h3>Parents Area Config</h3><p>This section configures what the parents in the section see.</p></td></tr>';
		$HTML .= '<tr><td>Enable view Payments</td>';
		$HTML .= '<td><input name="EnablePayments" type="checkbox" /></td></tr>';
		
		$HTML .= '<tr><td>View Scout Details</td>';
		$HTML .= '<td><input name="EnableViewDetails" type="checkbox" /></td></tr>';
		$HTML .= '<tr><td>Edit Scout Details</td>';
		$HTML .= '<td><input name="EnableEditDetails" type="checkbox" /></td></tr>';
		$HTML .= '<tr><td>View Moving Date</td>';
		$HTML .= '<td><input name="EnableMovingDate" type="checkbox" /></td></tr>';
		
		$HTML .= '<tr><td>View Events</td>';
		$HTML .= '<td><input name="EnableViewEvents" type="checkbox" /></td></tr>';
		
		$HTML .= '<tr><td>View Event Responses</td>';
		$HTML .= '<td><input name="EnableEventResponse" type="checkbox" /></td></tr>';
		$HTML .= '<tr><td>View Program</td>';
		$HTML .= '<td><input name="EnableViewProgram" type="checkbox" /></td></tr>';
		
		$HTML .= '<tr><td>View Events</td>';
		$HTML .= '<td><input name="EnableViewEvents" type="checkbox" /></td></tr>';
		$HTML .= '</table>';
		$HTML .= '<input type="checkbox" name="UpdateOSM" checked /> Update OSM';
		$HTML .= '<input type="submit" value="Submit Data" />';
		
		$HTML .= "</form>";
	}
	
	return $HTML;
}

function processSectionConfigForm()
{
	if(!CheckAdmin())
		return;
		
	
}

function GetOrphanScouts()
{
	if(!CheckAdmin())
		return;
		
	$HTML .= "<h2>Orphan Scouts</h2>";
	
	$Scouts = DB_GetOrphanScoutIDs();
	if(count($Scouts) == 0)
	{
		$HTML .= "<p>All Scouts are linked to parents.</p>";
	}
	else
	{
		$HTML .= "<p>There are currently " . count($Scouts) . " Scouts that are not linked to parent accounts.</p>"
		$HTML .= "<ul>";
		foreach($Scouts as $ScoutID)
		{
			$Scout = new Scout;
			$Scout->GetScout($ScoutID)
			$HTML .= "<li>";
			$HTML .= $Scout->GetFullName()
			$HTML .= "</li>";
		}
		$HTML .= "</ul>";
	}
	return $HTML;
}

?>
