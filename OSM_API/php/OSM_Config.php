<?php
/*
 * This file is the OSM configuration 
 * Do not add aditional items to this file as it is re-written by the installation 
 */
$OSM_Login_File = "OSM_Login.php";
$OSM_Cache_Prefix = "OSM_Cache";
$OSM_Base = "https://www.onlinescoutmanager.co.uk/";
$OSM_API_ID = "9";
$OSM_Token = "15ff3f55b77d3b93a38862610096e91b";


/*
 * These relate to the DB structure
 */
$DB_Method = "SQL"; // SQL / SQLite
$DB_Username = "";
$DB_Password = "";
$DB_Location = "localhost"; // The path to the DB, normally localhost
$DB_Database = ""; // The database name

/*
 * This is your OSM Username
 * If you are having issues with the loging in try setting the OSM_Secret and OSM_Userid to ""
 * This will then force the application to ask for your username and password again
 */
$OSM_Secret = "";
$OSM_Userid = "";


?>
