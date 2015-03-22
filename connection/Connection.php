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

namespace cmsoft\com\connection;

//necessary classes in other namespaces
use PDO;
use Exception;

//Necessary files.
require 'ConnectionException.php';

/**
 * 
 * This class is the connection between the app and any database supported by PDO
 * 
 * <b>IMPORTANT<b>: This class uses a file JSON to finds all information about the connection,
 * the information which is: dbms, host, database, username and password. Please, 
 * see the following file <connectionparameters.json>
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
     * Database management systems where is located the database.
     * 
     * @var string
     */
    private $dbms;
    
    /**
     * Hosting where is the database management systems
     * 
     * @var string
     */
    private $host;
    
    /**
     * Database name
     * 
     * @var string
     */
    private $database;
    
    /**
     * Database username
     * 
     * @var string
     */
    private $username;
    
    /**
     * Database user password
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
     * initializes a instance of this class with all its atributes as null.
     */
    function __construct() {
        
    }
    
    /**
     * 
     * Opens the connection.
     * 
     * <b>NOTE: </b>always you want to a connection to any database, you must
     * open the connection with this function.
     * 
     * @return bool true if the connection is ready or false if connection is not
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
     * <b>NOTE: </b> Can end the connection and don't use this function, 
     * but it's recommended that you call this function when you finish all
     * operations with the database.
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
     * <b>RECOMMENDATION:</b> You can use this function for other task different than
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
            return $this->oDb->exec($this->sSqlStatement);
        } catch (Exception $ex) {
            throw new ConnectionException("The Sql statement didn't execute because: " . $ex->getMessage());
        }
    }
    
    /**
     * 
     * Execute a statement sql type INSERT, UPDATE or DELETE and returns the 
     * number of rows affected by statement.
     * 
     * <b>RECOMMENDATION:</b> You can use this function for other task different than
     * insert, update or delete, but it's recommended that you use this function 
     * only if the statement is insert, update or delete.
     * 
     * @return int number of rows affected by any statement sql type INSERT
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
     * Reads the connection json filed and establishes the parameter for
     * the cnonnection.
     * 
     * @return bool true if the reading is correct or false, if the reading failed or 
     * the file does not exists
     * 
     * @throws ConnectionException
     */
    private function readJsonConnectionFile(){
        
        $json = file_get_contents("../../info/connectionparameters.json");
        
        if (!$json) {
            return false;
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
}
