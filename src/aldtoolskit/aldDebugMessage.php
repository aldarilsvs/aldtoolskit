<?php

namespace aldarilsvs\aldtoolskit;

if( !defined('ALD_DEBUG_INFO_ON'))
    define('ALD_DEBUG_INFO_ON', true);

if( !defined('ALD_DEBUG_INFO_OFF'))
    define('ALD_DEBUG_INFO_OFF', false);

if( !defined('ALD_DEBUG_STACK_ON'))
    define('ALD_DEBUG_STACK_ON', true);

if( !defined('ALD_DEBUG_STACK_OFF'))
    define('ALD_DEBUG_STACK_OFF', false);

/**
 * View message with detailed debug information
 * 
 * for use: 
 * once run function:
 * \aldtoolskit\Ald_ViewDebugMessage::setOnViewDebugMessage()
 * 
 * if run
 * \aldtoolskit\Ald_ViewDebugMessage::setOffViewDebugMessage()
 * then print only output string
 * 
 * For view message on screen:
 * \aldtoolskit\Ald_ViewDebugMessage::printMessage('My test string')
 *
 * if run
 * \aldtoolskit\Ald_ViewDebugMessage::setOnViewDebugStack()
 * then after our message print backtrace stack 
 * 
 * for write message to log file
 * \aldtoolskit\Ald_ViewDebugMessage::setOnWriteJournal();
 * 
 * for auto write messagew to log file
 * \aldtoolskit\Ald_ViewDebugMessage::setOnAutoWriteJournal();
 * 
 * set path to log file
 * \aldtoolskit\Ald_ViewDebugMessage::setJournalFile("/path/to/logfile/log.txt");
 * 
 * use with alias
 * 
 * use \aldtoolskit\Ald_ViewDebugMessage as AldDebug;
 * 
 * AldDebug::setOnViewDebugMessage();
 * AldDebug::setOnViewDebugStack();
 * AldDebug::printMessage('text in script');
 * 
 * @author aldaril
 */

class aldDebugMessage {
    
    static private $_flViewDebugInfo  = false;
    static private $_flViewDebugStack = false;
    static private $_flWriteJournal   = false;
    static private $_flAutoWriteJournal = false;
    
    static private $_journalObject;

    // public function
    static public function setOnViewDebugMessage()
    {
        self::$_flViewDebugInfo = true;
    }
    
    static public function setOffViewDebugMessage()
    {
        self::$_flViewDebugInfo = false;
    }
    
    static public function isViewDebugMessage()
    {
        return self::$_flViewDebugInfo;
    }
    
    static public function setOnViewDebugStack()
    {
        self::$_flViewDebugStack = true;
    }
    
    static public function setOffViewDebugStack()
    {
        self::$_flViewDebugStack = false;
    }
    
    static public function isViewDebugStack()
    {
        return self::$_flViewDebugStack;
    }
    
    static public function setOnWriteJournal()
    {
        self::$_flWriteJournal = true;
    }
    
    static public function setOffWriteJournal()
    {
        self::$_flWriteJournal = false;
    }
    
    static public function isWriteJournal()
    {
        return self::$_flWriteJournal;
    }
    
    static public function setOnAutoWriteJournal()
    {
        self::$_flAutoWriteJournal = true;
    }

    static public function setOffAutoWriteJournal()
    {
        self::$_flAutoWriteJournal = false;
    }

    static public function isAutoWriteJournal()
    {
        return self::$_flAutoWriteJournal;
    }

    static public function setJournalFile($file)
    {
        self::$_journalObject = \aldarilsvs\aldtoolskit\aldJournalLog::setJournalFile($file);
        return self::$_journalObject;
    }
    
    static protected function convertMessageArrayToString($msg)
    {
        return var_export($msg);
    }
    
    static public function getDebugMessage( $msg, $debuginfo=ALD_DEBUG_INFO_OFF,$id = 1 )
    {
        $msg_output = '';
        
        if( is_array($msg) || is_object($msg) )
            $msg = self::convertMessageArrayToString($msg);
        
        if( $debuginfo == ALD_DEBUG_INFO_ON || self::isViewDebugMessage() )
        {
            
            $backtrace = debug_backtrace();
            
            $class = ( isset($backtrace[$id+1]['class']) ? $backtrace[$id+1]['class'] : '' );
            $funct = ( isset($backtrace[$id+1]) ? $backtrace[$id+1]['function'] : '' );
            
            $file  = ( isset($backtrace[$id]['file'] ) ? $backtrace[$id]['file'] : '' );
            if( $file )
                $file = pathinfo ($file)['basename'];
            
            $line  = ( isset($backtrace[$id]['line']) ? $backtrace[$id]['line'] : '' );

            $msg_output = $file . ': ' . $line . ' ' . ( $class ? '\\' . $class . '\\' : '' ) . 
                          ( $funct ? $funct . '() ' : '' );

            if( $msg )
                $msg = '\'' . $msg . '\'';
        }
        
        if ( $msg )
            $msg_output .= PHP_EOL;
        
        return $msg_output . $msg;
    }
    
    static public function echo( $msg='', $debuginfo=ALD_DEBUG_INFO_OFF, $debugstack=ALD_DEBUG_STACK_OFF,$offset=2 )
    {
        self::printMessage($msg, $debuginfo, $debugstack, $offset);
    }
    
    static public function printMessage( $msg='', $debuginfo=ALD_DEBUG_INFO_OFF, $debugstack=ALD_DEBUG_STACK_OFF,$offset=1 )
    {
        $output_msg = self::getDebugMessage($msg, $debuginfo, $offset);
        
        if( $output_msg )
            printf( "%s\n", $output_msg );
        
        if( self::isAutoWriteJournal() && self::$_journalObject )
            self::$_journalObject->writeMessageToJournal($msg);
        
        if( self::isViewDebugStack() || $debugstack )
            self::printBacktrace($offset+1);
        
        if( self::isAutoWriteJournal() )
        {
            self::$_journalObject->writeMessageToJournal( PHP_EOL.self::getBacktrace(2) );
        }
    }
    
    static public function getBacktrace($offset=0)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        
        $msg_backtrace = '';
        
        foreach( $backtrace as $id => $item )
        {
            $class = ( isset($backtrace[$id+1+$offset]) && isset($backtrace[$id+1+$offset]['class']) ? 
                       $backtrace[$id+1+$offset]['class'] : '' );
            $funct = ( isset($backtrace[$id+1+$offset]) && isset($backtrace[$id+1+$offset]) ? 
                       $backtrace[$id+1+$offset]['function'] : '' );
            $file  = ( isset($backtrace[$id+$offset]) && isset($backtrace[$id+$offset]['file'] ) ? 
                       $backtrace[$id+$offset]['file'] : '' );
            $line  = ( isset($backtrace[$id+$offset]) && isset($backtrace[$id+$offset]['line']) ? 
                       $backtrace[$id+$offset]['line'] : '' );
            
            if( isset($backtrace[$id+$offset]) )
            {
                $msg_backtrace .= '# ' . $id . ' '. pathinfo($file)['basename'] . ':' . $line . ' ' 
                . ($class ? $class .'\\' : '' )  . ($funct ? $funct . '()' : '' ) . PHP_EOL;
            }
            
        }
        
        return $msg_backtrace;
    }
    
    static public function printBacktrace($offset)
    {
        echo self::getBacktrace($offset);
    }
    
    static public function bp()
    {
        self::echo( '', ALD_DEBUG_INFO_ON, ALD_DEBUG_STACK_OFF, 3 );
    }
    
    
    // end class
}
