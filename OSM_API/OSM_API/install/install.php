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
	 * Do not add aditional items to this file as it is re-written by the installation/update
	 */
	$OSM_Login_File = "'.$OSM_Login_File.'";
	$OSM_Cache_Prefix = "'.$OSM_Cache_Prefix.'";
	$OSM_Base = "'.$OSM_Base.'";
	$OSM_API_ID = "'.$OSM_API_ID.'";
	$OSM_Token = "'.$OSM_Token.'";
	
	
	/*
	 * These variables relate to security within the system
	 */
	$SSH_Enabled = "'.$SSH_Enabled.'";
	$ResponseCodeKey = "'.$ResponseCodeKey.'";
	
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
		Check database folder chmod
		<h2>Security Configuration</h2>
		<p>
		The OSM API allows access to the Scout Details, security is very important. 		
		</p>
		<p>SSH - If your server does not have SSH you should not enable this. Enabling this option will allow for personal information to be displayed.</p>
		<p>Email Response Password - This is the code used to encrypt the email responses to ensure that the responses are protected when parents click them and help to stop malisous parents from altering other records. You do not need to remember this and can even leave it at the random value shown here;<br />
		<input name="ResponseCodeKey" value="<?php $ResponseCodeKey; ?>" maxlength="50" /></p>
		<h2>Database Config</h2>
		<p> SQLite</p>
		Offer to install and configure phpliteadmin - https://code.google.com/p/phpliteadmin/
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
		<input type="submit" value="Install" />
		
		<input type="hidden" name="Install" value="TRUE" />
	</form>
</body>
</html>
