<?php
/*
 * Copyright (c) 2015 Carlos Mario
 * Please, click on the link to find information about licenese
 * LINK: https://github.com/carlosprogrammer/InputDialog/blob/master/LICENSE 
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
use org\cmsoft\connection\Connection;

//Necessary files in other directories
require '../lib/connection/Connection.php';

$sql = "INSERT INTO tbl VALUES('value1', 'value2')";

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
    echo 'The insert was successful';
}else{
    echo 'Occurred a problem';
}








