<?php
class Ffmpeg extends Object {
    function Combine($pFiles, $pTarget) {
        $combinefile = dirname($pTarget). DS . 'combine.txt';
        if(file_exists($combinefile)) { unlink($combinefile); }
        foreach($pFiles as $file) {
            file_put_contents($combinefile, "file '$file'\n", FILE_APPEND);
        }
        if(file_exists($pTarget)) { unlink($pTarget); }
        
        $command = "ffmpeg -f concat -i " .escapeshellarg($combinefile). " -c copy ".escapeshellarg($pTarget);
        exec($command, $array,$exit_code);
        
        unlink($combinefile);
    }
    
    function ConvertBroadcast($pSource, $pTarget) {
        if(file_exists($pTarget)) { return; }
        $command = "/usr/bin/ffmpeg -i ".escapeshellarg($pSource)." -c:a copy -c:v copy -profile:v baseline " . escapeshellarg($pTarget);
        exec($command, $array,$exit_code);
    }
}