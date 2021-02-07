<?php

class testA
{
    public function __construct()
    {
        if( __NAMESPACE__ )
            echo __NAMESPACE__ . '/';
        echo __CLASS__ . ' ' . PHP_EOL;
        echo __DIR__ . '/' . __FILE__ . ':' . __LINE__ . PHP_EOL;
    }
}
