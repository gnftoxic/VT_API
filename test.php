<?php
require_once("class_VirusTotal.php");
$vt = new VirusTotal( "insertapikey" );
$scan = $vt->fetchResults( "md5/sha1/sha256" );

$report = $scan->report;
$scanners = $report[1];

foreach($scanners AS $scanner => $result)
{
    if(strlen($result) > 0)
    {
        print "Threat detected from $scanner ($result).<br />";
        $detected++;
    }
    $amount++;
}

print "<br />$detected out of $amount virus scanners found a threat.<br />";
print "<a href='{$scan->permalink}'>VirusTotal.com Report</a>";


print "<pre>";
print_r($report);
print "</pre>";
?>
