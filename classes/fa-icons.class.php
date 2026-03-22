<?php

class Fa_icons {

    protected string $_sMetaurl="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/refs/heads/master/metadata/icons.json";

    protected string $_sMetafile='../metadata/icons.json';
    protected string $_sIconList='../metadata/_icons.json';
    protected string $_sClassList='../metadata/_classes.json';


    public function __construct() {
        // if(!file_exists(__DIR__."/$this->_sMetafile")) {
        //     die("No metadata file found. Start './getMetadata.sh' in the terminal first.");
        // }
        if(
            !file_exists(__DIR__."/$this->_sMetafile")
            || !file_exists(__DIR__."/$this->_sIconList") 
            || filemtime(__DIR__."/$this->_sMetafile") > filemtime(__DIR__."/$this->_sIconList")) 
        {
            $this->generateIconList();
        }
        
    }

    // ----------------------------------------------------------------------
    //
    //  Prepare reduced metadata
    //
    // ----------------------------------------------------------------------

    /**
     * Get raw data
     * It downloads metadata file if neded.
     * 
     * @return array
     */
    protected function _getRawIconList():array {
        if(!file_exists(__DIR__."/".$this->_sMetafile)){
            if(!file_put_contents(__DIR__."/".$this->_sMetafile, file_get_contents($this->_sMetaurl))){
                unlink(__DIR__."/".$this->_sMetafile);
                die("Saving download failed. Url: 'metadata '$this->_sMetaurl'.");
            }
        }
        return json_decode(file_get_contents(__DIR__."/".$this->_sMetafile), true)?:[];
    }

    /**
     * Generate reduced metadata file from raw data
     * 
     * @param array $aOptions
     * @return bool
     */
    public function generateIconList(array $aOptions=[]):bool 
    {

        $bFreeOnly=$aOptions['onlyfree']??false;
        $bIncludeBrands=$aOptions['brands']??true;

        $aIcons=[];
        $aClasses=[];

        // echo __METHOD__."()\n";
        foreach($this->_getRawIconList() as $key => $data) {
            $bDo=true;
            if($bFreeOnly and !$data['free']??false){
                $bDo=false;
            }
            if(in_array("brands", $data['styles']) and !$bIncludeBrands){
                $bDo=false;                
            }
            if($bDo){
                $aIcons[$key]=[
                    "label" => $data['label']??$key,
                    "unicode" => $data['label']??$key,
                    "search" => $data['search']??[],
                    "styles" => $data['styles'],
                    "free" => $data['free'],
                ];

                foreach($data['free'] as $sType) {
                    $sClass="fa-$sType fa-$key";
                    $aClasses[$sClass]=[
                        'label'=>$aIcons[$key]['label'],
                        'search'=>array_merge([$sType], $data['search']['terms']??[]),
                        'free'=>in_array($sType, $aIcons[$key]['free']),
                        'brand'=>$sType=='brands' && in_array($sType, $aIcons[$key]['styles']),
                    ];
                }
            }
        }
        // echo "Writing $this->_sIconList ...\n";
        file_put_contents(__DIR__."/$this->_sIconList", json_encode($aIcons, JSON_PRETTY_PRINT));
        // echo "Writing $this->_sClassList ...\n";
        file_put_contents(__DIR__."/$this->_sClassList", json_encode($aClasses, JSON_PRETTY_PRINT));
        return true;
    }

    // ----------------------------------------------------------------------
    //
    //  PUBLIC
    //
    // ----------------------------------------------------------------------

    public function getClassList():array {
        return json_decode(file_get_contents(__DIR__."/$this->_sClassList"), true)?:[];
    }
}