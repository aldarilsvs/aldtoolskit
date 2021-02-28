<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace aldarilsvs\aldtoolskit;

/**
 * Description of aldCrontab
 *
 * @author aldaril
 */
abstract class aldCrontab
{
    protected $_crontabString;
    
    protected $_yearMatrix = [];
    
    public function __construct($param='')
    {
        $this->initYearMatrix();
        
        if( $param )
            $this->setCrontabInit ($param);
    }
    
    public function setCrontabInit($param)
    {
        $this->_crontabString = $param;
        
        $this->parsingCrontab();
    }
    
    protected function initYearMatrix()
    {
        for( $month = 1; $month <= 12; $month++ )
        {
            for( $day = 1; $day <= 31; $day++ )
            {
                for( $hour = 0; $hour < 24; $hour++ )
                {
                    for( $minutes = 0; $minutes < 60; $minutes++ )
                    {
                        $this->_yearMatrix[$month][$day][$hour][$minutes] = 0;
                    }
                }
            }
        }
    }


    abstract protected function parsingCrontab();

    /*
     * work time has come
     * return type: bool
     */
    public function isWorkItNow($param)
    {
        
    }
    
    /*
     * get close execution time
     * return type: int (universe time format in second)
     */
    public function getSoonWork( $checktime )
    {
        return time();
    }


    // end class
}
