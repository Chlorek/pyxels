# Introduction
Pyxels is simply just a python script (and optional barebones PHP script) utilizing powers of *ffmpeg* on Linux systems.
Notice: project is far from finished but should work fine.

It is capable of three things:
* screenshots
* recording
* watching (like Nvidia's Shadow-Play - no longer current name but mostly recognizable)

# Features
* screenshot
* recording video
* buffer last minutes (aka shadow-play)
* custom framerate
* custom buffer time (for watch mode)
* auto-upload via http (with authorization)
* region selection
* easily setable encoder (defaults to h264_nvenc, so if you don't like it or have no GPU support - change it)

# Requirements
Script is written in Python 3 with use of modules (that you may most likely need to install) such as:
* pexpect
* Xlib
* requests
You may lack something else, I am not really sure what there is by default and what is not, python is not even my language.

The core feature - screen capture is done thanks to **ffmpeg**, so you need this installed. By default video codec **h264_nvenc** is used, which is *not* part of ffmpeg. If your video card supports it then I recommend to compile ffmpeg yourself with support for it (useful if you want to capture some of your games without impact on performance). Colors quality with h264_nvenc is not best, however should be fine if it's for simple, home use.

Optionally, one may want to automatically upload his screenshots and videos, in this case you need some web server with PHP.

Any way to execute shell commands with keybinds is highly recommended as pyxels does not come with built-in hot-keys support, it is controlled with signals instead (read installation for details).

# Installation / Usage
Once you have dependencies installed (I'll link *ffmpeg+nvenc* compilation later) there should be nothing left to do, but launch pyxels in terminal. You may want to make symbolic link inside bin directory for easy access. If you are planning to use *watch mode* you should consider having your */tmp* mounted in RAM - most distributions nowadays do it by default, however it might be good for your disk life to check it.

Finally, run it once (without arguments) to see if requirmenets are met.

Then,

use your window mananager or some sort of program to bind commands controlling video capture:
* pkill -RTMIN+5 pyxels
* pkill -RTMIN+6 pyxels

The first one is used to save video buffered in **watch mode**, the other stops both: **recording** and **watch** mode.

Test all three actions to ensure they work fine then proceed to binding screenshot / video etc. as you like.

Very basic PHP script included along is optional and used just in case you need auto-upload. Simply put it on your http(s) server, then (you should, but not have to) setup htaccess to require basic HTTP authorization to this script and create *uploads* directory (or different, edit *pyxels.php* as you wish).

## So how do I start this script right
There is **--help** included, however some things are left undocumented and I know some people are scared of CLI for some reason so I will cover some basic things here:

The most simple way to make use of pyxels is:
```
pyxels screenshot /path/to/output.png
```
or
```
pyxels record /path/to/output.mp4
```
or
```
pyxels watch /path/to/whatever.mp4
```
In case of watch: files are stored in different manner. Saved video is stored as series of 1-minute long clips (no worries, there are no frames lost between) in directory specified as output, filename is not used - you have to specify it anyway. Clips are named with date, time and order number.

You can also automatically name files in other modes, instead of filename use word **auto**. File extension is still required as output format is based on this - and that brings us to choosing format - that is determined automatically by extension. So if you need quality screenshots save them for example as png, otherwise use jpg.

Any action can be used along with selecting captured screen area, to enable picker add **-r** flag before action. Example:
```
pyxels -r screenshot area.jpg
```
Right-click or any keyboard input causes exit.

Auto-upload requires some server-side acceptor program, you can write your own, adapt existing or just use that simple php script included. Let's assume you have your server setup, to upload captured file use:
```
pyxels -s https://yourserver.addr/pyxels.php -u authName -p authPass record auto.mp4
```
If everything went okay, pyxels opens web browser with uploaded resource.
HTTP auth is not required but you *really* should set it up, or eventually use your custom implementation. Leaving it unprotected would let someone to upload whatever he likes to your server - one may upload some executable there which would be terrible - I think I don't have to say it, but better waste some letters than sorry.
