<?php
require_once '../OSM_API.php';

if($_POST['Install'] == "TRUE")
{
	$OSM = new OSM();
	
	$json = $OSM->Authorise_OSM($_POST['OSM_Email'], $_POST['OSM_Password']);
	
	$OSM_Secret = $json->secret;
	$OSM_Userid = $json->userid;
	
	$configFile = '		
	<?php
	/*
	 * This file is the OSM configuration 
	 * Do not add aditional items to this file as it is re-written by the installation 
	 */
	$OSM_Login_File = "'.$OSM_Login_File.'";
	$OSM_Cache_Prefix = "'.$OSM_Cache_Prefix.'";
	$OSM_Base = "'.$OSM_Base.'";
	$OSM_API_ID = "'.$OSM_API_ID.'";
	$OSM_Token = "'.$OSM_Token.'";
	
	
	/*
	 * These relate to the DB structure
	 */
	$DB_Method = "'.$DB_Method.'"; // SQL / SQLite
	$DB_Username = "'.$DB_Username.'";
	$DB_Password = "'.$DB_Password.'";
	$DB_Location = "'.$DB_Location.'"; // The path to the DB, normally localhost
	$DB_Database = "'.$DB_Database.'"; // The database name
	
	/*
	 * This is your OSM Username
	 * If you are having issues with the loging in try setting the OSM_Secret and OSM_Userid to ""
	 * This will then force the application to ask for your username and password again
	 */
	$OSM_Secret = "'.$OSM_Secret.'";
	$OSM_Userid = "'.$OSM_Userid.'";
	
	
	?>';
	
	
	
	
}



?>



<html>
<head>

</head>
<body>
	<h1>OSM PHP API - Installation</h1>
	<form name="OSM_Install" method="post" target="#">
		<h2>Server Config</h2>
		<p>This section shows the server configuration that must be completed.  If there are any red crosses, the system will not install.</p>
		
		<h2>Database Config</h2>
		<p>SQL / SQLite</p>
		<h2>OSM Config</h2>
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
		<input type="submit" value="Install" />
		
		<input type="hidden" name="Install" value="TRUE" />
	</form>
</body>
</html>