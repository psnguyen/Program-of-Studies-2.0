<?php

//Grab user data javascript json
$str_json = file_get_contents('php://input');

//Grab db 
$dbFile = fopen('db/db.json', 'r');
$dbJSON = fread($dbFile, filesize('db/db.json'));
fclose($dbFile);

//Convert db to php object
$dbPHP = json_decode($dbJSON, true);

//Add user data php object to db php users object
//Open dbfile
//Write to dbfile, encoded as json

$decodedJSON = json_decode($str_json, true);
$id = $decodedJSON['id'];

$dbPHP["users"][$id] = json_decode($str_json, true);
$dbFile = fopen('db/db.json', 'w');
fwrite($dbFile, json_encode($dbPHP));
fclose($dbFile)

?>