<?php

namespace aldarilsvs\aldtoolskit;

/**
 *
 * @author aldaril
 */
trait aldIniFile {
    
    use aldArrayContent;

    protected $_iniPath;
    protected $_contentIniFile = [];
    protected $_reportsDir;
        
    public function ald_getScriptName()
    {
        // filter_input(INPUT_SERVER, 'SCRIPT_FILENAME') === $_SERVER['SCRIPT_FILENAME']
        return  filter_input(INPUT_SERVER, 'SCRIPT_FILENAME');
    }
    
    public function ald_getScriptDirPath()
    {
        return rtrim( pathinfo($this->ald_getScriptName())['dirname'], "\/" ) . DIRECTORY_SEPARATOR;
    }
    
    protected function ald_setDefaultIniPath()
    {
        $this->ald_setIniPath( $this->ald_getScriptDirPath() . pathinfo( $this->ald_getScriptName() )['filename'] . '.ini' );
    }
    
    private function ald_setIniPath($param)
    {
        $this->_iniPath = $param;
    }
    
    protected function ald_getIniPath()
    {
        return $this->_iniPath;
    }
    
    private function getItemIniContent()
    {

        $inpargs = (array) func_get_args();
        
        array_unshift($inpargs, $this->_contentIniFile);
        
        return call_user_func_array( array($this, "getContentItemArray"), $inpargs );
        
    }
    
    public function printDumpContentIniFile()
    {
        print_r( (array) $this->_contentIniFile);
        echo PHP_EOL;
    }


    protected function readIniFile($pathini='')
    {
        
        if( $pathini == '' )
            $pathini = $this->ald_getIniPath();
        
        if( !file_exists($pathini) )
        {
            \aldarilsvs\aldtoolskit\aldDebugMessage::echo('Ini file ' . $pathini . ' not found');
            return false;
        }
        
        $parseIni = new \IniParser($pathini);
        
        $this->_contentIniFile = $parseIni->parse();

        return true;
        
    }
    
    protected function parsingIniContent()
    {
//        example
//        if( $this->getItemIniContent('main','field') )
//            $this->setReportsDir($this->getItemIniContent('config','report_dir'));
    }

    // end trait
}
