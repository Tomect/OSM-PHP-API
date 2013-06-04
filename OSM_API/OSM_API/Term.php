<?php 
class TermType
{
	private $TermID = 0;
	private $StartTerm = "";
	private $EndTerm = "";
	private $HalfTerm = "";
	private $SectionID = 0;
	
	public function LoadFromOSM($TermDetails)
	{
		$this->TermID = $TermDetails->termid;
		$this->StartTerm = $TermDetails->startterm;
		$this->EndTerm = $TermDetails->endterm;
		$this->SectionID = $TermDetails->sectionid;
		
		$Term = DB_GetTermByID($this->TermID);
		$this->HalfTerm = $Term->GetHalfTermDate(); 
	}
	
	public function GetTermID()
	{
		return $this->TermID;
	}
	
	public function GetSectionID()
	{
		return $this->SectionID;
	}
	
	public function CurrentTerm()
	{
		if(now() >= $this->StartTerm &&
		   now() <= $this->EndTerm)
		{
		   	return true;
		}
		return false;
		
	}
	
	public function FirstHalfTerm()
	{
		if(now() >= $this->StartTerm &&
		   now() <= $this->HalfTerm)
		{
			return true;
		}
		else if(now() >= $this->HalfTerm &&
		   now() <= $this->EndTerm)
		{
			return false;
		}
		else
		{
			return null;
		}
	}
	
	public function SecondHalfTerm()
	{
		if(now() >= $this->StartTerm &&
		   now() <= $this->HalfTerm)
		{
			return false;
		}
		else if(now() >= $this->HalfTerm &&
		   now() <= $this->EndTerm)
		{
			return true;
		}
		else
		{
			return null;
		}
	}
	
	public function GetStartDate()
	{
		return 	$this->StartTerm;
	}
	
	public function GetEndDate()
	{
		return 	$this->EndTerm;
	}
	
	public function GetHalfTermDate()
	{
		return 	$this->HalfTerm;
	}
	
	public function UpdateStartDate($value)
	{
		// TODO validate the Date
		$this->StartTerm = $value;
	}
	
	public function UpdateEndDate($value)
	{
		$this->EndTerm = $value;
	}
	
	public function UpdateHalfTermDate($value)
	{
		$this->HalfTerm = $value;
	}
	
	public function UpdateRecords()
	{
		// Update OSM
		$OSM = new OSM();
		$OSM->UpdateTerm($this);
		
		//Update the DB 
		DB_UpdateTerm($this);
	}
}
?>
