<?php
class TwitchApi extends Object {
    private function Send($pRequest, $pUrl = null) {
        if(empty($pUrl)) {
            $pUrl = Configure::read('Twitch.ApiURL');
        }
        $pUrl .= '/' . $pRequest;
        return json_decode(@file_get_contents($pUrl), true);
    }
    
    function GetBroadCasts($pUsername) {
        $info = $this->Send('channels/' . $pUsername. "/videos?broadcasts=true");
        return $info['videos'];
    }
    
    function GetBroadcastInfo($pID) {
        if(ctype_alpha($pID[0])) { $pID = substr($pID, 1, strlen($pID)); }
        return $this->Send('broadcast/by_archive/'. $pID .'.json' , 'http://api.justin.tv/api/');
    }
    
    function GetGames() {
        return $this->Send('games/top');
    }
    
    function SearchStreams($pQuery) {
        return $this->Send('/search/streams?'.$pQuery);
    }
    
    function GetVideos($pName, $pBroadcasts = false) {
        return $this->Send('/channels/'.$pName.'/videos?broadcasts='.(($pBroadcasts) ? 'true' : 'false'));
    }
    
    function GetVideoInfo($pID) {
        return $this->Send('/videos/' . $pID);
    }
}