<?php

namespace aldarilsvs\aldtoolskit;

/**
 *
 * @author aldaril
 */
trait aldIniFile {

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
        $result = $this->_contentIniFile;
        
        for( $i = 0; $i < func_num_args(); $i++ ) 
        {
            if( isset($result[func_get_arg($i)] ) )
                $result = $result[func_get_arg($i)];
            else
                return null;
        }
        
        return $result;
    }
    
    protected function readIniFile($pathini='')
    {
        
        if( $pathini == '' )
            $pathini = $this->ald_getIniPath();
        
        if( !file_exists($pathini) )
        {
            \aldarilsvs\aldtoolskit\aldDebugMessage::echo('Ini file not found');
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
