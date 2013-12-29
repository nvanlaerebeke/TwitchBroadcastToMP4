<?php
App::uses('AppController', 'Controller');
class VideoController extends AppController {
    public $uses = array('Download', 'Ffmpegjob');
    
    public function display($pID, $pHightlight = false) {
        App::uses('TwitchApi', 'Lib');
        $this->TwitchApi = new TwitchApi();    

        $video_info = $this->TwitchApi->GetBroadcastInfo($pID);
        $filename = $video_info[0]['broadcast_id'];

        //final file names
        $file = TMP . DS . 'downloads'.DS.$video_info[0]['broadcast_id']. DS .$filename.'.flv';
        $final = ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'final'. DS . $video_info[0]['broadcast_id']. DS .$filename.'.mp4';

        if(!file_exists($final)) {
            exec('ps -elf | grep -v grep | grep -i ' . $pID, $output);
            //not running and file doesn't exist, so start the download/conversion process
            if(count($output) == 0) { 
                $command = 'cd ' . ROOT . DS . APP_DIR . '; ' . CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Console' . DS . 'cake CreateVideo ' . $pID.' > /dev/null 2>/dev/null &';
                exec($command);
            }
            $this->set('canview', false);            
        } else {
            $this->set('canview', true);
        }
        
        $broadcast = $this->TwitchApi->GetVideoInfo($pID);
        $downloads = $this->Download->find('all', array('conditions' => array('broadcast_id' => $video_info[0]['broadcast_id'])));
        $ffmpegjobs = $this->Ffmpegjob->find('all', array('conditions' => array('broadcast_id' => $pID)));
        
        $downloaded = 0;
        $totalsize = 0;
        $downloadedsize = 0;
        foreach($downloads as $download) {
             if($download['Download']['status'] == 'Done') { $downloaded++; }
             
             $totalsize+= $download['Download']['size'];
             $downloadedsize+= (file_exists($download['Download']['path'])) ? filesize($download['Download']['path']) : 0;
        }
        
        $this->set('broadcast', $broadcast);
        $this->set('video_info', $video_info);
        
        $this->set('downloads', $downloads);
        $this->set('downloaded', $downloaded);
        $this->set('downloadedsize', $downloadedsize);
        $this->set('totaldownloadsize', $totalsize);
        
        $this->set('ffmpegjobs', $ffmpegjobs);       
    }
}
