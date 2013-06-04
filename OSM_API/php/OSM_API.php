<?php 
/*
 * It is assumed that if you are using file, you are calling these function with your own user checking as
 * the function will return / update information from OSM
 */

// Include the OSM config file
require_once("OSM_Config.php");

// Include the classes
require_once ("Scout.php");
require_once ("Event.php");
require_once ("Term.php");

require_once 'DB_Mgr.php';

require_once 'Logger.php';

// Setup a OSM Cache
$OSMCache = new OSMCacheType();

class OSM
{
	var $ErrorCode = 0;
	var $Error = "";	
	
	function __construct()
	{
		if(!isset($OSM_Secret))
		{
			$this->Authorise_OSM();
		}
	}
	
	// Term Functions
	/*
	 * Get Current Term ID
	 * 
	 * Returns the current term ID for the 
	 */
	public function GetCurrentTermID($SectionID)
	{
		if(isset($_SESSION[$OSM_Cache_Prefix .'CurrentTerm' . $SectionID]))
		{
			return $_SESSION[$OSM_Cache_Prefix .'CurrentTerm' . $SectionID];
		}
		else
		{
			if(isset($_SESSION['Terms']))
			{
				$sectionsTerms = $_SESSION['Terms'];
			}
			else
			{
				$sectionsTerms = $this->OSM_perform_query('api.php?action=getTerms', array());
				$_SESSION['Terms'] = $sectionsTerms;
			}
			   
			
			foreach($sectionsTerms as $section)
			{  
				if($section[0]->sectionid == $SectionID)
				{
					foreach($section as $term) 
					{   
						if(strtotime($term->startdate) <= strtotime('now') &&
						   strtotime($term->enddate)   >= strtotime('now') &&  $termID == 0)   
						{   
							return $term->termid; 
						}   
					}   
				}   
			}   
		
			return "0";
		}
		
	} 
	
	public function GetPreviousTermID($SectionID)
	{
		
	}

	public function GetNextTermID($SectionID)
	{
		
	}
	
	public function GetTerm($TermID)
	{
		
	}
	
	public function GetTerm_NoCache($TermID)
	{
		
	}
	
	public function AddTerm(TermType $Term)
	{
		
	}
	
	public function DeleteTerm($TermID)
	{
		
	}
	
	public function UpdateTerm(TermType $Term)
	{
		
	}
	
	
	// Scout Functions
	/*
	 * Get a Scout record from OSM
	 * This function will use the cached record if it exitst,
	 * otherwise it will get the scout from OSM
	 */
	public function GetScout($ScoutID)
	{
		// Check if there is a cached Scout with that ID
		if(isset($_SESSION[$OSM_Cache_Prefix .'ScoutID' . $ScoutID]))
		{
			// Return the Scout from the session
			return $_SESSION[$OSM_Cache_Prefix .'ScoutID' . $ScoutID];
		}
		else
		{
			// Get the Scout from OSM
			return $this->GetScout_NoCache($ScoutID);
		}
	}
	
	/*
	 * Get a Scout record from OSM
	 * This function wil get the scout record from OSM and then
	 * update the cache.
	 */
	public function GetScout_NoCache($ScoutID)
	{
		global $OSMCache;
		
		$Scout_Record = new ScoutType();
		
		foreach ($this->GetAllLinkedSections() as $SectionID)
		{
			// Get the current term for the section
			$TermID = $this->GetCurrentTermID($SectionID);
			$url = "users.php?&action=getUserDetails&sectionid=$SectionID&termid=$TermID";
			$OSM_Result = $this->OSM_perform_query($url, null);
			
			foreach((array)$OSM_Result->items as $RawScout)
			{
				$Scout = new ScoutType();
				$Scout->LoadFromOSM($RawScout);
				
				// Save the Scout into the cache
				$OSMCache->set("Scout".$Scout->GetOSMID(), $Scout);
			}
		}	
		// Update the cache and return the scout record
		return $OSMCache->get("Scout".$ScoutID);
	}
	
	public function AddScout(ScoutType $Scout)
	{
		//TODO Add Scout
	}
	
	/*
	 * Update the Scout record 
	 * 
	 * Returns True if successful or False if there has been an error
	 */	
	public function UpdateScout(ScoutType $Scout)
	{
		$this->RaiseError("000", "Not Implemented");
		return false;
	}
	
	
	// Event Functions
	function AddEvent($Event)
	{
		
	}
	
	public function GetEvent($EventID)
	{
		
	}
	
	public function GetEvent_NoCache()
	{
		
	}
	
	public function UpdateEvent($Event)
	{
		
	}

	
	// Program Functions
	public function GetProgram($TermID)
	{
		
	}
	
	public function AddMeeting(MeetingType $Meeting)
	{
		
	}
	
	public function RemoveMeeting($MeetingID)
	{
	
	}
	
	public function UpdateMeeting(MeetingType $Meeting)
	{
		
	}
	
	
	// Attendance Functions
	public function GetAttendanceRegister()
	{
		
	}
	
	public function UpdateAttendanceRegister()
	{
		
	}

	
	// Flexi Records
	public function GetFlexiRecord($FlexiRecordID)
	{
		
	}
	
	public function GetFlexiRecord_NoCache($FlexiRecordID)
	{
	
	}
	
	public function AddFlexiRecord($FlexiRecord)
	{
		
	}
	
	public function UpdateFlexiRecord($FlexiRecord)
	{
		
	}

	public function DeleteFlexiRecord($FlexiRecordID)
	{
		
	}
	
	// Misc Functions
	public function SendEmail($To, $CC, $BCC, $From, $Subject, $Body, $Section)
	{
		return true;
	}
	
	public function GetCampDirectory()
	{
		
	}
	
	private function GetAllLinkedSections()
	{
		// Return the sections that are linked to the account
		return array_keys((array)$this->OSM_perform_query("api.php?action=getTerms", null));
	}
	
	// Error Reporting
	private function RaiseError($_ErrorCode, $_Error)
	{
		$ErrorCode = $_ErrorCode;
		$Error = $_Error;
	
		Logger("OSM API Error - " . $_ErrorCode . " - " . $Error, LogTypes::Error);
	}
	
	/*
	 * Reset Error Codes
	*
	* This function resets the error codes back to defaults
	*
	* No return
	*/
	public function ResetError()
	{
		$ErrorCode 	= 0;
		$Error 		= "";
	}
	
	
	// OSM Communication

	private function OSM_perform_query($url, $parts) 
	{
		
		global $OSM_API_ID, $OSM_Token, $OSM_Secret, $OSM_Userid, $OSM_Base;

		// Check the connection to OSM
		//$headers = get_headers($base, 1);
		//if ($headers[0] != 'HTTP/1.1 200 OK') 
		//{
			//$this->RaiseError("001", "Connection to OSM failed, Headers report -> " . $headers[0]);
			//exit;
		//}
		
		$parts['token'] = $OSM_Token;
		$parts['apiid'] = $OSM_API_ID;
		
		if ($OSM_Userid > 0) 
		{
			$parts['userid'] = $OSM_Userid;
		}
		if (strlen($OSM_Secret) == 32) 
		{
			$parts['secret'] = $OSM_Secret;
		}

		$data = '';
		foreach ($parts as $key => $val) 
		{
			$data .= '&'.$key.'='.urlencode($val);
		}
	
		echo $OSM_Base.$url.$data . "<br />";
		
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $OSM_Base.$url);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, substr($data, 1));
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		$msg = curl_exec($curl_handle);
		if(!$msg)
		{
			Logger("Error connecting to OSM - " . curl_error($curl_handle), LogTypes::Error);
		}
		return json_decode($msg);
	}
	
	private function OSM_query($url)
	{
		// If the query is not already in the session, run the query
		if(!$OSMCache->exists($url))
		{
			$OSMCache->set($url, OSM_perform_query($url, array()));
		}
		
		// return the value form the session
		return $OSMCache->get($url);
	}
	
	public function Authorise_OSM($Email, $Password)
	{
		global $OSM_Secret, $OSM_Userid, $OSM_Base;
	
		$parts['email'] = $Email;
		$parts['password'] = $Password;
		
		return $this->OSM_perform_query('users.php?action=authorise', $parts); 
	}
	
	private function Create_OSM_Config_File()
	{
		
	}
}


class OSMCacheType
{
	private $Items = array();
	var $Cache_Prefix = "";
	
	function __construct()
	{
		global $OSM_Cache_Prefix;
		$this->Cache_Prefix = $OSM_Cache_Prefix;
		
		// Get the exisiting items out of the session
		if(isset($_SESSION[$this->Cache_Prefix . 'Items']))
		{
			Logger("Get Items from the Cache", LogTypes::Debug);
			$this->Items = $_SESSION[$this->Cache_Prefix . 'Items'];
		}
	}
	
	public function set($name, $value)
	{
		// If this is a new variable stored to the cache add it
		if($this->Items == null || array_search($name, $this->Items) === FALSE)
		{
			Logger("Added $name to OSM Cache Items", LogTypes::Debug);
			array_push($this->Items, $name);
			
			// ensure that there are no duplicate values in the array
			$this->Items = array_unique($this->Items);
			
			// Update the session cache
			$_SESSION[$this->Cache_Prefix . 'Items'] = $this->Items;
		}
		
		// Store the variable to the cache
		$_SESSION[$this->Cache_Prefix . $name] = $value;
	}
	
	public function get($name)
	{
		// Ensure the item exists
		if($this->exists($name))
		{
			Logger("Get $name from OSM Cache", LogTypes::Debug);
			return 	$_SESSION[$this->Cache_Prefix . $name];
		}
		else
		{
			Logger("Try to get $name from OSM cache when not set", LogTypes::Info);
			return null;	
		}
	}
	
	public function exists($name)
	{
		// Check if the item is in the list of OSM cached items
		if(array_search($name, $this->Items) === FALSE)
		{
			return false;
		}
		else 
		{
			return true;
		}
	}
	
	public function delete($name)
	{
		Logger("Remove $name from OSM Cache", LogTypes::Debug);
		
		// remove the item from the session
		unset($_SESSION[$this->Cache_Prefix.'$name']);
		
		// remove the item from the list of cached items
		$item = array_search($name, $Items);
		if(!($item === FALSE))
		{
			unset($Items[$item]);
			
			// Update the session
			$_SESSION[$Cache_Prefix . 'Items'] = $Items;
		}
	}

	public function deleteCache()
	{
		// Logged as Info as this is only a advanced function
		Logger("Clear the OSM cache", LogTypes::Info);
		
		foreach($Items as $name)
		{
			delete($name);
		}
	}
	
	public function printCache()
	{
		// Logged as info as this could print secure infomation
		Logger("Print the OSM cache", LogTypes::Info);
		ob_start();
		echo "<h1>OSM Cache Print</h1>";
		var_dump($this->Items);
		foreach($this->Items as $name)
		{
			echo "<h2>$name</h2>";
			var_dump($_SESSION[$this->Cache_Prefix . $name]);
		}
		
		$HTML = ob_get_contents();
		ob_get_clean();
		
		return $HTML;
	}
}
?>

<?php
// OSM Cron Jobs
//TODO split into another file

class CronFrequency
{
	/*
	 * NOTE :- Adding items to this list does not add it to the running
	 *         This list serves to make the program readable
	 */
	const Never = 0;
	const Daily = 1;
	const Weekly = 2;
	const BiWeekly = 3;
	const Monthly = 4;
	const BiMonthly = 5;
	const BiAnnually = 6;
	const Annually = 7;
	const StartTerm = 8;
	const EndTerm = 9;
	const StartHalfTerm = 10;
	const EndHalfTerm = 11;
}

/*
 * This function checks which cron jobs are due to be run
 * To ensure that all the cron functions run correctly, this
 * should be schedualed to run daily
 */
function cron()
{
	$CronTimes = GetCronTimes();
	
}

/*
 * This function updates the next time that the cron jobs
 * will execute the functions
 */
function UpdateNextCron()
{
	$CronTimes = GetCronTimes();
	
	foreach($CronTimes as $cronTime)
	{
		$Frequency = $x;
		if($cronTime < date())
		{
			switch ($Frequency)
			{
				case CronFrequency::Never:
					break;
				case CronFrequency::Daily:
					break;
				case CronFrequency::Weekly:
					break;
				case CronFrequency::BiWeekly:
					break;
				case CronFrequency::Monthly:
					break;
				case CronFrequency::BiMonthly :
					break;
				case CronFrequency::BiAnnually:
					break;
				case CronFrequency::Annually :
					break;
				case CronFrequency::StartTerm:
					break;
				case CronFrequency::EndTerm:
					break;
				case CronFrequency::StartHalfTerm:
					break;
				case CronFrequency::EndHalfTerm:
					break;
				case default:
					Logger("Cron Frequency $Frequency does not exist", LogTypes::Error);
					break;
			}
			DB_UpdateNextCron($Frequency, $Date);
		}
	}
}

function SendEventReminders()
{
	
}

function SendPaymentReminders()
{
	
}

function SendLeaderUpdates()
{
	
}

function GenerateLeaderUpdate($LeaderID)
{
	
}

function SendParentUpdates()
{
	
}

function GenerateParentUpdate($ParentID)
{
	
}

function UpdateGlobalCache()
{
	
}

function GetCronTimes()
{
	
}

/*
 * This function updates the frequency that cron items
 * are run
 */
function UpdateCronTimes()
{
	
}

?>
