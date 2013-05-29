<?php 
require_once 'OSM_API.php';

class ScoutType
{
	private $OSM_ID = 0;
	private $FirstName = "";
	private $Surname = "";
	private $DOB = "";
	private $Age = "";
	
	private $School = "";
	private $Religion = "";
	private $Ethnicity = "";
	private $Medical = "";
	private $Notes = "";
	private $Parents = "";
	
	private $PatrolID = "";
	private $Patrol = "";
	private $PatrolLeader = "";
	private $Joinned = "";
	private $Started = "";
	
	private $Address1 = "";
	private $Address2 = "";
	
	private $Email1 = "";
	private $Email2 = "";
	private $Email3 = "";
	private $Email4 = "";
	
	private $Phone1 = "";
	private $Phone2 = "";
	private $Phone3 = "";
	private $Phone4 = "";
	
	private $Custom1 = "";
	private $Custom2 = "";
	private $Custom3 = "";
	private $Custom4 = "";
	private $Custom5 = "";
	private $Custom6 = "";
	private $Custom7 = "";
	private $Custom8 = "";
	private $Custom9 = "";
	
	private $Subs = 0;
	
	/*

joining_in_yrs: "0"

patrolidO: "0"
patrolleaderO: "0"
sectionidO: "930"
type: ""
yrs: 0
	 */
	
	public function LoadFromOSM($ScouDetails)
	{
		$this->OSM_ID = $ScouDetails->scoutid;
		$this->FirstName = $ScouDetails->firstname;
		$this->Surname = $ScouDetails->lastname;
		$this->DOB = $ScouDetails->dob;
		$this->Age = $ScouDetails->age;
		
		$this->School = $ScouDetails->school;
		$this->Religion = $ScouDetails->religion;
		$this->Ethnicity = $ScoutDetails->ethnicity;
		$this->Medical = $ScoutDetails->medical;
		$this->Notes = $ScoutDetails->notes;
		$this->Parents = $ScoutDetails->parents;
		
		$this->PatrolID= $ScoutDetails->patrolid;
		$this->Patrol= $ScoutDetails->patrol;
		$this->PatrolLeader = $ScoutDetails->patrolleader;
		$this->Joinned = $ScoutDetails->joined;
		$this->Started = $ScoutDetails->started;
		
		$this->Address1 = $ScouDetails->address;
		$this->Address2 = $ScouDetails->address2;
		
		$this->Email1 = $ScouDetails->email1;
		$this->Email2 = $ScouDetails->email2;
		$this->Email3 = $ScouDetails->email3;
		$this->Email4 = $ScouDetails->email4;
		
		$this->Phone1 = $ScouDetails->phone1;
		$this->Phone2 = $ScouDetails->phone2;
		$this->Phone3 = $ScouDetails->phone3;
		$this->Phone4 = $ScouDetails->phone4;
		
		$this->Custom1 = $ScouDetails->custom1;
		$this->Custom2 = $ScouDetails->custom2;
		$this->Custom3 = $ScouDetails->custom3;
		$this->Custom4 = $ScouDetails->custom4;
		$this->Custom5 = $ScouDetails->custom5;
		$this->Custom6 = $ScouDetails->custom6;
		$this->Custom7 = $ScouDetails->custom7;
		$this->Custom8 = $ScouDetails->custom8;
		$this->Custom9 = $ScouDetails->custom9;
	}
	
	public function GetOSMID()
	{
		return $this->OSM_ID;
	}
	
	public function GetFullName()
	{
		return $this->FirstName . " " . $this->Surname;
	}
	
	public function GetFirstName()
	{
		return $this->FirstName;
	}
	
	public function UpdateFirstName($value)
	{
		$this->FirstName = $value;
	}
	
	public function GetSurname()
	{
		return $this->Surname;
	}
	
	public function UpdateSurname($value)
	{
		$this->Surname = $value;
	}
	
	public function GetDOB()
	{
		return $this->DOB;
	}
	
	public function UpdateDOB($value)
	{
		//TODO validate DOB
		$this->DOB = $value;
	}
	
	public function GetMovingDate()
	{
		
	}
	
	public function UpdateSubs($Amount)
	{
		$OSM = new OSM();
		// Update the amount paid
		$this->Subs += $Amount;
		
		// Call the update of the Scout on OSM
		return $OSM->UpdateScout($this);
	}
}

?>
