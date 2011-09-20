<?php
/*
 * VirusTotal PHP API by gnftoxic (subv3rsion)
 * Version 1.0-r3 (September 20th, 2011)
 */ 
class VirusTotal
{
    var $apiKey;
    var $SSL;

    function VirusTotal($api, $ssl)
    {
        $this->apiKey = $api;
        $this->SSL = $ssl;
    }

    public function scanFile($fileName)
    {
        $result = $this->interact("/api/scan_file.json", array('file' => "@".$fileName), true);
        
        if(!file_exists($fileName))
        {
            return array( 'error' => 'The specified file does not exist.' );
        }
        
        if(is_array($result))
        {
            $scanid = explode("-", $result['scan_id']);
            $result['scan_id'] = $scanid[0];
            $result['time_submit'] = $scanid[1];
            return array_merge($result, array('md5' =>  md5_file($fileName)));
        }
        return array( 'error' => 'An unknown error occured, we have reached end of request.' );
    }

    public function scanURL($url)
    {
        $result = $this->interact("/api/get_url_report.json", array ( 'resource' => $url, 'scan' => 1 ));
        return $result;
    } 
 
    public function fetchResults($hash)
    {
        $result = $this->interact("/api/get_file_report.json", array( 'resource' => $hash));
        return $result;
    }

    public function fetchKey()
    {
        return $this->apiKey;
    }

    private function interact($url, $data, $file = false)
    {
        $data = array_merge(array('key' => $this->apiKey), $data);

        $ch = curl_init();

        if(!$file)
        {
            foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string,'&');
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        } else {
            $fields_string = $data;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        }
        
        curl_setopt($ch, CURLOPT_URL, "http" . ($this->SSL ? "s" : "") . "://www.virustotal.com/" . $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }
}
?>
