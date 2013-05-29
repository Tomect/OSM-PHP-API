<?php 

function DB_Connect()
{
	null;
}

// Parent Functions
function DB_GetParentScouts($ParentID)
{
	
}

function DB_AddParent(ParentType $Parent)
{
	
}

function DB_RemoveParent($ParentID)
{
	
}

function DB_AddParentScoutLink($ParentID, $ScoutID)
{
	
}

function DB_RemoveParentScoutLink($ParentID, $ScoutID)
{
	
}


// Scout Functions
function DB_AddScoutNameToDB(ScoutType $Scout)
{
	
}

function DB_RemoveScout($ScoutID)
{
	
}


// Event Functions
function DB_AddEvent(EventType $Event)
{
	
}

function DB_UpdateEvent(EventType $Event)
{
	
}

function DB_RemoveEvent($EventID)
{
	
}


// Logging Functions
function DB_AddLog($LogText, $LogType)
{
	
}

function DB_GetLog($StartDate, $EndDate, $TotalPerPage, $Page)
{
	
}

function DB_AcknowledgeLog($LogID)
{
	
}



// IP Blocking
function DB_AddBlockedIP($IP, $Date, $Reason)
{
	
}

function DB_CleanBlockedIP()
{
	
}

function DB_RemoveBlockedIP($IP)
{
	
}

function DB_GetBlockedIP($AmountPerPage, $Page)
{
	
}

function DB_CheckBlockedIP($IP)
{
	
}


//Email Functions
function DB_AddEmail(EmailType $Email)
{
	
}

function DB_GetEmail($EmailID)
{
	
}

function DB_GetParentEmailIDs($ParentID)
{
	
}

function DB_MarkRead($ParentID, $EmailID)
{
	
}

function DB_RemoveEmail($EmailID)
{
	
}


// Term Functions
function DB_AddTerm(TermType $Term)
{
	
}

function DB_UpdateTerm(TermType $Term)
{
	
}

function DB_RemoveTerm($TermID)
{
	
}

function DB_GetTermByDate($Date)
{
	
}

function DB_GetTermByID($TermID)
{
	
}

?>
