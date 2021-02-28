<?php

namespace aldtools;

class aldSqlite
{
    public $pdo;
    
    function __construct( string $filename )
    {
        if( $this->pdo == null )
            $this->pdo = new \PDO("sqlite:" . $filename);
    }
    
    function errorInfo()
    {
        if( $this->pdo )
        {
            return $this->pdo->errorInfo();
        }
    }
    
    function exec( string $query )
    {
        if( $this->pdo )
        {
            $this->pdo->exec( $query );
        }
    }
    
    function query( string $query )
    {
        if( $this->pdo )
        {
            return $this->pdo->query( $query );
        }
    }
    
    function getCountRow($sqlres)
    {
        return $sqlres->rowcount();
    }
    
    function fetch($sqlres)
    {
        return $sqlres->fetch(\PDO::FETCH_ASSOC);
    }
    
    function __destruct()
    {
    }
    
    function getLastCode()
    {
        return $this->lastErrorCode();
    }
    
    function createTbl($name)
    {
        ;
    }
    
    function dropTbl($name)
    {
        if( $this->pdo )
            $this->pdo->query('DROP TABLE IF EXIST ' . $name);
    }
    
    function showTblsList()
    {
        if( $this->pdo )
            return $this->pdo->query('SHOW TABLES');
        else
            return null;
    }
    
    function getSqlQueryHeader( $stmt, $arHeader = ["*"], $separator = ',', $sqlreport_quotation = '' ) 
    {
        
        $strHeader = '';
        
        if( !$stmt )
            return false;

        if( !$arHeader )
            return "";
        
        $sqlres = $stmt->fetchAll();
        
        foreach ( $sqlres[0] as $fieldName => $val )
        {

            if( in_array( $fieldName, $arHeader ) || ($arHeader[0] == "*") )
            {

                if( $strHeader )
                    $strHeader .= $separator;

                $strHeader .= $sqlreport_quotation . $fieldName . $sqlreport_quotation;

            }

        }

        return $strHeader;
    }

    function getSqlQuery( $stmt, $arHeader = ["*"], $separator=',', $sqlreport_quotation = '' ) 
    {

        $strQueryResultText = "";
        
        if( !$stmt )
            return false;

        if( $arHeader == '' )
            $arHeader = ["*"];
        
        $sqlres = $stmt->fetchAll();
        var_dump($sqlres);
        
        foreach ( $sqlres as $fieldName => $val )
        {
            var_dump($fieldName);
            var_dump($val);
        }
        return;
        while( $sqlrow = $sqlres->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT, 0) )
        {
            
            $strQueryResultLine = '';

            foreach ( $sqlrow as $fieldName => $rowValue )
            {
                if( in_array( $fieldName, $arHeader ) || ($arHeader[0] == "*") || !$arHeader )
                {

                    if( $strQueryResultLine )
                        $strQueryResultLine .= $separator;

                    $strQueryResultLine .= $sqlreport_quotation . $rowValue . $sqlreport_quotation;

                }

            }
            
            $strQueryResultText .= $strQueryResultLine . PHP_EOL;

        }
        
        return $strQueryResultText;

    }

    function getCountQueryRow( $sqlres )
    {
        
        if( !$sqlres )
            return false;
        
        return $sqlres->num_rows;
        
    }

    function printSqlQueryHeader( $stmt, $arHeader = ["*"], $separator = ',', $sqlreport_quotation = '', $br = PHP_EOL ) 
    {
        if( !$arHeader )
            return false;
        
        printf( "%s", $this->getSqlQueryHeader($stmt, $arHeader, $separator, $sqlreport_quotation) . $br );
        
        return true;
        
    }
    
    function printSqlQuery( $stmt, $arHeader = ["*"], $separator = ',', $sqlreport_quotation = '', $br = PHP_EOL ) 
    {
        
        printf( "%s", $this->getSqlQuery($stmt, $arHeader, $separator, $sqlreport_quotation) . $br );
        
    }
    
    function fprintSqlQueryHeader( $sqlres, $arHeader = ["*"], $separator = ',', $sqlreport_quotation = '', $br = PHP_EOL ) 
    {

        if( !$outputHandler || !$sqlres )
            return FALSE;
        
        fprintf( $outputHandler, "%s", $this->getSqlQueryHeader($sqlres, $arHeader, $separator, $sqlreport_quotation) . $br );
        
    }

    function fprintSqlQuery( $sqlres, $arHeader = ["*"], $separator = ',', $sqlreport_quotation = '', $br = PHP_EOL ) 
    {

        if( !$outputHandler || !$sqlres )
            return FALSE;
        
        fprintf( $outputHandler, "%s", $this->getSqlQuery($sqlres, $arHeader, $separator, $sqlreport_quotation) . $br );
        
    }
    
    function getSelectFromFile($filename)
    {
        if( !file_exists( $filename ) )
            return false;
        
        $arQueryText = file($filename);
        
        return implode( ' ', $arQueryText );
        
        print_r($arQueryText);
    }
    
    
    // end class
}
