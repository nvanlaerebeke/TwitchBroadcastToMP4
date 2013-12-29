<?php
App::uses('AppController', 'Controller');
class StreamController extends AppController {

    public function beforeFilter() {
        App::uses('TwitchApi', 'Lib');
        $this->TwitchApi = new TwitchApi();    
    }

    public function display() {
        if(empty($this->params->query['game'])) {
            throw new Exception('No game given');
        }
        
        $streams = $this->TwitchApi->SearchStreams('q='.urlencode($this->params->query['game']).'&limit=100');
        $this->set('streams', $streams);
    }
    
    public function Search() {
        $broadcaster = $this->TwitchApi->GetVideos($this->data['Search'], true);
        if(!empty($broadcaster) && count($broadcaster['videos']) > 0) {
            $this->redirect(array('controller' => 'Channel', 'action' => 'display', $this->data['Search']));
            return;
        }
        
        $streams = $this->TwitchApi->SearchStreams('q='.urlencode($this->data['Search']).'&limit=100');
        $this->set('streams', $streams);
        $this->render('display');
    }
}
