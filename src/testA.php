<?php

namespace aldarilsvs;

class testA
{
    public function __construct()
    {
        echo __CLASS__ . ' ';
        echo __DIR__ . '/' . __FILE__ . ':' . __LINE__ . PHP_EOL;
    }
}
