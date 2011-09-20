<?php
require_once("class_VirusTotal.php");
$vt = new VirusTotal( "insertapikey" );

$scan = $vt->scanURL("http://google.com/");

$report = $scan['report'];
$scanners = $report[1];

$amount = $detected = 0;

if($scan['result'])
{
    foreach($scanners AS $scanner => $result)
    {
        if($result)
        {
            print "Threat detected from $scanner ($result).<br />";
            $detected++;
        }
        $amount++;
    }

    print "<br />$detected out of $amount web scanners found a threat or have not yet rated this web page.<br />";
} else {
    print "The requested file scan was not found.";
}

print "<pre>";
print_r($scan);
print "</pre>";

?>
