<?php
App::uses('AppController', 'Controller');
class StreamController extends AppController {

    public function display() {
        App::uses('TwitchApi', 'Lib');
        $this->TwitchApi = new TwitchApi();    
        if(empty($this->params->query['game'])) {
            throw new Exception('No game given');
        }
        
        $streams = $this->TwitchApi->SearchStreams('q='.urlencode($this->params->query['game']).'&limit=100');
        $this->set('streams', $streams);
    }
}
