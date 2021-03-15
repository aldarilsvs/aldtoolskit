<?php

namespace aldarilsvs\aldtoolskit;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of alMydSql
 *
 * @author aldaril
 */
class aldMySql
{
    protected $_connect = null;
    protected $_errorCode = 0;
    protected $_errorMsg = null;
    protected $_PDOStatement = null;


    public function __construct($host,$usr,$psw,$db)
    {
        $this->setSqlConnect($host, $usr, $psw, $db);
    }
    
    public function setSqlConnect($host,$usr,$psw,$db)
    {

        $dsn = 'mysql:host=' . $host . ';dbname=' . $db;
        
        try {
            
            $this->_connect = new \PDO($dsn,$usr,$psw);
            return $this;
            
        } catch (PDOException $e) {
            
            $this->_errorCode = $e->getCode();
            $this->_errorMsg = $e->getMessage();
            
            return false;
        }
    }
    
    public function getErrorCode()
    {
        return $this->_errorCode;
    }
    
    public function getErrorMessage()
    {
        return $this->_errorMsg;
    }
    
    public function getQuery($query)
    {
        if( $this->_connect == null )
            return null;
        
//        if( $this->_PDOStatement != null )
//            $this->_PDOStatement->closeCursor();
        
//        $this->_PDOStatement = $this->_connect->query($query);
        return $this->_connect->query($query);
        
//        return $this->_PDOStatement;
    }
    
    // end class
}
