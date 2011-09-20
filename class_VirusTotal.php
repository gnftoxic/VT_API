<?php
/*
 * VirusTotal PHP API by gnftoxic (subv3rsion)
 * Version 1.0-r1 (September 20th, 2011)
 */
class class_VirusTotal
{
    var $apiKey;
    
    function VirusTotal($api)
    {
        $this->apiKey = $api;
    }
    
    public function scanFile($fileName)
    {
        if(!file_exists($fileName))
        {
            return array( 'error' => 'The specified file does not exist.' );
        }
        return array( 'error' => 'An unknown error occured, we have reached end of request.' );
    }
    
    public function fetchResults($hash)
    {
        
        return null;
    }
    
    public function fetchKey()
    {
        return $this->apiKey;
    }
}
?>
