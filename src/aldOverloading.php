<?php

namespace aldarilsvs\aldtoolskit;

/**
 * Description of Ald_Overloading
 *
 * @author aldaril
 */
trait aldOverloading
{
 
    private $_flViewMsg   = true;
    private $_flViewStack = false;
    private $_flStopAfterError = false;

    // private functions
    
    private function _typeProperty()
    {
        return 1;
    }
    
    private function _typeMethod()
    {
        return 2;
    }
    
    private function _getFlagViewMsg()
    {
        return $this->_flViewMsg;
    }
    
    private function _isFlagViewMsg()
    {
        return $this->_getFlagViewMsg();
    }

    private function _getFlagViewStack()
    {
        return $this->_flViewStack;
    }
    
    private function _isFlagViewStack()
    {
        return $this->_getFlagViewStack();
    }
    
    private function _getViewOverloadingUnknownProperty($name,$value=0)
    {
        $this->_getWarningMessageOverloading( 1, $name, $value);
    }
    
    private function _getViewOverloadingUnknownMethod($name,$args)
    {
        $this->_getWarningMessageOverloading( 2, $name, $args);
    }
    
    private function _findParamsInStackTrace($traceArray)
    {
        
        $result = array();
        
        $sizeTrace = count($traceArray);
        
        foreach( $traceArray as $i => $v )
        {
            if( strstr($traceArray[$i]['function'], '__' ) )
            {
                $result['file']     = $traceArray[$i]['file'];
                $result['line']     = $traceArray[$i]['line'];
                
                if( ($i+1) == $sizeTrace )
                {
                    $result['inside']   = false;
                    $result['function'] = '';
                    $result['class'] = '';
                }
                else
                {
                    $result['inside']   = true;
                    $result['function']     = $traceArray[$i+1]['function'];
                    $result['class']     = $traceArray[$i]['class'];
                }
                
                break;
            }
        }
        
        return $result;
        
    }

    private function _getWarningMessageOverloading( $typeMsg, $name, $value=0 )
    {
        $msg = '';
            
        try {
            throw new \ErrorException ( "" ) ;
        } catch (\Exception $e) {
            
            $traceArray = $e->getTrace();
            $sizeTrace  = count($traceArray);
            
            $result = $this->_findParamsInStackTrace($traceArray);
            
            switch ($typeMsg) {
                
                case 1:
                    if( $result['inside'] )
                    {
                        $msg = "Property $$name not found in \\" . 
                            $result['class'] . "\\" . $result['function'] . "() in " . 
                            $result['file'] . " : " . $result['line'];
                    }
                    else
                    {
                        $msg = "Property $$name not found in " . $result['file'] . " : " . $result['line'];
                    }
                    break;
                    
                case 2:
                    if( $result['inside'] )
                    {
                        $msg = "Method $name() not found in \\" . 
                            $result['class'] . "\\" . $result['function'] . "() in " . 
                            $result['file'] . " : " . $result['line'];
                    }
                    else
                    {
                        $msg = "Method $name() not found in " . $result['file'] . " : " . $result['line'];
                    }
                    break;

                default:
                    break;
            }
            
            if( $this->_isFlagViewMsg() )
                echo $msg . PHP_EOL;
            
            if( $this->_isFlagViewStack() )
                echo $e->getTraceAsString() . PHP_EOL;
            
        } // end try exception
    }
    
    // public functions
    
    public function setOnViewWarningOverloading()
    {
        $this->_flViewMsg = true;
    }

    public function setOffViewWarningOverloading()
    {
        $this->_flViewMsg = false;
    }

    public function setOnViewStackOverloading()
    {
        $this->_flViewStack = true;
    }

    public function setOffViewStackOverloading()
    {
        $this->_flViewStack = false;
    }

    public function __get ( string $name )
    {
        $this->_getViewOverloadingUnknownProperty($name);
    }
    
    public function __set ( string $name, $value )
    {
        $this->_getViewOverloadingUnknownProperty($name,$value);
    }
    
    public function __isset ( string $name )
    {
        $this->_getViewOverloadingUnknownProperty($name);
    }
    
    public function __unset ( string $name )
    {
        $this->_getViewOverloadingUnknownProperty($name);
    }
    
    public function __call ( string $name, array $args )
    {
        $this->_getViewOverloadingUnknownMethod( $name,$args );
    }
    
    public static function __callStatic ( string $name, array $args )
    {
        $obj = new self;
        $obj->_getViewOverloadingUnknownMethod($name, $args);
    }
    
    // end trait
}
