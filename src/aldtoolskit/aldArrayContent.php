<?php

namespace aldarilsvs\aldtoolskit;

trait aldArrayContent
{
    // first arg - array for search!
    private function getContentItemArray()
    {
        
        if ( func_num_args() == 0 )
            return null;
        
        $result = func_get_arg(0);
        
        if ( func_num_args() == 1 )
        {
            return (array) $result;
        }
        
        for( $i = 1; $i < func_num_args(); $i++ ) 
        {
            if( isset($result[func_get_arg($i)] ) )
                $result = (array) $result[func_get_arg($i)];
            else
                return null;
        }
        
        return (array) $result;
    }
    
}
