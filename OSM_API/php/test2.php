<?php
session_start();
include 'OSM_API.php';
echo $OSMCache->printCache();
?>