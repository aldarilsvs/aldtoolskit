<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace aldarilsvs\aldkit;

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
class aldViewDebugMessage {
    
    static private $_flViewDebugInfo  = false;
    static private $_flViewDebugStack = false;
    
    // private function
    
    // public function
    static public function setOnViewDebugMessage()
    {
        self::$_flViewDebugInfo = true;
    }
    
    static public function setOffViewDebugMessage()
    {
        self::$_flViewDebugInfo = false;
    }
    
    static public function setOnViewDebugStack()
    {
        self::$_flViewDebugStack = true;
    }
    
    static public function setOffViewDebugStack()
    {
        self::$_flViewDebugStack = false;
    }
    
    static public function printMessage($msg)
    {
        $backtrace = debug_backtrace();
        
        $id = 0;
        
        $class = ( isset($backtrace[$id+1]['class']) ? $backtrace[$id+1]['class'] : '' );
        $funct = ( isset($backtrace[$id+1]) ? $backtrace[$id+1]['function'] : '' );
        $file  = ( isset($backtrace[$id]['file'] ) ? $backtrace[$id]['file'] : '' );
        $line  = ( isset($backtrace[$id]['line']) ? $backtrace[$id]['line'] : '' );
        
        $msg_output = ( $class ? '\\' . $class . '\\' : '' ) . 
                      ( $funct ? $funct . '() ' : '' ) . $file . ' : ' . $line;
        
        if( self::$_flViewDebugInfo )
            printf( "%s\n", $msg_output );
        
        printf( "%s\n", $msg );
        
        if( self::$_flViewDebugStack )
            debug_print_backtrace ();
    }
    
    
}
