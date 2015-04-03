<?php
/*
 * Copyright (c) Carlos Mario. 
 * Please, read the document linceseinfo.doc, to find information about license 
 * of this code 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */


//Necessary classes
use cmsoft\com\connection\Connection;

//Necessary files in other directories
require '../lib/connection/Connection.php';

$sql = "DELETE FROM tbl";

/**
 * The order of the calls are so important.
 */
$con = new Connection();
$con->setJsonPath("connectionparameters.json");
$con->open();//Always, you must open the DB.
$con->setSqlStatement($sql);
$int = $con->executeUpdate();
$con->close();//It is optional

if ($int > 0) {
    echo 'The delete was successful';
}else{
    echo 'Occurred a problem';
}
