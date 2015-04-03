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


$sql = "SELECT * FROM tbl";

/**
 * The order of the calls are so important.
 */
$con = new Connection();
$con->setJsonPath("connectionparameters.json");
$con->open();//Always you must open the DB.
$con->setSqlStatement($sql);
$result = $con->executeQuery();
$con->close();//It is optional

foreach ($result as $row){
    echo "Result: " . $row[0] . " " . $row[1] . "</br>";
}
