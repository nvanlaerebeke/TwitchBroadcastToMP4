<?php
App::uses('AppController', 'Controller');
class ChannelController extends AppController {
    
    public function display($pName) {
       App::uses('TwitchApi', 'Lib');
       $this->TwitchApi = new TwitchApi();
       
       $broadcasts = $this->TwitchApi->GetVideos($pName, true);
       $this->set('broadcasts', $broadcasts);
    }
}
