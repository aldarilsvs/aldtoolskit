<?php

namespace aldarilsvs\aldtoolskit;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aldJournalLog
 *
 * @author aldaril
 */
class aldJournalLog
{
    private $_journalFile      = '';
    private $_journalHeader    = '[%Y-%m-%d %H:%i:%s]';
    static private $_instance;
    
    private function __construct()
    {
    }
    
    public function setJournalFile($file)
    {

        $splFile = new \SplFileInfo($file);
        
        $splDir = new \SplFileInfo(pathinfo($file)['dirname']);
        
        if( !self::$_instance )
            self::$_instance = new self;
        
        if( $splFile->isDir() || !$splDir->isWritable() )
        {
            self::$_instance->_journalFile = '';
        }
        else
        {
            self::$_instance->_journalFile = $file;
        }
        
        return self::$_instance;
    }

    public function getJournalFile()
    {
        return self::$_instance->_journalFile;
    }
    
    public function setJournalHeader($head)
    {
        self::$_instance->_journalHeader = $head;
    }
    
    public function getCanJournalWrite()
    {
        return ( self::$_instance->_journalFile ? true : false );
    }


    public function getJournalHeader()
    {
        $head = self::$_instance->_journalHeader;
        
        $subst = [
          "%Y"  => date("Y"),
          "%y"  => date("y"),
          "%m"  => date("m"),
          "%d"  => date("d"),
          "%H"  => date("H"),
          "%i"  => date("i"),
          "%s"  => date("s"),
        ];
        
        foreach( $subst as $key => $val )
        {
            $head = str_replace( $key, $val, $head );
        }
        
        return $head;
    }
    
    public function writeMessageToJournal($msg)
    {
        if( '' == self::$_instance->getJournalFile() || !self::$_instance->getCanJournalWrite() )
            return false;
        
        $head = self::$_instance->getJournalHeader();
        
        $msg = rtrim($msg);
        
        if( $head )
            $msg = $head . ' ' . $msg;
        
        $msg .= PHP_EOL;
        
        return ( file_put_contents( self::getJournalFile(), $msg, FILE_APPEND ) === false ? false : true );
    }

    
}
