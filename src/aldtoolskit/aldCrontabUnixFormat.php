<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// довести до ума
// взять в качестве примера ранюю реализацию из orders_check

namespace aldarilsvs\aldtoolskit;

/**
 * Description of aldCrontabUnixFormat
 *
 * @author aldaril
 */
class aldCrontabUnixFormat extends aldCrontab
{
    public function __construct($param='')
    {
        parent::__construct($param);
    }
    
    protected function parsingCrontab()
    {
        $parsing = explode( ';', $this->_crontabString );
        
        var_dump($parsing);
    }
    
    public function displayCrontabMatrix()
    {
        print_r($this->_yearMatrix);
    }
    
}
