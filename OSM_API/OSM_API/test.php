<?php
session_start();
include_once 'OSM_API.php';

$OSM = new OSM();
$OSM->GetScout(74955);

echo $OSMCache->printCache();


?>