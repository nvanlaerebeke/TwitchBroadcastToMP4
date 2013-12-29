<?php
class TwitchDownload extends Object {
    function DownloadBroadcast($pBroadCastInfo, $pTarget) {
        App::uses('Download', 'Model');
        $this->Download = new Download();

        $tmp_dir = realpath(dirname($pTarget)).'/parts/';
        if(!file_exists($tmp_dir)) { mkdir($tmp_dir); }

        /**
         * Create Download DB entries
         */        
        $totalsize = 0;
        $downloads = array();
        for($i = 0; $i < count($pBroadCastInfo); $i++) {
            $part_file = $tmp_dir.'/'.$pBroadCastInfo[$i]['id'].'.flv';
            $totalsize += $pBroadCastInfo[$i]['file_size']; 
                        
            $download = $this->Download->create();
            $download['Download']['id'] = String::uuid();
            $download['Download']['broadcast_id'] = $pBroadCastInfo[$i]['broadcast_id'];
            $download['Download']['video_id'] = $pBroadCastInfo[$i]['id'];
            $download['Download']['path'] = $part_file;
            $download['Download']['size'] = $pBroadCastInfo[$i]['file_size'];
            $download['Download']['status'] = 'Downloading';
            $download['Download']['video_url'] = $pBroadCastInfo[$i]['video_file_url'];
            $this->Download->save($download);
            
            if(file_exists($part_file)) {
                if(filesize($part_file) == $pBroadCastInfo[$i]['file_size']) {
                    $download['Download']['status'] = 'Done';
                    $this->Download->save($download);
                } else {
                    unlink($part_file);
                }
            }        
            $downloads[] = $download;
        }

        /**
         * Check if the file was already downloaded, if it was, set all downloads as complete
         */
        if(file_exists($pTarget) && filesize($pTarget) == $totalsize) {
            $this->log("Download already complete, skipping...");
            
            for($i = 0; $i < count($downloads); $i++) {
                $downloads[$i]['Download']['status'] = 'Done';
                $this->Download->save($downloads[$i]);
            }
            return $downloads;
        }
        
        /**
         * We still need to download, start the downloads & set the downloads to Done/Failed
         */
        for($i = 0; $i < count($downloads); $i++) {
            if($downloads[$i]['Download']['status'] == 'Done') { continue; }
            
            $command = 'wget -c '.$downloads[$i]['Download']['video_url'].' -O '.escapeshellarg($downloads[$i]['Download']['path']);
            exec($command, $array,$exit_code);

            if(!file_exists($downloads[$i]['Download']['path']) || filesize($downloads[$i]['Download']['path']) != $downloads[$i]['Download']['size']) {
                $downloads[$i]['Download']['status'] = 'Failed';
                $this->Download->save($downloads[$i]);
                throw new Exception("Failed to download $part_file, file does not exist or incorrect size");
            }
            
            $downloads[$i]['Download']['status'] = 'Done';
            $this->Download->save($downloads[$i]);
        }
        return $downloads;
    }
}