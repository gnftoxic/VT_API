<?php
/*
 * VirusTotal PHP API by gnftoxic (subv3rsion)
 * Version 1.0-r1 (September 20th, 2011)
 */
class VirusTotal
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
        $result = $this->interact("/api/get_file_report.json", array( 'resource' => $hash));
        return $result;
    }

    public function fetchKey()
    {
        return $this->apiKey;
    }

    private function interact($url, $data)
    {
        $data = array_merge($data, array('key' => $this->apiKey));

        $ch = curl_init();

        foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'&');

        curl_setopt($ch, CURLOPT_URL, "https://www.virustotal.com/" . $url);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result);
    }
}
?>
