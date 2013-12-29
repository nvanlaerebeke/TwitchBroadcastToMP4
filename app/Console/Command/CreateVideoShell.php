<?php

class CreateVideoShell extends Shell {
    public $uses = array('Download', 'Ffmpegjob');
        
    public function main() {
        App::uses('TwitchApi', 'Lib');
        $this->TwitchApi = new TwitchApi();    
        
        App::uses('TwitchDownload', 'Lib');
        $this->TwitchDownload = new TwitchDownload(); 
        
        App::uses('Ffmpeg', 'Lib');
        $this->Ffmpeg = new Ffmpeg(); 
       
        
        $this->CreateVideo($this->args[0]);
    }
    
    private function CreateVideo($pID) {
        $broadcast_info = $this->TwitchApi->GetBroadcastInfo($pID);

        //clean old data
        $this->Ffmpegjob->deleteAll(array('broadcast_id' => $this->args[0]));
        $this->Download->deleteAll(array('broadcast_id' => $broadcast_info[0]['broadcast_id']));
        
        $filename = $broadcast_info[0]['broadcast_id'];

        //final file names
        $file = TMP . DS . 'downloads'.DS.$broadcast_info[0]['broadcast_id']. DS .$filename.'.flv';
        $final = ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'final'. DS . $broadcast_info[0]['broadcast_id']. DS .$filename.'.mp4';

        //if it is already converted 
        if(file_exists($final)) { exit; }

        //create dirs
        if(!file_exists(TMP . DS . 'downloads' . DS . $broadcast_info[0]['broadcast_id'])) {
            mkdir(TMP . DS . 'downloads' . DS .$broadcast_info[0]['broadcast_id'], 0777, true);
        }
        if(!file_exists(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'final'. DS . $broadcast_info[0]['broadcast_id'])) {
            mkdir(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'final'. DS . $broadcast_info[0]['broadcast_id'], 0777, true);
        }
        
        $downloads = $this->TwitchDownload->DownloadBroadCast($broadcast_info, $file);
        $finals = array();
        foreach($downloads as $download) {
            $job['Ffmpegjob']['id'] = String::uuid();
            $job['Ffmpegjob']['type'] = 'Conversion';
            $job['Ffmpegjob']['broadcast_id'] = $pID;
            $job['Ffmpegjob']['video_id'] = str_replace('.flv', '', $download['Download']['path']);
            $job['Ffmpegjob']['status'] = 'Busy';
            $this->Ffmpegjob->save($job);
            
            $target = str_replace('.flv', '.mp4', $download['Download']['path']);
            $finals[] = $target;
            $this->Ffmpeg->ConvertBroadcast($download['Download']['path'], $target);
            
            if(file_exists($target)) {
                $job['Ffmpegjob']['status'] = 'Done';
                $this->Ffmpegjob->save($job);
            } else {
                $job['Ffmpegjob']['status'] = 'Failed';
                $this->Ffmpegjob->save($job);
            }
        }
        
        $job['Ffmpegjob']['id'] = String::uuid();
        $job['Ffmpegjob']['type'] = 'Combining';
        $job['Ffmpegjob']['broadcast_id'] = $pID;
        $job['Ffmpegjob']['status'] = 'Busy';
        $this->Ffmpegjob->save($job);
            
        $this->Ffmpeg->Combine($finals, $final);
        
        $job['Ffmpegjob']['status'] = 'Done';
        $this->Ffmpegjob->save($job);        
        
        //clean up
        App::uses('Folder', 'Utility');
        $folder = new Folder(TMP . DS . 'downloads' . DS .$broadcast_info[0]['broadcast_id']);
        $folder->delete();
    }
}