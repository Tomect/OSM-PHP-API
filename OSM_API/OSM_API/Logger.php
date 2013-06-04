<?php

$_enableDebug = false;
$_errorFileName = "errors.txt";

// Defines if the application is already loggin
$_logging = false;
$_logText = "";

class LogTypes
{
	const Error = 1;
	const Log = 2;
	const Debug = 3;
	const Info = 4;
}

function Logger($LogText, $LogType)
{
	// The application is already loggin another log.
	// This indicates that there has been an issue with previous log
	if($_logging)
	{
		// Write the error to a text file
		$error  = "<h2>Error - " . date('d/m/Y H:i:s') . "</h2>";
		$error .= "<h3>Original Error</h3>";
		$error .= $_logText;
		$error .= "<h3>New Error</h3>";
		$error .= $LogText;
		
		f_writer($_errorFileName, $error);
		
		exit;
	}
	
	// Update the global variables incase the log fails
	$_logging = true;
	$_logText = $LogText;
	
	switch ($LogType)
	{
		case(LogTypes::Error) :
			DB_AddLog($LogText, $LogType);
			break;
		case(LogTypes::Log) :
			DB_AddLog($LogText, $LogType);
			break;
		case(LogTypes::Debug) :
			break;
		case(LogTypes::Info) :
			DB_AddLog($LogText, $LogType);
			break;
				
		
	}
	
	$_logging = false;
}

function f_writer($File, $Content)
{
	// Check the file is writable
	if (is_writable($File)) 
	{
		// In our example we're opening $filename in append mode.
		// The file pointer is at the bottom of the file hence
		// that's where $somecontent will go when we fwrite() it.
		if (!$handle = fopen($File, 'a')) 
		{
			echo "Cannot open file ($File)";
			exit;
		}
	
		// Write $somecontent to our opened file.
		if (fwrite($handle, $Content) === FALSE) 
		{
			echo "Cannot write to file ($File)";
			exit;
		}
	
		fclose($handle);
	
	} 
	else 
	{
		echo "The file $File is not writable";
	}
}


?>
