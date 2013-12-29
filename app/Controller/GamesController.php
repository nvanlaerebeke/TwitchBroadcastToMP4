<?php
App::uses('AppController', 'Controller');
class GamesController extends AppController {
    public $uses = array();
    
    public function display() {
       App::uses('TwitchApi', 'Lib');
       $this->TwitchApi = new TwitchApi();        
        
       $games = $this->TwitchApi->GetGames();
       $this->set('games', $games);
    }
}
