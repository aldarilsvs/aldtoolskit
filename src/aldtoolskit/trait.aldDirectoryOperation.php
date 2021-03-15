<?php

namespace aldarilsvs\aldtoolskit;

/**
 *
 * @author aldaril
 */
trait aldDirectoryOperation {
    
    // flWarning - show error messages
    protected function ald_createDir($dirpath, $flWarning=true)
    {

        if( file_exists($dirpath) && is_dir($dirpath) && is_writable($dirpath) )
                return true;
        
        if( file_exists($dirpath) && is_dir($dirpath) && !is_writable($dirpath) )
        {
            if( $flWarning )
                \aldarilsvs\aldtoolskit\aldDebugMessage::echo('Directory exist and write access denied');

            return false;
            
        }        
        
        if( file_exists($dirpath) && !is_dir($dirpath) )
        {
            if( $flWarning )
                \aldarilsvs\aldtoolskit\aldDebugMessage::echo($dirpath . ' is not directory');
            
            return false;
        }
        
        
//        // check permissions for write
//        if( !file_exists($dirpath) && !is_writable(pathinfo($dirpath)['dirname']) )
//        {
//            if( $flWarning )
//                \aldarilsvs\aldtoolskit\aldDebugMessage::echo('Directory creation error. Write access denied');
//
//            return false;
//        }
//
//        if( !file_exists($dirpath) && is_writable(pathinfo($dirpath)['dirname']) )
        {
            mkdir($dirpath,0777,true);

            // check created
            if( !file_exists($dirpath) )
            {
                if( $flWarning )
                    \aldarilsvs\aldtoolskit\aldDebugMessage::echo('Directory creation error');

                return false;
            }

            return true;
            
        }
            
        // unrecorded state
        aldarilsvs\aldtoolskit\aldDebugMessage::echo('Unrecorded state',1);
        
        return false;
    }
    
    

}
