<?php

//Read in old hash table
$readfile = fopen('db/urls.txt', 'r');
$old_serialized_hashtable = fread($readfile, filesize('db/urls.txt'));
fclose($readfile);

//Unserialize
$old_hashtable=unserialize($old_serialized_hashtable);

//Generate hash, id pair until unique hash is made
do {
	$newID = openssl_random_pseudo_bytes(16, $cstrong);
	$newHashURL = md5($newID);
} while (array_key_exists($newHashURL, $old_hashtable));

//Add new hash, id pair to the hashtable
$old_hashtable[$newHashURL] = $newID;

//Serialize
$new_serialized_hashtable = serialize($old_hashtable);

$writefile = fopen('db/urls.txt', 'w');
fwrite($writefile, $new_serialized_hashtable);
fclose($writefile);

//Create new empty object for user
$newUser = array(
	"id" => "",
	"name_field" => "",
	"email_field" => "",
	"date_field" => "",
	"student_id_field" => NULL,
	"transfer_status" => "transfer",
	"section_1_courses" => [],
	"section_2_courses" => [],
	"section_3_courses" => [],
	"section_4_courses" => [],
	"track" => "",
	"section_5_courses" => [],
	"total_units" => 0
);

//Create new blank entry in db/db.json
$dbFile = fopen('db/db.json', 'r');
$dbJSON = fread($dbFile, filesize('db/db.json'));
fclose($dbFile);
$dbPHP = json_decode($dbJSON, true);
$dbPHP["users"][$newHashURL] = $newUser;
$dbFile = fopen('db/db.json', 'w');
fwrite($dbFile, json_encode($dbPHP));

header('Location: form.php?id=' . $newHashURL);

/*
<script type="text/javascript">
var book = <?php echo json_encode($book, JSON_PRETTY_PRINT) ?>;
var book = {
    "title": "JavaScript: The Definitive Guide",
    "author": "David Flanagan",
    "edition": 6
*/

?>