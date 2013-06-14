<?php
require_once '../OSM_API.php';

$install_Config_loc = "../OSM_Config.php";

// Installation Info
// This should not be modified as it will be used to ensure upgrades etc
// Major Versions - Large Change
// Minor Versions - Small Changes
// Sub Versions   - Bug fixes only, no Database changes
$InstallMajor = 0;
$InstallMinor = 0;
$InstallSub   = 0;
$MaximumUpgrade = "0.0.0";
$PreInstallIssues = array();
$PreInstallErrors = array();



// Check if the DB can be upgraded based on thre previous version and the 
// version to be installed, if this is false a new install will be performed
$CanUpgrade = false;
$NewInstall = false;
if(isset($CurrentVersion))
{
	$CurrentVersionArray = explode(".",$CurrentVersion, 3);
	if(count($CurrentVersionArray) == 3)
	{
		try
		{
			$CurrentMajor = $CurrentVersionArray[0];
			$CurrentMinor = $CurrentVersionArray[1];
			$CurrentSub   = $CurrentVersionArray[2];
			
			if(($CurrentMajor > $InstallMajor) ||
			   ($CurrentMajor == $InstallMajor && $CurrentMinor > $InstallMinor) ||
			   ($CurrentMajor == $InstallMajor && $CurrentMinor == $InstallMinor && $CurrentSub > $InstallSub))
			{
				// Downgrade
				array_push($PreInstallErrors, "The installed version is greater than the version that you are trying to install. The installation does not handle downgrades");
			}
			else
			{
				//TODO check that the system can be upgraded from the selected version
				// This currently assumes that all versions cant be upgraded
				$CanUpgrade = false;
				array_push($PreInstallIssues, "The system cannot be upgraded, this will force a new installation";
			}
		}
		catch
		{
			// There was an issue with the version number
			array_push($PreInstallIssues, "There was a problem prosessing the previous version number. If this is the first time you are installing this you can continue, if not please contact support.");
			unset($CurrentVersion);
		}
	}
}
else
{	
	// Set the flag to show it is a new install
	$NewInstall = true;
}

if($_POST['Install'] == "TRUE")
{
	$OSM = new OSM();
	
	if(!empty($_POST['OSM_Email']) && !empty($_POST['OSM_Password']))
	{
		$json = $OSM->Authorise_OSM($_POST['OSM_Email'], $_POST['OSM_Password']);
		
		$OSM_Secret = $json->secret;
		$OSM_Userid = $json->userid;
	}
	
	$configFile = '		
	<?php
	/*
	 * This file is the OSM configuration 
	 * Do not add aditional items to this file as it is re-written by the installation/update
	 */
	
	/*
	 * Installation misc config options
	 */ 
	 $CurrentVersion = "'.$CurrentVersion.'";
	
	
	/*
	 * These variables relate to security within the system
	 */
	$SSH_Enabled = "'.$SSH_Enabled.'";
	$ResponseCodeKey = "'.$ResponseCodeKey.'";
	
	/*
	 * These relate to the DB structure
	 */
	$DB_Password = "'.$DB_Password.'"; // Password to access the DB
	$DB_Location = "'.$DB_Location.'"; // The path to the DB
	$DB_Database = "'.$DB_Database.'"; // The database name
	
	/*
	 * This is your OSM Username
	 * If you are having issues with the loging in try setting the OSM_Secret and OSM_Userid to ""
	 * This will then force the application to ask for your username and password again
	 */
	$OSM_Secret = "'.$OSM_Secret.'";
	$OSM_Userid = "'.$OSM_Userid.'";
	
	$OSM_Login_File = "'.$OSM_Login_File.'";
	$OSM_Cache_Prefix = "'.$OSM_Cache_Prefix.'";
	$OSM_Base = "'.$OSM_Base.'";
	$OSM_API_ID = "'.$OSM_API_ID.'";
	$OSM_Token = "'.$OSM_Token.'";
	
	
	?>';	
}
?>



<html>
<head>

</head>
<body>
	<h1>OSM PHP API - Installation</h1>
	<?php
	if($NewInstall)
	{
		echo "<p>It looks like this is a new install, thank you for choosing to use OSM API.<br />If this is not a new install <b>STOP</b> please contact support.</p>";
	}
	else
	{
		if($CurrentVersion == $InstallVersion)
		{
			echo "<p>I can see that you already have this version of OSM API installed. You should only re run this installation if; <ul><li>You need to change your configuration</li><li>You are having issues</li></ul>If you do not want to change your configuration or are not having issues, please close this page NOW!<br />Otherwise please be very careful and check all of the options below.</p>";
		}
		else
		{
			
		}
	}
	
	// Check for  a DB error 
	if(isset($_GET['DB_Error']))
	{
		echo "<p>You have been brought to this page because there has been an error connecting to the database.  This error will cause all of the OSM API to stop working and must be fixed.  The Database returned the following information <ul><li>".$_GET['DB_Error']."</li></ul>If this information does not help you to diagnose the issue, try running the install page again, if this does not fix the issue, request some support.</p>"
	}
	
	?>
	<form name="OSM_Install" method="post" target="#">
		<h2>Server Config</h2>
		<p>This section shows the server configuration that must be completed.  If there are any red crosses, the system will not install.</p>
		<?php
		
		// Ensure that the 
		if(file_exists($install_Config_loc))
		{
			if(!is_writable($install_Config_loc) &&
				!chmod($install_Config_loc, 0666))
			{
				echo "<p class=\"Error\">There is already a config file but it is not writable.  I have tried to modifiy the permissions but you server wont let me. Please can you change the file permissions on $install_Config_loc and reload this page, if you need to do a chmod please use 0666 as the permission</p>";
				array_push($PreInstallErrors, "The config file $install_Config_loc is not writable.");
			}
			else
			{
            		echo "<p>A configuration file already exists.  I can overwrite it for you when you click install at the bottom of the page, do you want me to do this?" . '<input type="checkbox" name="overwriteConfig" checked />';	
			}
		}
		else
		{
			if(!fopen("../$install_Config_loc"))
			{
				echo "<p class=\"Error\">I have tried to make the config file for your installation, but I can't please change the permissions on the OSM_API folder so that I can write to it, permission 0666. When you then reload this page you should not see this error message</p>";
				array_push($PreInstallErrors, "The OSM_API directory is not writeable.");
			}
			
		}
		
		?>
		<h2>Security Configuration</h2>
		<p>
		The OSM API allows access to the Scout Details, security is very important. 		
		</p>
		<p>SSH - If your server does not have SSH you should not enable this. Enabling this option will allow for personal information to be displayed.</p>
		<p>Email Response Password - This is the code used to encrypt the email responses to ensure that the responses are protected when parents click them and help to stop malisous parents from altering other records. You do not need to remember this and can even leave it at the random value shown here;<br />
		<input name="ResponseCodeKey" value="<?php $ResponseCodeKey; ?>" maxlength="50" /></p>
		<h2>Database Config</h2>
		<p> SQLite</p>
		<?php
			// Check Database exists
			
		?>
		<input name="DB_Database" value="<?php $DB_Database; ?>" maxlength="50" />
		<input name="DB_Password" value="<?php $DB_Password; ?>" maxlength="50" />
		<h2>OSM Config</h2>
		<?php
			if(isset($OSM_Secret))
			{
				echo "<p>You have already connected to OSM, you do not need to reenter these details unless you want to change the user or you are having problems connecting</p>";
			}
			else
			{
				echo "<p>Please provide your OSM login details, you should only ever need to provide this information once and it is not saved.  Once you click install this is sent to OSM and an authorisation code is generated that is used for all future connections.</p>";
			}
		?>
		<table>
			<tr>
				<td>Email Address</td>
				<td><input name="OSM_Email" maxlength="50" /></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="OSM_Password"/></td>
			</tr>
		</table>
		<?php
		// Ensure that there are no errors to stop the install
		if(count($PreInstallErrors) == 0)
		{
			// No errors allow the installation
			
			// Check for any issues
			if(count($PreInstallIssues) > 0)
			{
				echo "<p>There have been a mumber of issues reported, these should not effect the installation, but please read through them before clicking install;<ul>";
			foreach($PreInstallIssues as $Issue)
			{
				echo "<li>$Issue</li>";
			}
			echo "</ul></p>";
			}
			
			// Display the install button
			echo '<input type="submit" value="Install" /><input type="hidden" name="Install" value="TRUE" />';
		}
		else
		{
			// Errors, list them
			echo "<p>There are a number of errors that must be solved before the installation can start;<ul>";
			foreach($PreInstallErrors as $Error)
			{
				echo "<li>$Error</li>";
			}
			echo "</ul></p>";
		}
		?>		
	</form>
</body>
</html>
