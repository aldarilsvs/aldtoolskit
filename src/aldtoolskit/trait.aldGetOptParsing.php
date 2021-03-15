<?php

namespace aldarilsvs\aldtoolskit;

trait aldGetOptParsing {
    
    protected function parsingOptionsEngine($options,$opt_vars)
    {
        
        foreach( $options as $key => $val )
        {
            $inp_args = [];

            if( !is_array($val) )
                $inp_args[] = $val;
            else
                $inp_args = $val;

            if( array_key_exists($key, $opt_vars) )
            {
                call_user_func_array($opt_vars[$key], $inp_args);
            }
        }
        
    }
    
    
}
