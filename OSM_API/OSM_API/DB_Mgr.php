<?php 

//Connect to the DB
// need to ensure that if DB not installed, no error but should have neem called from the install page


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

function DB_GetScoutsInSection($SectionID)
{
	return array();
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


// Cron Functions
function DB_GetCronTimes()
{
	// SELECT * FROM tblCronTime;
}

function DB_UpdateNextCron($Frequency, $Date)
{
	
}


function DB_SaveGlobalCache($name, $value)
{
	// Check if exists in DB
	if(DB_GlobalCacheExists($name))
	{
		//UPDATE
	}
	else
	{
		//INSERT
	}
	 
}

function DB_GetGlobalCache($name)
{
	if(DB_GlobalCacheExists($name))
	{
		return NULL; // SELECT FROM ...
	}
	else
	{
		// Log an error
		return -1;
	}
}

function DB_GlobalCacheExists($name)
{
	return false;
}

function DB_DeleteGlobalCache($name)
{
	if(DB_GlobalCacheExists($name))
	{
		// DELECT FROM
	}
}

function DB_GetGlobalCacheList()
{
	return array();
}

// Install and Update Functions
function DB_Install()
{
	
	// Cron Table
	$SQL = "CREATE TABLE 'tblCron' ('cronJob' TEXT PRIMARY KEY NOT NULL, 'cronFrequency' INTEGER default 0 , 'cronLastRun' INTEGER)";

	// Global Cache Table
	$SQL = "CREATE TABLE 'tblGlobalCache' ('cacheItem' TEXT PRIMARY KEY NOT NULL, 'cacheData' BLOB NOT NULL, 'cacheDate' INTEGER NOT NULL, 'cacheExpiry' INTEGER)";

	// Scout
	$SQL = "CREATE TABLE 'tblScout' ('scoutID' INTEGER PRIMARY KEY NOT NULL, 'scoutFirstName' INTEGER NOT NULL, 'scoutSurname' INTEGER NOT NULL)";
	
	
	// Email System
	$SQL = "CREATE TABLE 'tblEmail' ('emailID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'emailSubject' TEXT, 'emailText' TEXT, 'emailDate' INTEGER);";
	$SQL = "CREATE TABLE 'tblEmailParentLink' ('emailID' INTEGER NOT NULL, 'parentID' INTEGER NOT NULL, PRIMARY KEY ('emailID', 'parentID'))";
	
	
	
}
?>
