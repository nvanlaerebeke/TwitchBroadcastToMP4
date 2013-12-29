TwitchBroadcastToMP4
====================

Introduction
=============
TwitchBroadcastToMP4 automates a few steps so you can watch broadcasts on your mobile devices(example android tablet).

It helps you do the following:
- Download all parts of a broadcast(twitch splits them in 30min clips)
- Convert all clips to mp4's that are supported by mobile devices
- Merges all clips into 1 file
- Gives you a UI to browse and see progress directly from your browser/mobile device

It's written in php and uses the CakePHP framework.

Requirements
============

- ffmpeg 1.1 or higher for the concat demuxer
- php 5.3+
- Centos or any other Rathad based OS, others might work or need tweaks to the exec's 
- sqlite3 by default, can be switched to any other DB(sql schema included in db directory)
- Diskspace and a good internet connection! - these flv's can be BIG

Installation
=============

Steps for installation:

- Check out the source
- chown the entire directory so apache has r/w access on 'db/twitch.sqlite', 'app/tmp' and 'app/webroot'
- make sure mod_rewrite is on and allowed for the webroot

Usage
=====

Point your browser to the application. 

You'll be able to browse to the games and live streamers.
On the homepage you can search for steamers in case they're not on-line