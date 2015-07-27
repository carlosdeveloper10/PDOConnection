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
 * 
 */

namespace org\cmsoft\connection;

//necessary classes in other namespaces
use PDO;
use Exception;

//Necessary files.
require 'ConnectionException.php';

/**
 * 
 * This class is the connection between the app and any database supported by PDO
 * 
 * <b>IMPORTANT<b>: This class uses a JSON file to finds all the information about the connection,
 * the information is: dbms, host, database, username and password. Please, 
 * see the following file <connectionparameters.json>, this file always must is 
 * in the server
 *
 * @author Carlos Mario <carlos_programmer10@hotmail.com>
 * 
 */
class Connection {
    
    /**
     * Last version class
     * 
     * @var string
     */
    const VERSION = "1.2";
    
    
    /**
     * path where is the json file<connectionparameters.json>
     * 
     * @var string
     */
    private $jsonPath;
    
    /**
     * Database management systems where the database is.
     * 
     * @var string
     */
    private $dbms;
    
    /**
     * Hosting where the database management systems is.
     * 
     * @var string
     */
    private $host;
    
    /**
     * Database's name
     * 
     * @var string
     */
    private $database;
    
    /**
     * Database's username
     * 
     * @var string
     */
    private $username;
    
    /**
     * Database's username password
     * 
     * @var string
     */
    private $password;


    /**
     * PDO Object.
     * 
     * @var string
     */
    private $oDb;
    
    /**
     * Sql statement
     * 
     * @var string
     */
    private $sSqlStatement;
    
    /**
     * initializes an instance of this class with all its atributes in null.
     */
    function __construct() {
        
    }
    
    /**
     * 
     * Opens the connection.
     * 
     * <b>NOTE: </b>Everytime you want to make a connection to any database, you must
     * open the connection with this function.
     * 
     * @return true if the connection is ready or false if connection is not
     * ready
     * 
     * @see Connection::close()
     * 
     * @throws ConnectionException
     */
    public function open(){
        
        $this->readJsonConnectionFile();
        $uriConnection = "".$this->dbms.":host=".$this->host.";dbname=".$this->database."";
        
        try {
            $this->oDb = new PDO($uriConnection, $this->username, $this->password);
            return isset($this->oDb);
        } catch (Exception $ex) {
            throw new ConnectionException("The database didn't open because: " . $ex->getMessage());
        }
        
        return false;
    }
    
    /**
     * 
     * Closes the connection.
     * 
     * <b>NOTE: </b> the connection can be ended without using this function, 
     * but it's recommended that you call this function when you finish all
     * operations within the database.
     * 
     * @see open()
     */
    public function close(){
        $this->oDb = null;
    }


    /**
     * 
     * Execute a statement sql type SELECT and returns the rows indexed by statement
     * 
     * <b>RECOMMENDATION:</b> You can use this function for other tasks different than the ones
     * select, but it's recommended that you use this function 
     * only if the statement is select.
     * 
     * 
     * @return object result of query type select
     * 
     * @see <code>Coonnection::executeUpdate()</code>
     * 
     * @throws ConnectionException
     */
    public function executeQuery (){
        
        $this->validateSqlStatement();
        
        try {
            return $this->oDb->query($this->sSqlStatement);
        } catch (Exception $ex) {
            throw new ConnectionException("The Sql statement didn't execute because: " . $ex->getMessage());
        }
    }
    
    /**
     * 
     * Execute a statement sql type INSERT, UPDATE or DELETE and returns the 
     * number of rows affected by statement.
     * 
     * <b>RECOMMENDATION:</b> You can use this function for other tasks different than
     * insert, update or delete, but it's recommended that you use this function 
     * only if the statement is insert, update or delete.
     * 
     * @returns int number of rows affected by any statement sql type INSERT
     * UPDATE or DELETE
     * 
     * @see <code>Coonnection::executeQuery()</code>
     * 
     * @throws ConnectionException
     */
    public function executeUpdate(){
        
        $this->validateSqlStatement();
        
        try {
            return $this->oDb->exec($this->sSqlStatement);
        } catch (Exception $ex) {
            throw new ConnectionException("The Sql statement didn't execute because: " . $ex->getMessage());
        }
    }
    
    /**
     * 
     * Validate if the sql statement is string or not, if there are any problem, 
     * then the function throws a ConnectionException
     * 
     * @throws ConnectionException
     */
    private function validateSqlStatement(){
        if ($this->sSqlStatement == null || $this->sSqlStatement == "") {
            throw new ConnectionException("The Sql statement is null or empty");
        }
        if (!is_string($this->sSqlStatement)) {
            throw new ConnectionException("The Sql statement is not type string");
        }
    }
    
    /**
     * 
     * Reads the connection json file and establishes the parameter for
     * the cnonnection.
     * 
     * @returns true if the reading is correct or false if the reading failed or 
     * the file does not exists
     * 
     * @throws ConnectionException
     */
    private function readJsonConnectionFile(){
        
        $json = file_get_contents($this->jsonPath);
        
        if (!$json) {
            throw new ConnectionException("The json connection file does not exist in the path: " . $this->jsonPath);
        }
        
        $parameters = json_decode($json, TRUE);
        
        try {
            
            $this->dbms = $parameters["dbms"];
            $this->host = $parameters["host"];
            $this->database = $parameters["database"];
            $this->username = $parameters["username"];
            $this->password = $parameters["password"];
            
        } catch (Exception $ex) {
            throw new ConnectionException("The json connection file is malformed");
        }
        
        return true;
    }
    
    /**
     * 
     * Set the sql statement
     * 
     * @param string Sql statement
     */
    public function setSqlStatement($sSqlStatement) {
        $this->sSqlStatement = $sSqlStatement;
    }
    
    /**
     * Set the json path.
     * 
     * @param string path of tje json file
     */
    public function setJsonPath($path){
        $this->jsonPath = $path;
    }
    
    
    
}
